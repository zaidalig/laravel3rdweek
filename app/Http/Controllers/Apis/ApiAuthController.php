<?php

namespace App\Http\Controllers\Apis;

use App\Http\Controllers\Controller;
use App\Mail\VerifyMail;
use App\Models\User;
use App\Models\VerifyUser;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;
use Image;

class ApiAuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => [
                'required',
                'string',
                Password::min(8)
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
                    ->uncompromised(),

            ],
            'confirm_password' => 'required|same:password|min:8',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg',

        ]);
        if ($validator->fails()) {
            return response(['errors' => $validator->errors()->all()], 422);
        }
        $request['password'] = Hash::make($request['password']);
        $request['confirm_password'] = Hash::make($request['confirm_password']);

        if ($request->hasFile('image')) {
            $user = User::create($request->only(['title', 'name', 'email', 'confirm_password', 'password']));
            $user->image = $request->image->getClientOriginalName();
            $user->save();
        } else {
            $user = User::create($request->only(['title', 'name', 'email', 'confirm_password', 'password']));
        }
        $request['remember_token'] = Str::random(10);

        $verifyUser = VerifyUser::create([
            'user_id' => $user->id,
            'token' => sha1(time()),
        ]);
        Mail::to($user->email)
            ->send(new VerifyMail($user));
        $user->assignRole('User');

        $token = $user->createToken('Laravel Password Grant Client')->accessToken;
        $response = ['token' => $token];
        return response($response, 200);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required',
        ]);
        if ($validator->fails()) {
            return response(['errors' => $validator->errors()->all()], 422);
        }
        $user = User::where('email', $request->email)->first();
        if ($user) {
            if (Hash::check($request->password, $user->password)) {
                if ($user->verified) {
                    $token = $user->createToken('Laravel Password Grant Client')->accessToken;
                    $response = ['token' => $token];
                    return response($response, 200);
                } else {
                    $response = ["message" => "Your Email is not verified please follow link to verify email"];
                    return response($response, 422);
                }

            } else {
                $response = ["message" => "Password mismatch"];
                return response($response, 422);
            }
        } else {
            $response = ["message" => 'User does not exist'];
            return response($response, 422);
        }
    }

    public function logout(Request $request)
    {
        $token = $request->user()->token();
        $token->revoke();
        $response = ['message' => 'You have been successfully logged out!'];
        return response($response, 200);
    }

    public function edit_profile(Request $request)
    {

        $profileupdated = false;
        $user = User::where('id', $request->id)->first();
        if ($user) {
            if ($request->hasFile('image')) {
                $user->image = $request->image->getClientOriginalName();
                $imageName = $request->image->getClientOriginalName();
                $image = Image::make($request->file('image'))->resize(150, 100);
                $path = 'thumbnails/' . $request->image->getClientOriginalName();

                if ($user->image == 'user.jpg') {
                    // we dont want to delete the default image
                } else {
                    File::delete(asset('thumbnails/' . $user->image));
                }
                $image->save($path);

                $user->save();
                $profileupdated = true;

                Log::info('  User Profile Updated ');
                $response = ['message' => 'Profile Updated'];
                // return response($response, 200);

            }
            if (!($request->hasFile('image')) && $request->email == $user->email && $request->name == $user->name) {
                Log::info('Nothing Updated ');

                $response = ['message' => 'Nothing Updated'];
                return response($response, 200);

            } elseif ($request->email == $user->email && $request->name != $user->name) {
                $request->validate([
                    'name' => 'required',
                ]);

                $user->name = $request->name;
                $user->save();
                if ($profileupdated) {
                    Log::info('Name And Profile for user  Updated Successfully');
                    $response = ['message' => 'Name And Profile for user  Updated '];
                    return response($response, 200);
                }

                Log::info('Name for user  Updated Successfully');
                $response = ['message' => 'Name for user  Updated '];
                return response($response, 200);

            } elseif ($request->email != $user->email && $request->name != $user->name) {
                $request->validate([
                    'name' => 'required',
                    'email' => 'required|email|unique:users',

                ]);

                $user->name = $request->name;
                $user->email = $request->email;
                $user->verified = 0;
                Mail::to($user->email)
                    ->send(new VerifyMail($user));
                $user->save();
                if ($profileupdated) {
                    Log::info('Name, Email And Profile for user  Updated Successfully');
                    $response = ['message' => 'Name,Email And Profile for user  Updated Succefully '];
                    return response($response, 200);
                }
                Log::info('User Email And Name Updated Successfully');
                $response = ['message' => 'User Email And Name Updated Successfully'];
                return response($response, 200);
            } else {
                if ($request->email != $user->email) {
                    $request->validate([
                        'email' => 'required|email|unique:users',
                    ]);

                    $user->email = $request->email;
                    Mail::to($user->email)
                        ->send(new VerifyMail($user));
                    $user->verified = 0;
                    $user->save();

                    Auth::logout();
                    if ($profileupdated) {
                        Log::info('Email And Profile for user  Updated Successfully');
                        $response = ['message' => 'Email And Profile for user  Updated Successfully'];
                        return response($response, 200);
                    }
                    Log::info('User Email  Updated Successfully');
                    $response = ['message' => 'User Email  Updated Successfully'];
                    return response($response, 200);
                }

                $response = ['message' => 'Profile Updated'];
                return response($response, 200);
            }

        }
        $response = ['message' => 'Invalid ID'];
        return response($response, 200);

    }

    public function check_and_update_password(Request $request)
    {

        $user = User::where('id', $request->id)->first();

        if (Hash::check($request->old_password, $user->password)) {
            $user->password = bcrypt($request->new_password);
            $user->save();
            Log::info('User Password Updated Successfully');
            $response = ['message' => 'Password  Updated Successfully'];
            return response($response, 200);

        } else {
            $response = ['message' => 'Wrong Password'];
            return response($response, 200);
        }
    }

    public function submitForgetPasswordForm(Request $request)
    {

        $request->validate([
            'email' => 'required|email|exists:users',
        ]);

        $token = Str::random(64);

        DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => Carbon::now(),
        ]);

        Mail::send('emails.forgetPassword', ['token' => $token], function ($message) use ($request) {
            $message->to($request->email);
            $message->subject('Reset Password');
        });

        $response = ['message' => 'We have e-mailed your password reset link!',
            'token', $token];
        return response($response, 200);
    }
    public function submitResetPasswordForm(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users',
            'password' => 'required|string|min:6',
            'password_confirmation' => 'required',
        ]);

        $updatePassword = DB::table('password_resets')
            ->where([
                'email' => $request->email,
                'token' => $request->token,
            ])
            ->first();

        if (!$updatePassword) {
            $response = ['message' => 'Invalid Token!'];
            return response($response, 200);
        }

        $user = User::where('email', $request->email)
            ->update(['password' => Hash::make($request->password)]);

        DB::table('password_resets')->where(['email' => $request->email])->delete();

        $response = ['message' => 'Your password has been changed!'];
        return response($response, 200);
    }
    protected function guard()
    {
        return Auth::guard('api');
    }
}

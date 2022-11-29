<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\VerifyMail;
use App\Models\User;
use App\Models\VerifyUser;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules\Password;
use Image;
use Illuminate\Support\Facades\Mail;
use Session;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash as FacadesHash;

class AuthController extends Controller
{
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function index()
    {
        if (auth()->user()) {
            return view('auth.dashboard');
        }
        return view('auth.login');
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function registration()
    {
        return view('auth.registration');
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function postLogin(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {

            $user = User::where('email', $request->email)->first();
            if ($user->verified) {
                $user = Auth::user();

                session()->flash('status', 'you are logged in');
                Log::info('User Logged In');
                return view('auth.dashboard');
            }

            Auth::logout();
            session()->invalidate();
            session()->regenerateToken();
            session()->flash('email', $request->email);
            session()->flash('password', $request->password);
            Log::info('Invalid Login Request');

            session()->flash('status', 'Your Email is not verified');
            return redirect()->route("login");

        }

        session()->flash('email', $request->email);
        session()->flash('password', $request->password);
        Log::info('Invalid Login Request');

        session()->flash('status', 'Wrong Email OR Password');
        return redirect()->route("login");
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function postRegistration(Request $request)
    {
        $request->validate([
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
        if ($request->hasFile('image')) {

            $user = $this->create($request);

            $user->image = $request->image->getClientOriginalName();
            $imageName = $request->image->getClientOriginalName();
            $image = Image::make($request->file('image'))->resize(150, 100);
            $path = 'thumbnails/' . $request->image->getClientOriginalName();
            $image->save($path);
            $user->save();
            Log::info(' New User Registered ');


            $user->assignRole('User');

            session()->flash('status', 'We sent you an email please Verify');
            return view('auth.login');
        }

        $user = $this->create($request);
        $user->assignRole('User');
        Log::info(' New User Registered ');
        session()->flash('status', 'We sent you an email please Verify');
        return view('auth.login');
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function dashboard()
    {
        if (Auth::check()) {
            Log::info('  User Logged In ');
            return view('auth.dashboard');
        }
        session()->flash('status', 'You are not  logged in  ');
        return view("auth.login");
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function create($request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'confirm_password' => bcrypt($request->confirm_password),
        ]);
        $verifyUser = VerifyUser::create([
            'user_id' => $user->id,
            'token' => sha1(time()),
        ]);
        Mail::to($user->email)
            ->send(new VerifyMail($user));
        return $user;
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function logout()
    {

        Auth::logout();
        Log::info('User Logged Out');

        return redirect()->route('login');
    }

    public function gotoprofile()
    {

        $id = Auth::user()->id;
        $user = User::find($id);
        return view('auth.profile', compact('user'));
    }

    public function edit_profile(Request $request)
    {

        $id = Auth::user()->id;
        $user = User::find($id);
        if ($request->hasFile('image')) {
            $user->image = $request->image->getClientOriginalName();
            $imageName = $request->image->getClientOriginalName();
            $image = Image::make($request->file('image'))->resize(150, 100);
            $path = 'thumbnails/' . $request->image->getClientOriginalName();

            if (Auth::user()->image == 'user.jpg') {
                // we dont want to delete the default image
            } else {
                File::delete(asset('thumbnails/' . Auth::user()->image));
            }
            $image->save($path);

            $user->save();
            Log::info('  User Profile Updated ');
            session()->flash('status', 'Profile Updated');
            return redirect()->route('dashboard');

        }
        if (!($request->hasFile('image')) && $request->email == Auth::user()->email && $request->name == Auth::user()->name) {
            Log::info('Nothing Updated ');
            session()->flash('status', 'Nothing Updated');
            return view("auth.dashboard");
        } elseif ($request->email == Auth::user()->email && $request->name != Auth::user()->name) {
            $request->validate([
                'name' => 'required',
            ]);

            $user->name = $request->name;
            $user->save();
            Log::info('Name for user  Updated Successfully');
            session()->flash('status', 'Name Updated Successfully ');

            return view("auth.dashboard");
        } elseif ($request->email != Auth::user()->email && $request->name != Auth::user()->name) {
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
            Log::info('User Email And Name Updated Successfully');
            session()->flash('status', 'Email And Name Updated Successfully');

            return view("auth.dashboard");
        } else {
            $request->validate([
                'email' => 'required|email|unique:users',
            ]);

            $user->email = $request->email;
            Mail::to($user->email)
                ->send(new VerifyMail($user));
            $user->verified = 0;
            $user->save();
            Log::info('User Email  Updated Successfully');

            session()->flash('status', 'Verify Email');
            Auth::logout();
            return view("auth.login");
        }
    }

    public function change_password()
    {
        return view('auth.change_password');
    }

    public function check_and_update_password(Request $request)
    {

        $id = Auth::user()->id;
        $user = User::find($id);


        if ( Hash::check($request->old_password, $user->password)) {
            $user->password = bcrypt($request->new_password);
            $user->save();
            Log::info('User Password Updated Successfully');

            session()->flash('status', 'Password  Updated Successfully');
            return view("auth.dashboard");

        }
        else{
            Log::info('Password  incorrect');

            session()->flash('status', 'Password  incorrect');
            return redirect()->back();

        }
    }

}

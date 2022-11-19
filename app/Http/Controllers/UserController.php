<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\VerifyUser;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules\Password;
use Image;
use Session;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function __construct()
    {
        // set permission
        $this->middleware('permission:user-list|user-create|user-edit|user-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:user-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:user-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:user-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view('show_users', [
            'users' => User::paginate(15),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::pluck('name', 'name')->all();
        return view('user.createnewuser', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
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

            $user = new User;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->confirm_password = Hash::make($request->confirm_password);
            $user->image = $request->image->getClientOriginalName();
            $imageName = $request->image->getClientOriginalName();
            $image = Image::make($request->file('image'))->resize(150, 100);
            $path = 'thumbnails/' . $request->image->getClientOriginalName();
            $image->save($path);
            $user->save();
            if ($request->has('roles')) {
                dd('roles');
                $user->assignRole($request->input('roles'));
            }

            $request->session()->flash('status', 'User Created Successfully');
            return view('auth.dashboard');
        } else {
            $user = new User;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->confirm_password = Hash::make($request->confirm_password);

            if ($request->has('role')) {
                $user->assignRole($request->input('role'));
            }
            $user->save();

            Log::info('User Created ');
            session()->flash('status', 'User Created  successfully');
            return redirect()->route('users.index');
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        dd('show');

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $Userdata = User::find($user->id)->first();
        $roles = Role::pluck('name', 'name')->all();
        $userRole = $Userdata->getRoleNames();
        return view('user.edituser', compact('user', 'roles', 'userRole'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {

        $Updated = false;

        if ($request->hasFile('image')) {
            if ($request->image->getClientOriginalName() != $user->image) {

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
                $Updated = true;
            }
        }
        if ($request->name != $user->name) {
            $request->validate([
                'name' => 'required',
            ]);

            $user->name = $request->name;
            $user->save();
            $Updated = true;
        }
        if ($request->email != $user->email) {

            $request->validate([
                'name' => 'required',
                'email' => 'required|email|unique:users',

            ]);

            $user->email = $request->email;
            $user->save();
            $Updated = true;
        }
        $this->validate($request, [
            'role' => 'required',
        ]);
        DB::table('model_has_roles')->where('model_id', $user->id)->delete();
        $user->assignRole($request->input('role'));
        if ($Updated) {
            $request->session()->flash('status', 'User Info  Updated Successfully');
            Log::info('User Updated ');
            return redirect()->route('users.index');

        }
        $request->session()->flash('status', '  Updated Successfully');
        return redirect()->route('users.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {

        User::find($user->id)->delete();
        return redirect()->back();

    }

    public function verifyUser($token)
    {

        $verifyUser = VerifyUser::where('token', $token)
            ->first();

        if (isset($verifyUser)) {

            $user = $verifyUser->user;

            if (!$user->verified) {

                $verifyUser->user->verified = 1;
                $verifyUser->user->save();

                $status = "Your e-mail is verified. You can now login.";
            } else {
                $status = "Your e-mail is already verified. You can now login.";
            }
        } else {
            return redirect()->route('login')
                ->with('warning', "Sorry your email cannot be identified.");
        }
        return redirect()->route('login')
            ->with('status', $status);
    }

}

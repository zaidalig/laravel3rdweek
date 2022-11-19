protected function create(array $data)
{
    $user = User::create([
        'name' => $data['name'],
        'email' => $data['email'],
        'password' => bcrypt($data['password']),
        'confirm_password' => bcrypt($data['confirm_password']),
        ]);
    $verifyUser = VerifyUser::create([
        'user_id' => $user->id,
        'token' => sha1(time()),
    ]);
    Mail::to($user->email)
        ->send(new VerifyMail($user));
    return $user;
}

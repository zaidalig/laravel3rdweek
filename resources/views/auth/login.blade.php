@extends('auth.layout')

@section('content')
    <main class="login-form">
        <div class="cotainer">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">Login</div>
                        <div class="card-body">
                            <div class="card-body">
                                @if (session('status'))
                                    <div class="alert alert-primary" role="alert">
                                        {{ session('status') }}
                                        {{ session()->forget('status'); }}

                                    </div>
                                @endif


                            </div>

                            <form action="{{ route('login.post') }}" method="POST">
                                @csrf
                                <div class="form-group row">
                                    <label for="email_address" class="col-md-4 col-form-label text-md-right">E-Mail
                                        Address</label>
                                    <div class="col-md-6">
                                        <input type="email" id="email_address" class="form-control" name="email"
                                        value="{{ session('email') }}"   required autofocus>
                                        @if ($errors->has('email'))
                                            <span class=" text text-danger">{{ $errors->first('email') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>
                                    <div class="col-md-6">
                                        <input type="password" value="{{ session('password') }}" id="password" class="form-control" name="password" required>
                                        @if ($errors->has('password'))
                                            <span class="text-danger">{{ $errors->first('password') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">



                                </div>

                                <div class="col-md-6 offset-md-4 column">

                                    <button type="submit" class="btn btn-primary">
                                        Login
                                    </button>
                                            <label style="padding-left: 30px">
                                                <a href="{{ route('forget.password.get') }}">Forgot Password ?</a>
                                            </label>
                                </div>
                            </form>
                            <div class="form-group">

                                <label for="name" class="col-md-4 control-label">Login With</label>

                                <div class="col-md-6" style="margin: 20px; align-items:center;">

                                    <a href="{{ url('login/google') }}"><i>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor" class="bi bi-google" viewBox="0 0 16 16">
                                            <path d="M15.545 6.558a9.42 9.42 0 0 1 .139 1.626c0 2.434-.87 4.492-2.384 5.885h.002C11.978 15.292 10.158 16 8 16A8 8 0 1 1 8 0a7.689 7.689 0 0 1 5.352 2.082l-2.284 2.284A4.347 4.347 0 0 0 8 3.166c-2.087 0-3.86 1.408-4.492 3.304a4.792 4.792 0 0 0 0 3.063h.003c.635 1.893 2.405 3.301 4.492 3.301 1.078 0 2.004-.276 2.722-.764h-.003a3.702 3.702 0 0 0 1.599-2.431H8v-3.08h7.545z"/>
                                          </svg></i></a>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

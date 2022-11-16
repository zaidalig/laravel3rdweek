@extends('auth.layout')
@can('user-create')
    @section('content')
        <main class="login-form">
            <div class="cotainer">
                <div class="row justify-content-center">
                    <div class="form-group ">

                        @if (session('errors'))
                            <div class="alert alert-danger alert-dismissible">
                                <a href="" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                {{ session('errors') }}
                                <span aria-hidden="true">&times;</span>

                            </div>
                    </div>
                    {{ session()->forget('errors') }}
                    @endif
                </div>
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">Create New User</div>
                        <div class="card-body">

                            <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group row">
                                    <label for="name" class="col-md-4 col-form-label text-md-right">Name</label>
                                    <div class="col-md-6">
                                        <input type="text" id="name" minlength="6" value="{{ old('name') }}"
                                            class="form-control" name="name" required autofocus>
                                        @if ($errors->has('name'))
                                            <span class="text-danger">{{ $errors->first('name') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="email_address" class="col-md-4 col-form-label text-md-right">E-Mail
                                        Address</label>
                                    <div class="col-md-6">
                                        <input type="text" id="email_address" value="{{ old('email') }}"
                                            class="form-control" name="email" required autofocus>
                                        @if ($errors->has('email'))
                                            <span class="text-danger">{{ $errors->first('email') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>
                                    <div class="col-md-6">
                                        <input minlength="8" type="password" id="password" class="form-control"
                                            name="password" required>
                                        @if ($errors->has('password'))
                                            <span class="text-danger">{{ $errors->first('password') }}</span>
                                        @endif
                                    </div>
                                </div>



                                <div class="form-group row">
                                    <label for="password" class="col-md-4 col-form-label text-md-right">Confirm
                                        Password</label>
                                    <div class="col-md-6">
                                        <input minlength="8" type="password" id="confirm_password" class="form-control"
                                            name="confirm_password" required>
                                        @if ($errors->has('confirm_password'))
                                            <span class="text-danger">{{ $errors->first('confirm_password') }}</span>
                                        @endif
                                    </div>
                                </div>


                                <div class="form-group row">
                                    <label for="image" class="col-md-4 col-form-label text-md-right">Profile
                                        Image</label>
                                    <div class="col-md-6">
                                        <input type="file" name="image">
                                    </div>
                                </div>

                                    <div class="form-group  d-flex justify-content-center">
                                        <label style="padding-right: 10px" for=""> Select Role</label>
                                        <select required class="input_color" name="catagory">
                                            <option value="" selected="">Choose </option>
                                            @foreach ($roles as $role)
                                                <option value="{{ $role }}">{{ $role }}</option>
                                            @endforeach
                                        </select>
                                    </div>





                                <div class="d-flex justify-content-center">
                                    <button class="col-md-2  " type="submit">Create</button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
            </div>
        </main>
    @endsection
@endcan

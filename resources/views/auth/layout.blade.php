<!DOCTYPE html>
<html>

<head>
    @if (session('status'))
        <title> {{ session('status') }}

        </title>
        {{ session()->forget('status') }}
    @endif
    <title> Laravel Training

    </title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <script src=”https://code.jquery.com/jquery-3.6.0.slim.js”></script>

    <style type="text/css">
        @import url(https://fonts.googleapis.com/css?family=Raleway:300,400,600);


        .dropbtn {
            border: none;
            border-radius: 40%;
        }

        .dropdown {
            position: relative;
            display: inline-block;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #f1f1f1;
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
            z-index: 1;
        }

        .dropdown-content a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }



        .dropdown:hover .dropdown-content {
            display: block;
        }



        body {
            margin: 0;
            font-size: .9rem;
            font-weight: 400;
            line-height: 1.6;
            color: #212529;
            text-align: left;
            background-color: #f5f8fa;
        }

        .navbar-laravel {
            box-shadow: 0 2px 4px rgba(0, 0, 0, .04);
        }

        .navbar-brand,
        .nav-link,
        .my-form,
        .login-form {
            font-family: Raleway, sans-serif;
        }

        .my-form {
            padding-top: 1.5rem;
            padding-bottom: 1.5rem;
        }

        .my-form .row {
            margin-left: 0;
            margin-right: 0;
        }

        .login-form {
            padding-top: 1.5rem;
            padding-bottom: 1.5rem;
        }

        .login-form .row {
            margin-left: 0;
            margin-right: 0;
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-light navbar-laravel">
        <div class="container">


            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto">
                    @auth

                        @can('category-list')
                            <li>
                                <a class="nav-link" href="{{ url('categories') }}">Categories</a>
                            </li>
                        @endcan

                        @can('product-list')
                        <li>
                            <a class="nav-link" href="{{ url('products') }}">Products</a>
                        </li>
                        @endcan
                        @can('user-list')
                        <li>
                            <a class="nav-link" href="{{ url('users') }}"> Users</a>
                        </li>
                        @endcan
                        @can('role-list')
                        <li>
                            <a class="nav-link" href="{{ url('roles') }}">Manage Role</a>
                        </li>
                        @endcan


                        <div class="dropdown">
                            <a id="dropbtn" data-toggle="dropdown">
                                <img class="image rounded-circle" alt="profile image"
                                    src="{{ asset('thumbnails/' . Auth::user()->image) }}" alt="profile"
                                    style="width: 50px;height: 50px; padding: 5px;  ">
                            </a>
                            <div class="dropdown-content">
                                <a class="nav-link" href="{{ url('gotoprofile') }}"> Profile</a>
                                <a class="nav-link" href="{{ url('gotomyimages') }}"> My Images</a>
                                <a class="nav-link" href="{{ route('change_password') }}">Change Password</a>
                                <a class="nav-link" href="{{ route('logout') }}">Logout</a>

                            </div>
                        </div>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">Register</a>
                        </li>


                    @endauth


                </ul>

            </div>
        </div>
    </nav>

    @yield('content')

</body>

</html>

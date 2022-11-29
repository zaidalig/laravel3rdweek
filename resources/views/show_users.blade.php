@extends('auth.layout')

@section('content')
    <main class="upload-images">
        <div class="cotainer">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    @can('user-search')
                        <div style="padding: 20px">
                            <form action="{{ url('users.search') }}" method="get" role="search">
                                {{ csrf_field() }}
                                <div class="input-group">
                                    <input type="text" class="form-control" name="q" placeholder="Search User"> <span
                                        class="input-group-btn">
                                        <button
                                            style="background-color: red;
                                    margin-left:20px;
                                    "
                                            type="submit" class="btn btn-default">
                                            <span class="glyphicon glyphicon-search"> Search User</span>
                                        </button>
                                    </span>
                                </div>
                            </form>

                        </div>
                    @endcan

                    <div class="card-header d-flex justify-content-between">
                        <h4>All Users</h4>

                        @can('user-create')
                            <a href="{{ route('users.create') }}">Create New User</a>
                        @endcan
                    </div>
                    <div class="form-group ">

                        @if (session('status'))
                            <div class="alert alert-info alert-dismissible">
                                <a href="" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                {{ session('status') }}
                                <span aria-hidden="true">&times;</span>

                            </div>
                    </div>
                    {{ session()->forget('status') }}
                @else
                </div>
                @endif

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Email</th>
                            <th>Name</th>
                            <th>Image</th>
                            <th>Role</th>
                            @can('user-edit')
                                <th width="50px">Action</th>
                            @endcan
                            @can('user-delete')
                                <th width="50px">Action</th>
                            @endcan
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->name }}</td>
                                <td><img src="{{ asset('thumbnails/' . $user->image) }}" alt="profile"
                                        style=" padding: 10px; margin: 0px; " width="50px" height="50px"></td>

                                <td>
                                    @if (!empty($user->getRoleNames()))
                                        @foreach ($user->getRoleNames() as $v)
                                            <label class="badge badge-success">{{ $v }}</label>
                                        @endforeach
                                    @endif
                                </td>


                                @can('user-edit')
                                    <td>

                                        <a class="btn btn-primary" href="{{ route('users.edit', $user->id) }}">Edit</a>

                                    </td>
                                @endcan
                                @can('user-delete')
                                    <td>
                                        <form action="{{ route('users.destroy', $user->id) }}" method="Post">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                onclick="return confirm('Are you sure to delete this user ?')"
                                                class="btn btn-danger">Delete</button>
                                        </form>
                                    </td>
                                @endcan
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {!! $users->links('pagination::bootstrap-5') !!}




            </div>
        </div>
        </div>
        </div>
        </div>
    </main>
@endsection

@extends('auth.layout')
@section('content')
    @can('role-create')
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="pull-left">
                    <h2>Role Management</h2>
                </div>

                <div class="d-flex justify-content-center ">
                    @can('role-create')
                        <a class="btn btn-success" href="{{ route('roles.create') }}"> Create New Role</a>
                    @endcan
                </div>
            </div>
        </div>
    @endcan

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

    @can('role-list')
        <table class="table table-bordered">
            <tr>
                <th>No</th>
                <th>Name</th>
                @can('role-list')
                <th width="280px">Action</th>
                @endcan
                @can('role-edit')
                <th width="280px">Action</th>
                @endcan
                @can('role-delete')
                <th width="280px">Action</th>
                @endcan
            </tr>
            @foreach ($roles as $key => $role)
                <tr>
                    <td>{{ ++$i }}</td>
                    <td>{{ $role->name }}</td>
                    @can('role-list')
                        <td>
                            <a class="btn btn-info" href="{{ route('roles.show', $role->id) }}">Show</a>
                        </td>
                    @endcan
                    @can('role-edit')
                        <td>
                            <a class="btn btn-primary" href="{{ route('roles.edit', $role->id) }}">Edit</a>
                        </td>
                    @endcan
                    <td>
                        @can('role-delete')
                            {!! Form::open(['method' => 'DELETE', 'route' => ['roles.destroy', $role->id], 'style' => 'display:inline']) !!}
                            {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                            {!! Form::close() !!}
                        @endcan
                    </td>
                </tr>
            @endforeach

        </table>

        {!! $roles->render() !!}
    @endcan
@endsection

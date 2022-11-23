@extends('auth.layout')
<style type="text/css">
    .div_center {
        text-align: center;
        padding-top: 40px;
    }

    .h2_font {
        font-size: 40px;
        padding-bottom: 40px;
    }

    .input_color {
        color: black;
    }

    .center {
        margin: auto;
        width: 50%;
        text-align: center;
        margin-top: 30px;
        border: 3px solid white;
    }
</style>
@section('content')
    <div class="container-scroller">

        <div class="main-panel">

            <div class="content-wrapper">
                @if (session()->has('message'))
                    <div class="alert alert-success">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">

                        </button>
                        {{ session()->get('message') }}
                    </div>
                @endif
                <div class="content-wrapper">
                    @if (session()->has('errors'))
                        <div class="alert alert-danger">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">

                            </button>
                            {{ session()->get('errors') }}
                    @endif

                </div>
                <div style="padding: 20px">
                    <form action="{{ url('categories.search') }}" method="get" role="search">
                        {{ csrf_field() }}
                        <div class="input-group">
                            <input type="text" class="form-control" name="q" placeholder="Search Category by name"> <span
                                class="input-group-btn">
                                <button style="background-color: red;
                                margin-left:20px;
                                " type="submit" class="btn btn-default">
                                    <span class="glyphicon glyphicon-search"> Search Category</span>
                                </button>
                            </span>
                        </div>
                    </form>

                </div>
                @can('category-create')
                    <div class='div_center'>
                        <h2 class="h2_font">Add Catagory</h2>

                        <form action="{{ route('categories.store') }}" method="POST">
                            @csrf
                            <input required type="text" class="input_color" name="category_name"
                                placeholder="write catagory name">

                            <input type="submit" name="submit" value="add catagory " class="btn btn-primary">

                        </form>
                    </div>
                @endcan
                @can('category-list')
                    <table class="center">
                        <tr>
                            <td>Category name</td>
                         @can('category-edit')


                            <td>Action</td>
                            @endcan
                            @can('category-delete')
                            <td>Action</td>
                            @endcan
                        </tr>
                        @foreach ($categories as $categories)
                            <tr>
                                <td>{{ $categories->category_name }}</td>
                                @can('category-edit')


                                <td>
                                    <a class="btn btn-primary" href="{{ route('categories.edit', $categories) }}">Edit</a>

                                </td>
                                @endcan
                                @can('category-delete')
                                <td>
                                    <form action="{{ route('categories.destroy', $categories->id) }}" method="Post">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            onclick="return confirm('Are you sure to delete this Category ?')"
                                            class=" btn btn-danger">Delete</button>
                                    </form>
                                </td>
                                @endcan
                            </tr>
                        @endforeach
                    </table>
                @endcan
            </div>


        </div>
    @endsection

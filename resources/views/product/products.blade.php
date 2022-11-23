@extends('auth.layout')

<style type="text/css">
    .center {
        margin: auto;
        width: 50%;
        border: 2px solid white;
        text-align: center;
        margin-top: 20px;
    }

    .font_size {
        text-align: center;
        font-size: 20px;
        padding-top: 0px;

    }

    .img_size {
        width: 100px;
        height: 100px;
    }

    .th_color {
        background-color: rgb(99, 138, 154);
    }

    .dg_pad {
        padding: 20px;

    }

    label {
        display: inline-block;
        width: 200px;

    }

    input {
        padding-top: 20px;
    }

    .btn {
        margin-right: 10px
    }
</style>



@section('content')
    <div class="container-scroller">

        <div class="main-panel">

            <div class="  content-wrapper">


                <div style="padding: 20px">
                    <form action="{{ url('products.search') }}" method="get" role="search">
                        {{ csrf_field() }}
                        <div class="input-group">
                            <input type="text" class="form-control" name="q" placeholder="Search Products"> <span
                                class="input-group-btn">
                                <button style="
                                margin-left:20px;" type="submit"
                                    class="btn btn-primary">
                                    <span class="glyphicon glyphicon-search"> Search Product</span>
                                </button>
                            </span>
                        </div>
                    </form>

                </div>
                <div class="d-flex">
                    <div class="mr-auto "></div>
                    <div style="padding: 20px">
                        <a href="{{ route('products.create') }}">Add Prodcut</a>
                    </div>
                </div>

                @if (session()->has('message'))
                    <div class="alert alert-success">

                        {{ session()->get('message') }}
                    </div>
                @endif
                @can('product-list')
                    <h2 class="font_size">All Products</h2>
                    <table class=" mx-auto center">
                        <tr class="th_color ">
                            <th class="dg_pad">Product title </th>
                            <th class="dg_pad">description</th>
                            <th class="dg_pad">Quantity</th>
                            <th class="dg_pad">Category</th>
                            <th class="dg_pad">Price</th>

                            <th class="dg_pad">Product Image</th>
                            @can('product-edit')
                                <th class="dg_pad">Edit</th>
                            @endcan
                            @can('product-delete')
                                <th class="dg_pad">Delete</th>
                            @endcan

                            <th class="dg_pad">Status</th>

                        </tr>
                        @foreach ($product as $product)
                            <tr>
                                <td>{{ $product->title }}</td>
                                <td>{{ $product->description }}</td>
                                <td>{{ $product->quantity }}</td>
                                <td>{{ $product->catagory }}</td>
                                <td>{{ $product->price }}</td>
                                <td><img class="img_size" src="/product/{{ $product->image }}" alt=""></td>

                                @can('product-edit')
                                    <td>
                                        <a class="btn btn-primary" href="{{ route('products.edit', $product->id) }}">Edit</a>
                                    </td>
                                @endcan
                                @can('product-delete')
                                    <td>
                                        <form action="{{ route('products.destroy', $product->id) }}" method="Post">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" onclick="return confirm('Are you sure to delete this user ?')"
                                                class=" btn btn-danger">Delete</button>
                                        </form>
                                    </td>
                                @endcan
                                <td>
                                    @if ($roles[0] == 'Admin')
                                        @if ($product->status == 'pending')
                                            <form action="{{ url('products.approve', $product->id) }}" method="Post">
                                                @csrf

                                                <button type="submit"
                                                    onclick="return confirm('Are you sure to Approve this Product ?')"
                                                    class=" btn btn-danger">Pending</button>
                                            </form>
                                        @else
                                            <h6>{{ $product->status }}</h6>
                                        @endif
                                    @else
                                        <h6>{{ $product->status }}</h6>
                                </td>
                        @endif
                        </tr>
                        @endforeach
                    </table>
                @endcan
            </div>
        </div>
    @endsection

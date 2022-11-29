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
    <div class='div_center'>
        <h2 class="h2_font">Update Category</h2>

        <form action="{{ route('categories.update', $category) }}" method="POST">
            @method('PATCH')
            @csrf
            <input required type="text" class="input_color" name="category_name" value="{{ $category->category_name }}"
                placeholder="write catagory name">

            <input type="submit" name="submit" value="Update catagory " class="btn btn-primary">

        </form>
    </div>
@endsection

@can('product-edit')

<!DOCTYPE html>
<html lang="en">

<head>
    <base href="/public">

    <style type="text/css">
        .div_center {
            text-align: center;
            padding-top: 40px;


        }

        .font_size {
            font-size: 40px;
            padding-bottom: 40px;


        }

        .input_color {
            color: black;
            padding-bottom: 20px;
        }

        label {
            display: inline-block;
            width: 200px;
        }

        .design {
            padding-bottom: 20px;
        }
    </style>
</head>

<body>
    <div class="container-scroller">

        <div class="main-panel">


            <div class="content-wrapper">
                @if (session()->has('message'))
                    <div class="alert alert-success">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
                            X
                        </button>
                        {{ session()->get('message') }}
                    </div>
                @endif

                <div class="div_center">
                    <div class="design">
                        <h1 class="font_size">Update Product</h1>
                        <form action="{{ route('products.update', $product->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @method('PATCH')
                            @csrf
                            <label for=""> Product title</label>
                            <input type="text" required class="input_color" name="title"
                                placeholder="Write a title" value="{{ $product->title }}">
                    </div>
                    <div class="design">
                        <label for=""> Product Description</label>
                        <input type="text" required class="input_color" name="description"
                            placeholder="Write a Description" value="{{ $product->description }}">
                    </div>
                    <div class="design">
                        <label for=""> Product price</label>
                        <input type="number" required class="input_color" name="price" placeholder="Write  price"
                            value="{{ $product->price }}">
                    </div>
                    <div class="design">
                        <label for=""> Product quantity</label>
                        <input type="number" required min="0" class="input_color" name="quantity"
                            placeholder="Write a quantity" value="{{ $product->quantity }}">
                    </div>
                    <div class="design">
                        <label for=""> Product Catagory</label>
                        <select required class="input_color" name="catagory">
                            <option value="">Write a Catagory here </option>
                            @foreach ($category as $category)
                                <option selected="" value="{{ $category->category_name }}" selected>
                                    {{ $category->category_name }}</option>
                            @endforeach
                        </select>
                    </div>


                    <div class="design">

                        <label for="">Current Product Image </label>
                        <img height="100" width="100" style="margin:auto" src="/product/{{ $product->image }}"
                            alt="">
                    </div>

                    <div class="design">

                        <label for="">Change Product Image Here </label>
                        <input type="file" name="image" value>
                    </div>

                    <div>

                        <input type="submit" value=" Update product" class="btn btn-primary">
                    </div>
                    </form>

                </div>

            </div>

        </div>

</body>

</html>
@endcan

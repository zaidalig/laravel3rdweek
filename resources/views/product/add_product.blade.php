@can('product-create')


    <!DOCTYPE html>
    <html lang="en">

    <head>
        <style type="text/css">
            <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"><script src=”https://code.jquery.com/jquery-3.6.0.slim.js”></script>.div_center {
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

        @if (session()->has('message'))
            <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
                    X
                </button>
                {{ session()->get('message') }}
            </div>
        @endif

        <div class="design">
            <h1 class="font_size">Add Product</h1>
            <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <label for=""> Product title</label>
                <input type="text" required class="input_color" name="title" placeholder="Write a title">
        </div>
        <div class="design">
            <label for=""> Product Description</label>
            <input type="text" required class="input_color" name="description" placeholder="Write a Description">
        </div>
        <div class="design">
            <label for=""> Product price</label>
            <input type="number" required class="input_color" name="price" placeholder="Write  price">
        </div>

        <div class="design">
            <label for=""> Product quantity</label>
            <input type="number" required min="0" class="input_color" name="quantity"
                placeholder="Write a quantity">
        </div>
        <div class="design">
            <label for=""> Product Category</label>
            <select required class="input_color" name="category">
                <option value="" selected="">Write a Catagory here </option>
                @foreach ($category as $category)
                    <option value="{{ $category->category_name }}">{{ $category->category_name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="design">

            <label for="">Product Image Here </label>
            <input type="file" required name="image">
        </div>

        <div>

            <input type="submit" value=" Add product" class="btn btn-primary">
            </form>
        </div>






    </body>

    </html>
@endcan

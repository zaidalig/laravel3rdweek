<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:product-list|product-create|product-edit|product-delete|product-approve', ['only' => ['index', 'store']]);
        $this->middleware('permission:product-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:product-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:product-delete', ['only' => ['destroy']]);
        $this->middleware('permission:product-approve', ['only' => ['approve']]);

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $category = Category::all();
        $user = Auth::user();
        $roles = $user->getRoleNames();

        if ($roles[0] == 'Admin') {
            $product = DB::table('products')->paginate(5);
            return view('product.products', compact('product', 'category', 'roles'));
        }

        $product = Product::where('user_id', $user->id)->paginate(5);

        return view('product.products', compact('product', 'category', 'roles'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $category = Category::all();
        return view('product.add_product', compact('category'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreProductRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $product = new Product;
        $product->title = $request->title;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->quantity = $request->quantity;
        $product->catagory = $request->category;
        $product->image = $request->image;
        $image = $request->image;
        $imagename = time() . '.' . $image->getClientOriginalExtension();
        $request->image
            ->move('product', $imagename);
        $product->image = $imagename;
        $id = Auth::user()->id;
        $product->user_id = $id;
        $product->save();

        return redirect()->route('products.index')->with('message', 'Product
    added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $category = Category::all();

        return view('product.update_product', compact('product', 'category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateProductRequest  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $product->title = $request->title;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->quantity = $request->quantity;
        $product->catagory = $request->catagory;
        $image = $request->image;
        if ($image) {
            $image = $request->image;
            $imagename = time() . '.' . $image->getClientOriginalExtension();
            $request->image
                ->move('product', $imagename);
            $product->image = $imagename;
        }

        $product->save();
        Log::info('Product Updated ');
        session()->flash('message', 'Product updated successfully');
        return redirect()->route('products.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product = Product::find($product->id);
        $product->delete();
        return redirect()->back()->with('message', 'Product Deleted Successfully');

    }

    public function approve(Product $product)
    {
        $product->status = 'Approved';
        $product->save();
        return redirect()->back()->with('message', 'Product Approved Successfully');

    }

    public function search(Request $request)
    {

        $category = Category::all();
        $user = Auth::user();
        $search_text = $request->q;
        $roles = $user->getRoleNames();

        if ($roles[0] == 'Admin') {
            $product = Product::where('title', 'LIKE', "%" . $search_text . "%")->orwhere('catagory', 'LIKE', "%" . $search_text . "%")->paginate(10);

            return view('product.products', compact('product', 'category', 'roles'));
        }

        session()->flash('search', $request->q);
        $product = Product::where('user_id', $user->id)->where
        (function ($query) {
            $search_text = session('search');
            $query->where('title', 'LIKE', '%' . $search_text . '%')->
                orwhere('catagory', 'LIKE', '%' . $search_text . '%')->
                orwhere('status', 'LIKE', '%' . $search_text . '%')->
                orwhere('description', 'LIKE', '%' . $search_text . '%')->paginate(10);
        })->paginate(5);
        return view('product.products', compact('product', 'category', 'roles'));

    }
}

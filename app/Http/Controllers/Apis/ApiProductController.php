<?php

namespace App\Http\Controllers\Apis;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Category;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ApiProductController extends Controller
{
    public $publicQuery;

    public function __construct()
    {

        // $this->middleware(function ($request, $next) {
        //     $user = Auth::user();
        //     $roles = $user->getRoleNames();
        //     if ($roles[0] == 'Admin') {
        //         return $next($request);
        //     }
        //     $response = ['message' => 'You dont have right permissions'];
        //     return response($response, 200);
        // });
        // $this->middleware('permission:product-list|product-create|product-edit|product-delete|product-approve', ['only' => ['index', 'store']]);
        // $this->middleware('permission:product-create', ['only' => ['create', 'store']]);
        // $this->middleware('permission:product-edit', ['only' => ['edit', 'update']]);
        // $this->middleware('permission:product-delete', ['only' => ['destroy']]);
        // $this->middleware('permission:product-approve', ['only' => ['approve']]);

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
            $products = Product::paginate(10);
            if ($products) {
                $response = ['products' => $products];
                return response($response, 200);
            } else {
                $response = ['products' => 'No product'];
                return response($response, 200);

            }

        }

        $products = Product::where('user_id', $user->id)->paginate(5);
        if ($products) {
            $response = ['products' => $products];
            return response($response, 200);
        } else {
            $response = ['products' => 'No product'];
            return response($response, 200);

        }

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
        $user = Auth::user();
        $roles = $user->getRoleNames();

        if ($roles[0] == 'Admin') {
            $product->status = "Approved";
        }
        $product->save();
        $response = ['message' => 'Product  added successfully'];
        return response($response, 200);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = Auth::user();
        $roles = $user->getRoleNames();
        $product = Product::where('id', $id)->first();
        if ($product) {

            if ($roles[0] == 'Admin') {
                if ($product) {
                    $response = ['message' => $product];
                    return response($response, 200);
                }
                $response = ['message' => 'No data'];
                return response($response, 200);

            }
            if (Auth()->user()->id == $product->user_id) {
                $response = ['message' => $product];
                return response($response, 200);
            } else {
                $response = ['message' => 'Invalid Data'];
                return response($response, 200);
            }
        } else {
            $response = ['message' => 'Invalid Data'];
            return response($response, 200);
        }

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

        $image = $request->image;
        if ($image) {
            $image = $request->image;
            $imagename = time() . '.' . $image->getClientOriginalExtension();
            $request->image
                ->move('product', $imagename);
            $product->image = $imagename;

            $product->update($request->toArray());
            $user = Auth::user();
            $roles = $user->getRoleNames();

            if ($roles[0] == 'Admin') {
                $product->status = "Approved";
                $product->approved_at = Carbon::now();
                $product->save();
                Log::info('Product Updated ');
                $response = ['message' => 'Product  Updated successfully'];
                return response($response, 200);
            }

            if (Auth()->user()->id == $product->user_id) {
                $response = ['message' => $product];
                return response($response, 200);
            } else {
                $response = ['message' => 'Invalid Data'];
                return response($response, 200);
            }
            $product->update($request->toArray());
            $product->save();

            Log::info('Product Updated ');
            $response = ['message' => 'Product  Updated successfully'];
            return response($response, 200);
        }
        $user = Auth::user();
        $roles = $user->getRoleNames();
        if ($roles[0] == 'Admin') {
            $product->status = "Approved";
            $product->approved_at = Carbon::now();
            $product->save();
            Log::info('Product Updated ');
            $response = ['message' => 'Product  Updated successfully'];
            return response($response, 200);
        }
        if (Auth()->user()->id == $product->user_id) {
            $response = ['message' => $product];
            return response($response, 200);
        } else {
            $response = ['message' => 'Invalid Data'];
            return response($response, 200);
        }
        $product->update($request->toArray());
        $product->save();

        Log::info('Product Updated ');
        $response = ['message' => 'Product  Updated successfully'];
        return response($response, 200);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $user = Auth::user();
        $roles = $user->getRoleNames();
        if ($roles[0] == 'Admin') {
            $product->delete();
            $response = ['message' => 'Product  Deleted successfully'];
            return response($response, 200);
        }
        if (Auth()->user()->id == $product->user_id) {
            $product->delete();
            $response = ['message' => 'Product  Deleted successfully'];
            return response($response, 200);
        } else {
            $response = ['message' => 'Invalid Data'];
            return response($response, 200);
        }
        $product->delete();
        $response = ['message' => 'Product  Deleted successfully'];
        return response($response, 200);

    }

    public function approve(Product $product)
    {
        $user = Auth::user();
        $roles = $user->getRoleNames();
        if ($roles[0] == 'Admin') {
            $product->status = 'Approved';
            $product->save();
            $response = ['message' => 'Product  Approved successfully'];
            return response($response, 200);
        }

        $response = ['message' => 'You have not permission to approve'];
        return response($response, 200);

    }

    public function search(Request $request)
    {
        $category = Category::all();

        $user = Auth::user();

        $search_text = $request->q;
        $roles = $user->getRoleNames();
        if ($request->q) {

            if ($roles[0] == 'Admin') {
                if ($request->q) {

                    session()->flash('search', $request->q);
                    $query = Product::where(function ($query) {
                        $search = session('search');

                        return $query->where('title', 'LIKE', "%" . $search . "%")
                            ->orWhere('description', 'LIKE', "%" . $search . "%");
                    });
                } else {

                    $query = Product::all();
                }

                if ($request->pending) {
                    $query = $query->where('status', '=', 'pending');
                }

                if ($request->approved) {
                    $query = $query->where('status', '=', 'Approved');
                }

                if ($request->min_quantity) {
                    $query = $query->where('quantity', '>=', $request->min_quantity);

                }

                if ($request->max_quantity) {

                    $query = $query->where('quantity', '<=', $request->max_quantity);

                }

                if ($request->min_price) {
                    $query = $query->where('price', '>=', $request->min_price);
                }
                if ($request->max_price) {
                    $query = $query->where('price', '<=', $request->max_price);
                }
                if ($request->category) {
                    $query = $query->where('catagory', '=', $request->category);
                }
                $product = $query->get();
                $response = ['products' => $product];
                return response($response, 200);
            }

            if ($request->q) {

                session()->flash('search', $request->q);
                $query = Product::where('user_id', '=', $user->id)
                    ->where(function ($query) {
                        $search = session('search');
                        return $query->where('title', 'LIKE', "%" . $search . "%")
                            ->orWhere('description', 'LIKE', "%" . $search . "%");
                    });
            } else {
                $query = Product::where('user_id', '=', $user->id);
            }

            if ($request->pending) {
                $query = $query->where('status', '=', 'pending');
            }

            if ($request->approved) {
                $query = $query->where('status', '=', 'Approved');

            }

            if ($request->min_quantity) {
                $query = $query->where('quantity', '>=', $request->min_quantity);

            }

            if ($request->max_quantity) {

                $query = $query->where('quantity', '<=', $request->max_quantity);

            }

            if ($request->min_price) {
                $query = $query->where('price', '>=', $request->min_price);
            }
            if ($request->max_price) {
                $query = $query->where('price', '<=', $request->max_price);
            }
            if ($request->category) {
                $query = $query->where('catagory', '=', $request->category);
            }
            $product = $query->get();

            $response = ['products' => $product];
            return response($response, 200);
        } else {
            $response = ['products' => 'not a q'];
            return response($response, 200);
        }
    }
}

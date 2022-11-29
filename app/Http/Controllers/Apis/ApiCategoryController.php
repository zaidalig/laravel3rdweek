<?php

namespace App\Http\Controllers\Apis;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class ApiCategoryController extends Controller
{
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
        // $this->middleware('permission:category-list|category-create|category-edit|category-delete', ['only' => ['index', 'store']]);
        // $this->middleware('permission:category-create', ['only' => ['create', 'store']]);
        // $this->middleware('permission:category-edit', ['only' => ['edit', 'update']]);
        // $this->middleware('permission:category-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::all();
        $response = ['data' => $categories];
        return response($response, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCategoryRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

             $user = Auth::user();
            $roles = $user->getRoleNames();
            if ($roles[0] == 'Admin') {
                $request->validate([
                    'category_name' => 'required|unique:categories,category_name',
                ]);

                $category = new Category();
                $category->category_name = $request->category_name;
                $category->save();
                Log::info('New Category Added');
                $response = ['message' => 'Catagory added sucsessfully'];
                return response($response, 200);

            }
            $response = ['message' => 'You dont have right permissions'];
            return response($response, 200);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        $response = ['message' => $category];
        return response($response, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        return view('categories.update_category', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCategoryRequest  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {

        if ($request->category_name == $category->category_name) {

            $response = ['message' => 'Not Updated'];
                return response($response, 200);
        }
        $user = Auth::user();
        $roles = $user->getRoleNames();
        if ($roles[0] == 'Admin') {
            $cat = $category->category_name;
            $actual = $request->category_name;

            if ($actual != $cat) {

                $request->validate([
                    'category_name' => 'unique:categories,category_name',
                ]);

                $category->category_name = $request->category_name;
                $category->save();
                $response = ['message' => 'Category Updated Successfully'];
                return response($response, 200);
        }


        }
        else{
            $response = ['message' => 'You dont have right permissions'];
            return response($response, 200);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $category->delete();
        Log::info(' Category Deleted');
        $response = ['message' => 'Category Deleted Successfully'];
        return response($response, 200);

    }

    public function search(Request $request)
    {

        $categories = Category::where('category_name', 'LIKE', "%" . $request->q . "%")->paginate(10);
        $response = ['message' => $categories];
        return response($response, 200);

    }

}

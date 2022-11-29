<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Product;
class CategoryController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('permission:category-list|category-create|category-edit|category-delete', ['only' => ['index', 'store']]);
    //     $this->middleware('permission:category-create', ['only' => ['create', 'store']]);
    //     $this->middleware('permission:category-edit', ['only' => ['edit', 'update']]);
    //     $this->middleware('permission:category-delete', ['only' => ['destroy']]);
    // }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::all();
        return view('categories.category', compact('categories'));
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

        $request->validate([
            'category_name' => 'required|unique:categories,category_name',
        ]);

        $category = new Category();
        $category->category_name = $request->category_name;
        $category->save();
        Log::info('New Category Added');
        return redirect()->back()->with('message', 'Catagory
         added sucsessfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
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
            return redirect()->route('categories.index');
        }
        $cat = $category->category_name;
        $actual = $request->category_name;

        if ($actual != $cat) {

            $request->validate([
                'category_name' => 'unique:categories,category_name',
            ]);

            $category->category_name = $request->category_name;
            $category->save();
            return redirect()->route('categories.index');
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

        return redirect()->back()->with('message', 'Catagory
        Deleted sucsessfully');
    }

    public function search(Request $request)
    {

        $categories = Category::where('category_name', 'LIKE', "%" . $request->q . "%")->paginate(10);
        return view('categories.category', compact('categories'));


    }

}

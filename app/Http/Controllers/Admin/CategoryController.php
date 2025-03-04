<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Admin\Category;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class CategoryController extends Controller
{
    /**
     * Middleware
     *
     *
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(['permission:categories']);
        \config_set('theme.cdata', [
            'title' => 'All Categories',
            'model' => 'Category',
            'back' => \back_url(),
            'breadcrumb' => [
                [
                    'name' => 'Dashboard',
                    'link' => route('admin.dashboard')
                ],
                [
                    'name' => 'All Categories',
                    'link' => false
                ],
            ],
            'add' => route('admin.categories.create'),
        ]);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $collection = new Category();

        $collection = $collection->where(function ($collection) use ($request) {
            $collection->where('name', 'LIKE', "%{$request->search}%");
            $collection->orWhere('slug', 'LIKE', "%{$request->search}%");
        });
        $collection = $collection->orderBy('order')->paginate(20)->withQueryString();

        $categories = Category::where('parent_id', null)->where('status', true)->orderBy('order')->get();

        return \view('pages.admin.categories.index', ['collection'=>$collection, 'categories'=>$categories]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        \config_set('theme.cdata', [
            'title' => 'Add Category',
            'breadcrumb' => [
                [
                    'name' => 'Dashboard',
                    'link' => route('admin.dashboard')
                ],
                [
                    'name' => 'All Categories',
                    'link' => route('admin.categories.index')
                ],
                [
                    'name' => 'Add Category',
                    'link' => false
                ],
            ],
            'store' => route('admin.categories.store'),
        ]);

        $categories = Category::where('parent_id', null)->where('status', true)->orderBy('order')->get();

        return \view('pages.admin.categories.create_edit', ['categories'=>$categories]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string'],
            'slug' => ['required', 'string', 'unique:categories,slug'],
            'parent_id' => ['nullable', 'integer', 'in:0,' . \collect(Category::where('parent_id', null)->get())->pluck('id')->implode(',')],
            'order' => ['required', 'integer', 'min:0'],
            'status' => ['required', 'numeric', 'in:0,1'],
        ]);

        if($data['parent_id'] == 0) $data['parent_id'] = null;

        // dd($data);
        try {
            Category::create($data);
        } catch (\Throwable $th) {
            // flash message
            Session::flash('error', 'Data Storing Issue!');
            return \redirect()->route('admin.categories.create');
        }

        // flash message
        Session::flash('success', 'New Category Added.');
        return \redirect()->route('admin.categories.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Admin\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Admin\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        \config_set('theme.cdata', [
            'title' => 'Update Category',
            'breadcrumb' => [
                [
                    'name' => 'Dashboard',
                    'link' => route('admin.dashboard')
                ],
                [
                    'name' => 'All Categories',
                    'link' => route('admin.categories.index')
                ],
                [
                    'name' => 'Update Category',
                    'link' => false
                ],
            ],
            'edit' => route('admin.categories.edit', $category->id),
            'update' => route('admin.categories.update', $category->id),
        ]);

        $categories = Category::where('parent_id', null)->where('status', true)->orderBy('order')->get();

        return \view('pages.admin.categories.create_edit', ['data'=>$category, 'categories'=>$categories]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Admin\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $data = $request->validate([
            'name' => ['required', 'string'],
            'slug' => ['required', 'string', 'unique:categories,slug,'.$category->id.',id'],
            'parent_id' => ['nullable', 'integer', 'in:0,' . \collect(Category::where('parent_id', null)->get())->pluck('id')->implode(',')],
            'order' => ['nullable', 'integer', 'min:0'],
            'status' => ['required', 'numeric', 'in:0,1'],
        ]);

        if($data['parent_id'] == 0) $data['parent_id'] = null;

        // dd($data);
        try {
            $category->update($data);
        } catch (\Throwable $th) {
            // flash message
            Session::flash('error', 'Data Updating Issue!');
            return \redirect()->back();
        }

        // flash message
        Session::flash('success', 'Category Updated Successfully.');
        return \redirect()->route('admin.categories.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Admin\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        if($category->categories()->count() == 0){
            if($category->products()->count() == 0){
                Session::flash('success', 'Category Removed Successfully');
                $category->delete();
            }else{
                Session::flash('error', 'Products exists under this category');
            }
        }else{
            Session::flash('error', 'This Category has sub category.');
        }


        return \redirect()->route('admin.categories.index');
    }
}

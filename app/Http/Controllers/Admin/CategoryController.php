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
            $collection->orWhere('meta_title', 'LIKE', "%{$request->search}%");
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
            'thumbnail' => ['mimes:png,jpg,jpeg,svg,gif', 'max:2024', 'dimensions:width=150,height=150'],
            'banner' => ['mimes:png,jpg,jpeg,svg,gif', 'max:2024', 'dimensions:width=835,height=200'],
            'meta_title' => ['required', 'string'],
            'meta_desc' => ['required', 'string'],
        ]);

        if($data['parent_id'] == 0) $data['parent_id'] = null;

        $data['thumbnail'] = upload_image($request, 'thumbnail', 'categories/thumbnail');
        $data['banner'] = upload_image($request, 'banner', 'categories/banner');

        // dd($data);
        Category::create($data);

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
            'thumbnail' => ['mimes:png,jpg,jpeg,svg,gif', 'max:2024', 'dimensions:width=150,height=150'],
            'banner' => ['mimes:png,jpg,jpeg,svg,gif', 'max:2024', 'dimensions:width=835,height=200'],
            'meta_title' => ['required', 'string'],
            'meta_desc' => ['required', 'string'],
            'status' => ['required', 'numeric', 'in:0,1'],
        ]);

        if($data['parent_id'] == 0) $data['parent_id'] = null;

        $data['thumbnail'] = upload_image($request, 'thumbnail', 'categories/thumbnail', $category->thumbnail);
        $data['banner'] = upload_image($request, 'banner', 'categories/banner', $category->banner);

        // dd($data);
        $category->update($data);

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
            $category->delete();

            Session::flash('success', 'Category Removed Successfully');
        }else{
            Session::flash('error', 'This Category has sub category.');
        }


        // flash message
        Session::flash('success', 'Category Removed Successfully');
        return \redirect()->route('admin.categories.index');
    }
}

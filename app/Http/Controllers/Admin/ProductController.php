<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\Color;
use Illuminate\Http\Request;
use App\Models\Admin\Product;
use App\Models\Admin\Category;
use App\Models\Admin\ProductImage;
use App\Models\Admin\AttributesSet;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class ProductController extends Controller
{
    /**
     * Middleware
     *
     *
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(['permission:products']);
        \config_set('theme.cdata', [
            'title'      => 'All Products',
            'model'      => 'Product',
            'back'       => \back_url(),
            'breadcrumb' => [
                [
                    'name' => 'Dashboard',
                    'link' => route('admin.dashboard')
                ],
                [
                    'name' => 'All Products',
                    'link' => false
                ],
            ],
            // 'add' => \route('admin.products.create')
        ]);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        \config_set('theme.cdata', [
            'add' => \route('admin.products.create')
        ]);

        // The ids of my colors table are kept in JSON format named colors_id in the same table of the product model. Now I want to fetch the data of my colors table along with product table using laravel eloquent.

        // Fetch clors table data from product table colors_ids josn with product table data using laravel eloquent

        $collection = new Product();

        // $collection = $collection->where('status', true);

        $collection = $collection->where(function ($collection) use ($request)
        {
            $collection->where('name', 'LIKE', "%{$request->search}%");
            $collection->orWhere('sku', 'LIKE', "%{$request->search}%");
        });
        $collection = $collection->orderByDesc('id')->paginate(20)->withQueryString();

        return \view('pages.admin.products.index', \compact('collection'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        \config_set('theme.cdata', [
            'title'      => 'Add Product',
            'breadcrumb' => [
                [
                    'name' => 'Dashboard',
                    'link' => route('admin.dashboard')
                ],
                [
                    'name' => 'All Products',
                    'link' => route('admin.products.index')
                ],
                [
                    'name' => 'Add Product',
                    'link' => false
                ],
            ],
            'store'      => route('admin.products.store'),
        ]);

        $categories = Category::where('status', true)->get();
        $colors = Color::where('status', true)->get();
        $attributes = AttributesSet::where('status', true)->get();

        return \view('pages.admin.products.create_edit', ['categories' => $categories, 'colors' => $colors, 'attributes' => $attributes]);
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
            'name'               => ['required', 'string'],
            'slug'               => ['required', 'string', 'unique:products,slug'],
            'category_id'        => ['nullable', 'integer', 'exists:categories,id'],
            'price'              => ['required', 'integer', 'min:1'],

            'short_desc'         => ['nullable', 'string'],
            'long_desc'          => ['nullable', 'string'],
            'shipping_return'          => ['nullable', 'string'],
            'additional_info'          => ['nullable', 'string'],

            'stock_status'       => ['required', 'integer', 'in:0,1'],
            'status'             => ['required', 'integer', 'in:0,1'],

            'color_id'           => ['nullable', 'array'],
            'attr_value_id'      => ['nullable', 'array'],

            'thumbnail'          => ['nullable', 'mimes:png,jpg,jpeg,svg,gif'],
        ]);

        if($data['thumbnail'] ?? null) $data['thumbnail'] = upload_image($request, 'thumbnail', 'products/thumbnail');

        if (isset($data['color_id'])) $data['color_id'] = json_encode($data['color_id']) ?? [];
        if (isset($data['attr_value_id'])) $data['attr_value_id'] = json_encode($data['attr_value_id']) ?? [];

        // dd($data);
        try {
            Product::create($data);
        } catch (\Throwable $th) {
            Session::flash('error', 'Data Updating Issue!');
            return \redirect()->back()->withInput();
        }

        Session::flash('success', 'Product has been added!');
        return \redirect()->route('admin.products.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Admin\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Admin\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        \config_set('theme.cdata', [
            'title'      => 'Update Product',
            'breadcrumb' => [
                [
                    'name' => 'Dashboard',
                    'link' => route('admin.dashboard')
                ],
                [
                    'name' => 'All Products',
                    'link' => route('admin.products.index')
                ],
                [
                    'name' => 'Update Product',
                    'link' => false
                ],
            ],
            'edit'       => route('admin.products.edit', $product->id),
            'update'     => route('admin.products.update', $product->id),
        ]);

        $categories = Category::where('status', true)->get();
        $colors = Color::where('status', true)->get();
        $attributes = AttributesSet::where('status', true)->get();

        return \view('pages.admin.products.create_edit', ['categories' => $categories, 'colors' => $colors, 'attributes' => $attributes, 'data' => $product]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Admin\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'name'               => ['required', 'string'],
            // 'slug'               => ['required', 'string', 'unique:products,slug'],
            'category_id'        => ['nullable', 'integer', 'exists:categories,id'],
            'price'              => ['required', 'integer', 'min:1'],

            'short_desc'         => ['nullable', 'string'],
            'long_desc'          => ['nullable', 'string'],
            'shipping_return'    => ['nullable', 'string'],
            'additional_info'    => ['nullable', 'string'],

            'stock_status'       => ['required', 'integer', 'in:0,1'],
            'status'             => ['required', 'integer', 'in:0,1'],

            'color_id'           => ['nullable', 'array'],
            'attr_value_id'      => ['nullable', 'array'],

            'thumbnail'          => ['nullable', 'mimes:png,jpg,jpeg,svg,gif'],
        ]);

        if($data['thumbnail'] ?? null) $data['thumbnail'] = upload_image($request, 'thumbnail', 'products/thumbnail');
        $data['color_id'] = isset($data['color_id']) ? json_encode($data['color_id']) : null;
        $data['attr_value_id'] = isset($data['attr_value_id']) ? json_encode($data['attr_value_id']) : null;


        // dd($data);
        try {
            $product->update($data);
        } catch (\Throwable $th) {
            // flash message
            Session::flash('error', 'Data Updating Issue!');
            return \redirect()->back();
        }

        // flash message
        Session::flash('success', 'Product Updated Successfully.');
        return \redirect()->route('admin.products.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Admin\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        // check order
        // $product->delete();
    }

    // product image store
    public function productImageStore(Product $product, Request $request)
    {
        $data = $request->validate([
            'product_image' => ['required', 'mimes:png,jpg,jpeg,svg,gif', 'max:2024', 'dimensions:width=800,height=800'],
        ]);

        $data['product_image'] = upload_image($request, 'product_image', 'products/product_image');

        // dd($data);
        try {
            ProductImage::create(['url' => $data['product_image'], 'product_id' => $product->id]);
        } catch (\Throwable $th) {
            // flash message
            Session::flash('success', 'Data Storing Issue!');
            return \redirect()->back();
        }

        // flash message
        Session::flash('success', 'Product Image Added Successfully.');
        return \redirect()->back();
    }

    // product image delete
    public function productImageDelete(ProductImage $productImage)
    {
        $productImage->delete();

        // flash message
        Session::flash('success', 'Product Image Deleted Successfully.');
        return \redirect()->back();
    }
}

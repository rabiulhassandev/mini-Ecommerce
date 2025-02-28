<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Admin\Product;
use App\Models\Admin\Category;
use App\Http\Controllers\Controller;
use App\Models\Admin\AttributesSet;
use App\Models\Admin\ProductImage;
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
        $attributes = AttributesSet::where('status', true)->get();

        return \view('pages.admin.products.create_edit', ['categories' => $categories, 'attributes' => $attributes]);
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
            'category_id'        => ['nullable', 'integer', 'in:0,' . \collect(Category::all())->pluck('id')->implode(',')],
            'unit'               => ['required', 'string'],
            'min_order_qty'      => ['required', 'integer', 'min:1'],
            'unit_price'         => ['required', 'regex:/^[0-9]+(\.[0-9][0-9]?)?$/'],
            'sku'                => ['nullable', 'string', 'unique:products,sku'],
            'shipping_days'      => ['nullable', 'integer', 'min:1'],

            'thumbnail'          => ['required', 'mimes:png,jpg,jpeg,svg,gif', 'max:2024', 'dimensions:width=800,height=800'],

            'short_desc'         => ['required', 'string'],
            'long_desc'          => ['required', 'string'],
            'additional_info'    => ['nullable', 'string'],

            'meta_title'         => ['nullable', 'string'],
            'meta_desc'          => ['nullable', 'string'],
            'meta_keywords'      => ['nullable', 'string'],

            'featured_status'    => ['required', 'integer', 'in:0,1'],
            'todays_deal_status' => ['required', 'integer', 'in:0,1'],
            'stock_status'       => ['required', 'integer', 'in:0,1'],
            'status'             => ['required', 'integer', 'in:0,1'],

            'attr_value_id'      => ['nullable', 'array']
        ]);

        $data['thumbnail'] = upload_image($request, 'thumbnail', 'products/thumbnail');

        if (isset($data['attr_value_id'])) {
            $data['attr_value_id'] = json_encode($data['attr_value_id']) ?? [];
        }

        // dd($data);
        Product::create($data);

        // flash message
        Session::flash('success', 'New Product Added.');
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
        $attributes = AttributesSet::where('status', true)->get();

        return \view('pages.admin.products.create_edit', ['categories' => $categories, 'attributes' => $attributes, 'data' => $product]);
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
            'slug'               => ['required', 'string', 'unique:products,slug,' . $product->id . ',id'],
            'category_id'        => ['nullable', 'integer', 'in:0,' . \collect(Category::all())->pluck('id')->implode(',')],
            'unit'               => ['required', 'string'],
            'min_order_qty'      => ['required', 'integer', 'min:1'],
            'unit_price'         => ['required', 'regex:/^[0-9]+(\.[0-9][0-9]?)?$/'],
            'sku'                => ['nullable', 'string', 'unique:products,sku,' . $product->id . ',id'],
            'shipping_days'      => ['nullable', 'integer', 'min:1'],

            'thumbnail'          => ['mimes:png,jpg,jpeg,svg,gif', 'max:2024', 'dimensions:width=800,height=800'],

            'short_desc'         => ['required', 'string'],
            'long_desc'          => ['required', 'string'],
            'additional_info'    => ['nullable', 'string'],

            'meta_title'         => ['nullable', 'string'],
            'meta_desc'          => ['nullable', 'string'],
            'meta_keywords'      => ['nullable', 'string'],

            'featured_status'    => ['required', 'integer', 'in:0,1'],
            'todays_deal_status' => ['required', 'integer', 'in:0,1'],
            'stock_status'       => ['required', 'integer', 'in:0,1'],
            'status'             => ['required', 'integer', 'in:0,1'],

            'attr_value_id'      => ['nullable', 'array']
        ]);

        $data['thumbnail'] = upload_image($request, 'thumbnail', 'products/thumbnail', $product->thumbnail);

        if (isset($data['attr_value_id']) && $data['attr_value_id'] != null) {
            $data['attr_value_id'] = json_encode($data['attr_value_id']) ?? [];
        }

        // dd($data);
        $product->update($data);

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
        //
    }

    // product image store
    public function productImageStore(Product $product, Request $request)
    {
        $data = $request->validate([
            'product_image' => ['required', 'mimes:png,jpg,jpeg,svg,gif', 'max:2024', 'dimensions:width=800,height=800'],
        ]);

        $data['product_image'] = upload_image($request, 'product_image', 'products/product_image');

        // dd($data);
        ProductImage::create(['url' => $data['product_image'], 'product_id' => $product->id]);

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

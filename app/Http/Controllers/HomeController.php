<?php

namespace App\Http\Controllers;

use App\Models\Admin\Slider;
use Illuminate\Http\Request;
use App\Models\Admin\Product;
use App\Models\Admin\Category;
use App\Models\Admin\PageBuilder;
use App\Models\Admin\AttributesSet;
use App\Models\Admin\AttributesValue;
use App\Models\Admin\Color;
use Artesaos\SEOTools\Facades\SEOMeta;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{

    public function __construct()
    {
        $this->seo()->setTitle(setting('site.title'));
        $this->seo()->setDescription(setting('site.description'));
        SEOMeta::addKeyword([setting('site.keywords')]);
        $this->seo()->opengraph()->addImage(image_url(setting('site.logo'), front_asset('images/logo.png')));
    }

    public function index()
    {
        $this->seo()->setTitle("Home Page");
        return view('pages.front.index');
    }

    // products
    public function products(Request $request)
    {
        $this->seo()->setTitle("Products");

        // fatch all category 
        $categories = Category::where('status', true)->orderByDesc('order')->select('slug', 'name')->get();

        // fetch all products
        $products = new Product();

        $products = $products->where(function ($products) use ($request) {
            $products->where('name', 'LIKE', "%{$request->search}%");
            $products->orWhere('slug', 'LIKE', "%{$request->search}%");
            $products->orWhere('sku', 'LIKE', "%{$request->search}%");
        });

        // if has ($request->cat) then filter by category (slug) 
        if($request->cat){
            $products = $products->where('category_id', Category::where('slug', $request->cat)->first()->id);
        }

        $products = $products->where('status', true)->where('stock_status', true);
        $products = $products->select('id', 'name', 'slug', 'thumbnail', 'price');
        $products = $products->orderByDesc('id')->paginate(16)->withQueryString();

        return view('pages.front.products', compact('categories', 'products')); 

        

        $collection['products'] = $products;

        $collection['recentProducts'] = Product::where('status', true)->orderByDesc('created_at')->skip(0)->take(5)->get();
        $collection['categories'] = Category::where('status', true)->where('parent_id', null)->orderByDesc('id')->get();
        $collection['brands'] = Brand::where('status', true)->orderByDesc('id')->get();
        $collection['title'] = "প্রোডাক্ট সমূহ";

        return view('pages.front.products', ['collection' => $collection]);
    }

    // today's deal products
    public function todaysDealProducts()
    {
        $this->seo()->setTitle("আজকের অফার প্রোডাক্ট সমূহ");

        $collection['products'] = Product::where('status', true)->where('todays_deal_status', true)->orderByDesc('id')->paginate(15);
        $collection['recentProducts'] = Product::where('status', true)->orderByDesc('created_at')->skip(0)->take(5)->get();
        $collection['categories'] = Category::where('status', true)->where('parent_id', null)->orderByDesc('id')->get();
        $collection['brands'] = Brand::where('status', true)->orderByDesc('id')->get();
        $collection['title'] = "আজকের অফার প্রোডাক্ট সমূহ";

        return view('pages.front.products', ['collection' => $collection]);
    }

    // featured products
    public function featuredProducts()
    {
        $this->seo()->setTitle("বাছাইকৃত প্রোডাক্ট সমূহ");

        $collection['products'] = Product::where('status', true)->where('featured_status', true)->orderByDesc('id')->paginate(15);
        $collection['recentProducts'] = Product::where('status', true)->orderByDesc('created_at')->skip(0)->take(5)->get();
        $collection['categories'] = Category::where('status', true)->where('parent_id', null)->orderByDesc('id')->get();
        $collection['brands'] = Brand::where('status', true)->orderByDesc('id')->get();
        $collection['title'] = "বাছাইকৃত প্রোডাক্ট সমূহ";

        return view('pages.front.products', ['collection' => $collection]);
    }

    // product Details
    public function productDetails($slug)
    {
        // find product by slug
        $product = Product::where('slug', $slug)->where('status', true)->first();
        if(!$product){
            return abort(404, 'Product not found');
        }


        $this->seo()->setTitle($product->name);
        $this->seo()->setDescription($product->short_desc);
        $this->seo()->opengraph()->addImage(image_url($product->thumbnail, admin_asset('images/no-image/800x800.png')));

        return view('pages.front.product-details', compact('product'));
    }

    // about us
    public function page($slug)
    {
        $page = PageBuilder::where('slug', $slug)->first();

        if (!$page) {
            abort(404, 'Page not found');
        }

        $this->seo()->setTitle($page->title);

        return view('pages.front.page', compact('page'));
    }

    // contact us
    public function contactUs()
    {
        $this->seo()->setTitle("যোগাযোগ");
        return view('pages.front.contact-us');
    }

    // return attribute value depend on attribute id
    public function attributeValues(Request $request)
    {
        $find = AttributesSet::find($request->id);

        if(!$find){
            return response('attribute id not found');
        }

        return response($find->attributeValues);
    }

    // return attribute value depend on attribute id
    public function attributeValueDetails(Request $request)
    {
        $find = AttributesValue::find($request->id);

        if(!$find){
            return response([
                'status' => false,
                'data' => [],
                'message' => 'Data Found'
            ]);
        }

        return response([
            'status' => true,
            'data' => ['id' => $find->id, 'value' => $find->value],
            'message' => 'Data Found'
        ]);
    }

    // return color info depend on color id
    public function colorDetails(Request $request)
    {
        $find = Color::find($request->id);

        if(!$find){
            return response([
                'status' => false,
                'data' => [],
                'message' => 'Data Found'
            ]);
        }

        return response([
            'status' => true,
            'data' => ['id' => $find->id, 'name' => $find->name],
            'message' => 'Data Found'
        ]);
    }

}

<?php

namespace App\Http\Controllers;

use App\Models\Admin\Slider;
use Illuminate\Http\Request;
use App\Models\Admin\Product;
use App\Models\Admin\Category;
use App\Models\Admin\PageBuilder;
use App\Models\Admin\AttributesSet;
use App\Models\Admin\AttributesValue;
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
        $this->seo()->setTitle("হোম পেইজ");

        $collection['slider'] = Slider::where('status', true)->orderBy('order')->get();
        $products['todays_deals'] = Product::where('status', true)->where('todays_deal_status', true)->take(10)->orderByDesc('id')->get();
        $products['featured'] = Product::where('status', true)->where('featured_status', true)->take(6)->orderByDesc('id')->get();
        $products['products'] = Product::where('status', true)->take(10)->orderByDesc('id')->get();
        $categories = Category::where('status', true)->take(6)->orderBy('order')->get();

        return view('pages.front.index', ['collection' => $collection, 'products' => $products, 'categories' => $categories]);
    }

    // categories
    public function categories()
    {
        $this->seo()->setTitle("ক্যাটাগরি");

        $categories = Category::where('status', true)->orderByDesc('id')->get();
        return view('pages.front.categories', ['categories' => $categories]);
    }

    // Category Details
    public function categoryDetails(Category $category, $slug)
    {

        $this->seo()->setTitle($category->meta_title);
        $this->seo()->setDescription($category->meta_desc);
        $this->seo()->opengraph()->addImage(image_url($category->thumbnail, admin_asset('images/no-image/150x150.png')));


        $collection['products'] = Product::where('status', true)->where('category_id', $category->id)->orderByDesc('id')->paginate(15);
        $collection['recentProducts'] = Product::where('status', true)->orderByDesc('created_at')->skip(0)->take(5)->get();
        $collection['categories'] = Category::where('status', true)->where('parent_id', null)->orderByDesc('id')->get();
        $collection['brands'] = Brand::where('status', true)->orderByDesc('id')->get();

        return view('pages.front.category-details', ['collection' => $collection, 'item' => $category]);
    }

    // brands
    public function brands()
    {
        $this->seo()->setTitle("ব্রান্ডস");

        $brands = Brand::where('status', true)->orderByDesc('id')->get();
        return view('pages.front.brands', ['brands' => $brands]);
    }

    // Brand Details
    public function brandDetails(Brand $brand, $slug)
    {
        $this->seo()->setTitle($brand->meta_title);
        $this->seo()->setDescription($brand->meta_desc);
        $this->seo()->opengraph()->addImage(image_url($brand->thumbnail, admin_asset('images/no-image/150x150.png')));

        $collection['products'] = Product::where('status', true)->where('brand_id', $brand->id)->orderByDesc('id')->paginate(15);
        $collection['recentProducts'] = Product::where('status', true)->orderByDesc('created_at')->skip(0)->take(5)->get();
        $collection['categories'] = Category::where('status', true)->where('parent_id', null)->orderByDesc('id')->get();
        $collection['brands'] = Brand::where('status', true)->orderByDesc('id')->get();

        return view('pages.front.brand-details', ['collection' => $collection, 'item' => $brand]);
    }

    // products
    public function products(Request $request)
    {

        $this->seo()->setTitle("প্রোডাক্ট সমূহ");

        $products = new Product();

        $products = $products->where(function ($products) use ($request) {
            $products->where('name', 'LIKE', "%{$request->search}%");
            $products->orWhere('slug', 'LIKE', "%{$request->search}%");
            $products->orWhere('id', 'LIKE', "%{$request->search}%");
            $products->orWhere('sku', 'LIKE', "%{$request->search}%");
        });
        $products = $products->where('status', true)->paginate(15)->withQueryString();

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
    public function productDetails(Product $product, $slug)
    {
        $this->seo()->setTitle($product->meta_title);
        $this->seo()->setDescription($product->meta_desc);
        SEOMeta::addKeyword([$product->meta_keywords]);
        $this->seo()->opengraph()->addImage(image_url($product->thumbnail, admin_asset('images/no-image/800x800.png')));

        $recentProducts = Product::where('status', true)->orderByDesc('created_at')->skip(0)->take(5)->get();
        $relatedProducts = Product::with('category')->where('category_id', $product->category_id)->where('status', true)->where('slug', '!=', $product->slug)->inRandomOrder()->take(5)->get();
        if(count($relatedProducts) == 0){
            $relatedProducts = Product::with('brand')->where('brand_id', $product->brand_id)->where('status', true)->where('slug', '!=', $product->slug)->inRandomOrder()->take(5)->get();
        }

        return view('pages.front.product-details', ['product' => $product, 'recentProducts' => $recentProducts, 'relatedProducts' => $relatedProducts]);
    }

    // about us
    public function page($slug)
    {
        $page = PageBuilder::cacheData()->where('slug', $slug);


        if(count($page) == 1){

            // dd($page);

            foreach ($page as $value) {
                $this->seo()->setTitle($value->title);
            }

        }else{
            return abort(404);
        }

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

}

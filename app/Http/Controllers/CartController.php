<?php

namespace App\Http\Controllers;

use App\Models\Admin\Product;
use Illuminate\Http\Request;
use Artesaos\SEOTools\Facades\SEOMeta;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{

    public function __construct()
    {
        $this->seo()->setTitle("শপিং কার্ট");
        $this->seo()->setDescription(setting('site.description'));
        SEOMeta::addKeyword([setting('site.keywords')]);
        $this->seo()->opengraph()->addImage(image_url(setting('site.logo'), front_asset('images/logo.png')));
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function index()
    {
        return view('pages.front.cart');
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function addToCart($id)
    {
        $product = Product::findOrFail($id);

        if(!$product->stock_status) {
            return redirect()->back()->with('error', 'দুঃখিত, এই প্রোডাক্টটি বর্তমানে আমাদের স্টকে নেই।');
        }

        $cart = session()->get('shopping_cart', []);

        if(isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            $cart[$id] = [
                "product_id" => $product->id,
                "name" => $product->name,
                "quantity" => 1,
                "price" => $product->unit_price,
                "image" => image_url($product->thumbnail, admin_asset('images/no-image/800x800.png')),
            ];
        }

        session()->put('shopping_cart', $cart);

        return redirect()->back()->with('success', 'প্রোডাক্টটি আপনার শাপিং কার্টে যোগ করা হয়েছে');
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function update(Request $request)
    {
        $cart = session()->get('shopping_cart');
        foreach ($request->product_id as $key => $value) {
            if(isset($cart[$value]) && $request['product_quantity'][$key] > 0) {
                $cart[$value]["quantity"] = $request['product_quantity'][$key];
            }
            session()->put('shopping_cart', $cart);
        }

        return response()->json(['status' => true]);
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function remove(Request $request)
    {
        // dd($request->all());
        if($request->cart_id) {
            $cart = session()->get('shopping_cart');
            if(isset($cart[$request->cart_id])) {
                unset($cart[$request->cart_id]);
                session()->put('shopping_cart', $cart);
            }
        }
        return response()->json(['status' => true]);
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function clearCart()
    {
        session()->forget('shopping_cart');

        return redirect()->back()->with('success', 'আপনার শাপিং কার্ট খালি করা হয়েছে');
    }

    // link Generate
    public function confirmOrder(Request $request)
    {
        $text = '';
        $total = 0;
        $cart = session()->get('shopping_cart');

        if($cart == null){
            Session::flash('success', 'Your Cart Is Empty!');
            return response()->json(['status' => false, 'msg' => "Cart Is Empty!"]);
        }

        foreach ($request->product_id as $key => $value) {
            // find product by id
            $product = Product::find($request['product_id'][$key]);

            if($product){
                $cart[$value] = [
                    "product_id" => $product->id,
                    "name" => $product->name,
                    "quantity" => $request['product_quantity'][$key],
                    "price" => $product->unit_price,
                    "image" => image_url($product->thumbnail, admin_asset('images/no-image/800x800.png')),
                ];
                $text .= " ==>Name: " . $cart[$value]['name'] . ", Quantity: " . $cart[$value]['quantity'] . ", Price: " . $cart[$value]['price'] . "TK" . "\n";
                $total += $cart[$value]['price'] * $cart[$value]['quantity'];
            }
            session()->put('shopping_cart', $cart);
        }
        $text .= "\n ==>Total: " . $total . "TK";
        session()->forget('shopping_cart');

        return response()->json(['status' => true, 'msg' => "Your order has been created!", 'url' => "https://wa.me/".(setting('contact.whatsapp')??null)."?text=" . $text]);
    }

}

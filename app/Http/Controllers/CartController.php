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
        $this->seo()->setTitle("Shopping Cart");
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

    public function cartItemCount()
    {
        // Get the shopping cart from the session
        $cart = session()->get('shopping_cart', []);

        // Initialize count variable
        $count = 0;

        // Loop through the cart and calculate total quantity
        foreach ($cart as $item) {
            // Check if 'quantity' exists and is numeric before using it
            if (isset($item['quantity']) && is_numeric($item['quantity'])) {
                $count += (int) $item['quantity'];
            }
        }

        // Return the cart count as a JSON response
        return response()->json(['count' => $count]);
    }


    /**
     * Write code on Method
     *
     * @return response()
     */
    public function addToCart(Request $request, $id)
    {
        try {
            $product = Product::findOrFail($id);

            // Validate product availability, size, color, and quantity
            $request->validate([
                'quantity' => 'required|integer|min:1',
                'color' => 'nullable|integer|exists:colors,id', // assuming you have a Color model
                'size' => 'nullable|integer|exists:attributes_values,id',  // assuming you have a Size model
            ]);

            $cart = session()->get('shopping_cart', []);

            // Check if the product already exists in the cart with the same size and color
            $key = $id . '-' . $request->color . '-' . $request->size;  // unique key for the product based on size and color

            if (isset($cart[$key])) {
                $cart[$key]['quantity'] += $request->quantity;  // Update quantity if product with the same size/color already exists
            } else {
                // Add new product with size and color to the cart
                $cart[$key] = [
                    "product_id" => $product->id,
                    "name" => $product->name,
                    "quantity" => $request->quantity,
                    "price" => $product->unit_price,
                    "image" => $product->image_url,
                    "color" => $request->color,
                    "size" => $request->size,
                ];
            }

            session()->put('shopping_cart', $cart);

            // Return the updated cart and success message
            return response()->json(['success' => 'Product added to cart successfully!', 'cart' => $cart]);
        } catch (\Throwable $th) {
            // Return error message if product is not found
            return response()->json(['error' => $th->getMessage()]);
        }

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

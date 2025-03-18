<?php

namespace App\Http\Controllers;

use App\Models\Admin\AttributesValue;
use App\Models\Admin\Color;
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

     public function checkout()
     {
        // dd(session()->get('shopping_cart', []));
        $cart = collect(session()->get('shopping_cart', []))
            ->map(function ($item) {
                // Handle null values for color and size
                $color = $item['color'] !== null ? (string) $item['color'] : '';
                $size = $item['size'] !== null ? (string) $item['size'] : '';

                // Generate the same cart key format as addToCart() and remove()
                $cartKey = "{$item['product_id']}-{$color}-{$size}";

                // Map each item to an object with the correct values
                return (object) [
                    'cart_key'  => $cartKey, // Add the formatted cart key
                    'product_id' => $item['product_id'],
                    'name'       => $item['name'],
                    'quantity'   => $item['quantity'],
                    'price'      => $item['price'] * $item['quantity'], // Calculate total price
                    'image'      => $item['image'],
                    'color'      => Color::find($item['color'])->color_code ?? null,
                    'size'       => AttributesValue::find($item['size'])->value ?? null
                ];
            })
            ->values(); // Re-index the collection
        // dd($cart);

        // forget session
        // session()->forget('shopping_cart');

        return view('pages.front.checkout', compact('cart'));
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
                'color' => 'nullable|integer|exists:colors,id',
                'size' => 'nullable|integer|exists:attributes_values,id',
            ]);

            $cart = session()->get('shopping_cart', []);

            // Generate the unique key (product_id-color-size combination)
            $color = $request->color ?? null; // Handle null color
            $size = $request->size ?? null;  // Handle null size
            $cartKey = "{$id}-{$color}-{$size}"; // Create a unique key format

            if($color != null) $color = (int) $color;
            if($size != null) $size = (int) $size;

            if (isset($cart[$cartKey])) {
                // Update quantity if the product already exists in the cart
                $cart[$cartKey]['quantity'] += $request->quantity;
            } else {
                // Add new product to the cart
                $cart[$cartKey] = [
                    "product_id" => $product->id,
                    "name" => $product->name,
                    "quantity" => (int) $request->quantity,
                    "price" => (int) $product->price,
                    "image" => $product->thumbnail,
                    "color" => $request->color,
                    "size" => $request->size,
                ];
            }

            // Save the updated cart to the session
            session()->put('shopping_cart', $cart);

            return response()->json(['success' => 'Product added to cart successfully!', 'cart' => $cart]);

        } catch (\Throwable $th) {
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
        $cart = session()->get('shopping_cart', []);

        // Get the cart key
        $cartKey = $request->input('cart_key');

        // Check if item exists, then remove it
        if (isset($cart[$cartKey])) {
            unset($cart[$cartKey]); // Remove item from cart
            session()->put('shopping_cart', $cart); // Update session
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Item not found in cart!',
                'cart'    => $cart,
            ]);
        }

        return response()->json([
            'success'    => true,
            'message'    => 'Item removed successfully',
            'cart'       => $cart,
            'cart_count' => array_sum(array_column($cart, 'quantity')),
        ]);
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

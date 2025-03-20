<?php

namespace App\Http\Controllers;

use App\Models\Admin\Color;
use App\Models\Admin\Order;
use Illuminate\Http\Request;
use App\Models\Admin\Product;
use App\Models\Admin\OrderItem;
use Illuminate\Support\Facades\DB;
use App\Models\Admin\AttributesValue;
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
     * Execute the code
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


     // count cart items
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

    // calculate cart amount
    public function calculateCartAmount(Request $request)
    {
        $inside_area = $request->inside_area ?? 'inside';

        // Get the shopping cart from the session
        $cart = session()->get('shopping_cart', []);

        // Initialize the total amount variables
        $subtotal = 0;
        $shipping_fee = (int) (setting('site.inside_area') ?? 0);

        // Loop through the cart and calculate total amount
        foreach ($cart as $item) {
            // find the product by product_id
            $product = Product::find($item['product_id'] ?? null);
            if($product){
                // Check if 'quantity' exists and is numeric before using it
                if (isset($item['quantity']) && is_numeric($item['quantity'])) {
                    $subtotal += (int) $item['quantity'] * $product->price;
                }
            }
        }

        // shipping fee
        if($inside_area == 'outside') $shipping_fee = (int) (setting('site.outside_area') ?? 0);

        // Calculate the total amount
        $total = $subtotal + $shipping_fee;

        // Return the cart amount as a JSON response
        return response()->json([
            'subtotal' => $subtotal,
            'shipping_fee' => $shipping_fee,
            'total' => $total,
        ]);
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

        return redirect()->back()->with('success', 'Cart cleared successfully!');
    }

    // confirm order
    public function confirmOrder(Request $request)
    {
        try {
            $data = $request->validate([
                'name' => 'required|string',
                'phone' => 'required|string',
                'address' => 'required|string',
                'inside_area' => 'required|string|in:inside,outside'
            ]);

            // Determine if the order is inside or outside the area
            $is_inside_area = ($data['inside_area'] === 'inside');

            // Get cart amount using calculateCartAmount() method
            $cartAmount = $this->calculateCartAmount($request)->original;

            // Retrieve cart from session
            $cart = session('shopping_cart', []);

            // If cart is empty, prevent order placement
            if (empty($cart)) {
                return response()->json(['error' => 'Your cart is empty. Please add items before placing an order.'], 400);
            }

            // Save order and order items inside a transaction
            try {
                $order = DB::transaction(function () use ($data, $cartAmount, $cart, $is_inside_area) {
                    // Create Order
                    $order = Order::create([
                        'name' => $data['name'],
                        'addr' => $data['address'],
                        'phone' => $data['phone'],
                        'is_inside_area' => $is_inside_area,
                        'sub_total' => $cartAmount['subtotal'],
                        'shipping_fee' => $cartAmount['shipping_fee'],
                        'total' => $cartAmount['total'],
                        'order_id' => Order::generateOrderId(),
                        'user_id' => auth()->id(),
                    ]);

                    // Add items to order
                    $orderItems = [];
                    foreach ($cart as $item) {
                        $orderItems[] = [
                            'order_id' => $order->id,
                            'product_id' => $item['product_id'],
                            'quantity' => $item['quantity'],
                            'rate' => $item['price'],
                            'total' => $item['quantity'] * $item['price'], // Corrected: using item's quantity
                            'color_id' => $item['color'] ?? null, // Handle null values safely
                            'size_id' => $item['size'] ?? null
                        ];
                    }

                    // Bulk insert order items for better performance
                    OrderItem::insert($orderItems);

                    return $order;
                });
            } catch (\Throwable $th) {
                return response()->json(['error' => 'Data Storing Issue!'], 500);
            }

            // Clear the shopping cart session
            session()->forget('shopping_cart');

            return response()->json(['success' => 'Order confirmed successfully!', 'link' => route('admin.orders.details', $order->id)]);
        } catch (\Throwable $th) {
            return response()->json(['error' => 'Something went wrong: ' . $th->getMessage()], 500);
        }
    }

}

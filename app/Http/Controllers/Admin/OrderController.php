<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    /**
     * Middleware
     *
     *
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(['permission:orders']);
        $this->middleware(['permission:orders_all'])->only(['statusUpdate', 'paymentConfirmed']);
        \config_set('theme.cdata', [
            'title'      => 'All Orders',
            'model'      => 'Order',
            'back'       => \back_url(),
            'breadcrumb' => [
                [
                    'name' => 'Dashboard',
                    'link' => route('admin.dashboard')
                ],
                [
                    'name' => 'All Orders',
                    'link' => false
                ],
            ]
        ]);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $collection = new Order();

        $collection = $collection->where(function ($collection) use ($request)
        {
            $collection->where('phone', 'LIKE', "%{$request->search}%");
            $collection->orWhere('name', 'LIKE', "%{$request->search}%");
            $collection->orWhere('addr', 'LIKE', "%{$request->search}%");
        });
        if(!can('orders_all')) $collection = $collection->where('user_id', auth()->id());
        $collection = $collection->orderByDesc('id')->paginate(20)->withQueryString();

        return \view('pages.admin.orders.index', \compact('collection'));
    }

    /**
     *
     * Order Details
     */
    public function orderDetails($orderId)
    {
        $order = Order::where('order_id', $orderId)->firstOrFail();

        if(!can('orders_all') && $order->user_id != auth()->id()) abort(403);

        \config_set('theme.cdata', [
            'title'      => 'Order Details',
            'breadcrumb' => [
                [
                    'name' => 'Dashboard',
                    'link' => route('admin.dashboard')
                ],
                [
                    'name' => 'Orders',
                    'link' => route('admin.orders.index')
                ],
                [
                    'name' => 'Order Details',
                    'link' => false
                ],
            ]
        ]);

        return \view('pages.admin.orders.details', ['item' => $order]);
    }


    /**
     *
     * Invoice
     */
    public function invoice($orderId)
    {
        $order = Order::where('order_id', $orderId)->firstOrFail();
        if(!can('orders_all') && $order->user_id != auth()->id()) abort(403);


        \config_set('theme.cdata', [
            'title'      => 'Invoice',
            'breadcrumb' => [
                [
                    'name' => 'Dashboard',
                    'link' => route('admin.dashboard')
                ],
                [
                    'name' => 'Orders',
                    'link' => route('admin.orders.index')
                ],
                [
                    'name' => 'Invoice',
                    'link' => false
                ],
            ]
        ]);

        return \view('pages.admin.orders.invoice', ['data' => $order]);
    }

    /**
     *
     * Order Status
     */
    public function statusUpdate(Order $order, Request $request){
        $validated = $request->validate([
            'status' => 'required|in:processing,completed,cancelled'
        ]);

        $order->status = $request->status;
        $order->save();

        return \back()->with('success', 'Order status updated successfully.');
    }

    /**
     *
     * Order Payment
     */
    public function paymentConfirmed(Order $order){
        $order->is_paid = true;
        $order->save();

        return \back()->with('success', 'Order payment updated successfully.');
    }
}

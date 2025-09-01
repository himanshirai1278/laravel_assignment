<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Events\OrderStatusUpdated;
use App\Notifications\OrderStatusChanged;

class OrderController extends Controller
{
    public function place(Request $r)
    {
        $data = $r->validate([
            'product_id'=>'required|exists:products,id',
            'quantity'=>'required|integer|min:1'
        ]);
        $product = Product::findOrFail($data['product_id']);
        if ($product->stock < $data['quantity']) return back()->withErrors(['qty'=>'Insufficient stock']);

        $total = $product->price * $data['quantity'];
        $order = Order::create([
            'customer_id'=>Auth::guard('customer')->id(),
            'status'=>'Pending',
            'total'=>$total
        ]);
        OrderItem::create([
            'order_id'=>$order->id,
            'product_id'=>$product->id,
            'quantity'=>$data['quantity'],
            'price'=>$product->price,
        ]);
        $product->decrement('stock', $data['quantity']);
        return back()->with('ok','Order placed.');
    }

    public function adminList()
    {
        $orders = Order::with('customer')->latest()->paginate(20);
        return view('admin.orders.index', compact('orders'));
    }

    public function updateStatus(Order $order, Request $r)
    {
        $r->validate(['status'=>'required|in:Pending,Shipped,Delivered']);
        $order->update(['status'=>$r->status]);

        // Broadcast + notify (no polling)
        broadcast(new OrderStatusUpdated($order))->toOthers();
        $order->customer->notify(new OrderStatusChanged($order->id,$order->status));

        return back()->with('ok','Status updated.');
    }
}

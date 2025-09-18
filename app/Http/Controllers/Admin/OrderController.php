<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
// Контроллер заказа
class OrderController extends Controller
{

    public function index()
    {
        $orders = Order::with("products")->where('status', 1)->get();
        return view('auth.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $products=$order->products()->withTrashed()->get();
        return view('auth.orders.show', compact('order', 'products'));
    }
}

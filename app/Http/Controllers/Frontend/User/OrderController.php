<?php

namespace App\Http\Controllers\Frontend\User;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    //
    public function index()
    {
        return view('frontend.user.order.index');
    }

    // show view method
    public function show($order_number)
    {
        $order = Order::where('order_number', $order_number)->first();
        return view('frontend.user.order.show', compact('order'));
    }

    // invoice view method
    public function invoice()
    {
        return view('frontend.user.invoice.index');
    }

    // returns view method
    public function returns()
    {
        return view('frontend.user.returns.index');
    }
}

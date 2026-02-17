<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    //order success page
    public function success($order_number)
    {
        return view('frontend.order.success', compact('order_number'));
    }

    // track order page
    public function track($order_number = null)
    {
        return view('frontend.order.track', compact('order_number'));
    }
}

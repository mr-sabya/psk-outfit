<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    //
    public function  index()
    {
        return view('backend.pages.orders.index');
    }

    // invoice view
    public function invoice($orderId)
    {
        return view('backend.pages.orders.invoice', compact('orderId'));
    }
}

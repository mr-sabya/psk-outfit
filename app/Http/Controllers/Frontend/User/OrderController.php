<?php

namespace App\Http\Controllers\Frontend\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    //
    public function index()
    {
        return view('frontend.user.order.index');
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

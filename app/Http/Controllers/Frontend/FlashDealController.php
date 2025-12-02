<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FlashDealController extends Controller
{
    // Display the flash deals page
    public function index()
    {
        return view('frontend.flash-deal.index');
    }
}

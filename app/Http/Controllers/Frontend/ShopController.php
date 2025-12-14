<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    // Shop page
    public function index()
    {
        return view('frontend.shop.index');
    }

    // Product details page
    public function show($slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();
        return view('frontend.product.show', compact('product'));
    }
}

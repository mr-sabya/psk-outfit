<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    //
    public function show($slug)
    {
        // Logic to retrieve and display the page based on the slug
        $page = Page::where('slug', $slug)->active()->firstOrFail();
        return view('frontend.pages.show', compact('page'));
    }
}

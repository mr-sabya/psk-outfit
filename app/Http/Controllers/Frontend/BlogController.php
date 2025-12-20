<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    // Blog index page
    public function index()
    {
        return view('frontend.blog.index');
    }

    // Blog detail page
    public function show($slug)
    {
        $blog = BlogPost::where('slug', $slug)->firstOrFail();
        return view('frontend.blog.show', compact('blog'));
    }
}

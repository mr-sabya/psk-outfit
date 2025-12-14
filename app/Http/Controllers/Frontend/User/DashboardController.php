<?php

namespace App\Http\Controllers\Frontend\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //
    public function index()
    {
        return view('frontend.user.dashboard.index');
    }

    // profile
    public function profile()
    {
        return view('frontend.user.profile.index');
    }

    // reviews
    public function reviews()
    {
        return view('frontend.user.reviews.index');
    }

    // password
    public function password()
    {
        return view('frontend.user.password.index');
    }
}

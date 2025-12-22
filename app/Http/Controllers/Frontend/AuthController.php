<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    //login
    public function login()
    {
        return view('frontend.auth.login');
    }

    // register
    public function register()
    {
        return view('frontend.auth.register');
    }
}

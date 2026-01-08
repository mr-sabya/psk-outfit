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

     /**
     * Show the forgot password form.
     */
    public function forgotPassword()
    {
        return view('frontend.auth.forgot-password');
    }

    /**
     * Show the reset password form.
     */
    public function resetPassword(Request $request, $token)
    {
        return view('frontend.auth.reset-password', [
            'token' => $token,
            'email' => $request->email
        ]);
    }
    
}

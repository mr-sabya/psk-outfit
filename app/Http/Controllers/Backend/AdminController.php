<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminController extends Controller
{

    public function index()
    {
        return view('backend.admin.index');
    }

    public function showForgotPassword() {}

    public function showResetPassword($token)
    {
        return view('backend.auth.pages.reset-password', ['token' => $token]);
    }

    /**
     * Show the admin profile update page.
     */
    public function profile()
    {
        return view('backend.admin.profile');
    }

    /**
     * Show the admin change password page.
     */
    public function changePassword()
    {
        return view('backend.admin.change-password');
    }
}

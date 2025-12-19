<?php

namespace App\Http\Controllers\Frontend\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    //
    public function index()
    {
        return view('frontend.user.address.index');
    }

    // create address
    public function create()
    {
        return view('frontend.user.address.create');
    }

    // edit address
    public function edit($id)
    {
        return view('frontend.user.address.edit', compact('id'));
    }
}

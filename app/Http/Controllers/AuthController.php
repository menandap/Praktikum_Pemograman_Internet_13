<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class AuthController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
    */
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }
    
    public function homepage()
    {
        return view('homepage');
    }

    public function cart()
    {
        return view('cart');
    }

    public function product()
    {
        return view('product');
    }

    public function detailproduct()
    {
        return view('detail-product');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\Product_categories;
use App\Models\Product_category_details;
use App\Models\Product_images;
use App\Models\Product_reviews;
use App\Models\Product;
use App\Models\Discounts;
use App\Models\Responses;
use Redirect;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Pagination\Paginator;

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
        $categories = Product_categories::with('product')->get();
        $products = Product::with('product_images','product_category_details','product_categories')->get();
        $discounts = DB::table('discounts')
        ->select('discounts.*')
        ->get();
        return view('homepage', ['product' => $products, 'product_categories' => $categories, 'discount' => $discounts]);
    }

    public function cart()
    {
        return view('cart');
    }

    public function product()
    {
        $categories = Product_categories::with('product')->get();
        $products = Product::with('product_images','product_category_details','product_categories')->get();
        $discounts = DB::table('discounts')
        ->select('discounts.*')
        ->get();
        return view('product', ['product' => $products, 'product_categories' => $categories, 'discount' => $discounts]);
    }

    public function detail_product($id)
    {
        $categories = Product_categories::with('product')->get();
        $products = Product::with('product_images','product_category_details','product_categories')->get();
        return view('detail_product', ['product' => $products, 'product_categories' => $categories]);
    }
}

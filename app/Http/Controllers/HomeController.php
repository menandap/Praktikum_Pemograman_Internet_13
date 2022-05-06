<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Session\Session;
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

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $categories = Product_categories::with('product')->get();
        $products = Product::with('product_images','product_category_details','product_categories')->get();
        $discounts = DB::table('discounts')
        ->select('discounts.*')
        ->get();
        return view('homepage', ['product' => $products, 'product_categories' => $categories, 'discount' => $discounts]);
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
        $where = array('products.id' => $id);
    	$products['products'] = DB::table('products')
            ->join('product_category_details', 'products.id','=','product_category_details.product_id')
            ->join('product_categories', 'product_categories.id','=','product_category_details.category_id')
            ->select('products.*','product_categories.category_name')
            ->where($where)->first();
        $image = DB::table('products')
            ->join('product_images', 'products.id', '=', 'product_images.product_id')
            ->select('product_images.*')
            ->where($where)->get();
        $categories = DB::table('product_categories')
            ->join('product_category_details', 'product_categories.id', '=', 'product_category_details.category_id')
            ->join('products', 'products.id', '=', 'product_category_details.product_id')
            ->select('product_categories.category_name')
            ->where('products.id', '=', $id)->get();
        $stoks = DB::table('product_stoks')
            ->join('product_stok_details', 'product_stoks.id', '=', 'product_stok_details.stok_id')
            ->join('products', 'products.id', '=', 'product_stok_details.product_id')
            ->select('product_stoks.stok_name', 'product_stok_details.id', 'product_stok_details.stok')
            ->where('products.id', '=', $id)->get();
        // return $stoks;
        $reviews = DB::table('product_reviews')->join('users', 'users.id', '=', 'product_reviews.user_id')
            ->select('product_reviews.*', 'users.name')->where('product_reviews.product_id', '=',$id)
            ->orderby('product_reviews.id', 'desc')->get();
        $responses = DB::table('responses')->select('responses.*')->get();
        $discount = DB::table('discounts')
        ->select('discounts.*')
        ->get();
        return view('detail_product', compact('products','reviews','responses', 'image','categories','id','discount','stoks'));
    }
}

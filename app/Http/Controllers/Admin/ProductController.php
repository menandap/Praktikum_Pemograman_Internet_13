<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product_categories;
use App\Models\Product_category_details;
use App\Models\Product_stoks;
use App\Models\Product_stok_details;
use App\Models\Product_images;
use App\Models\Product_reviews;
use App\Models\Product;
use App\Models\Discounts;
use App\Models\Responses;
use Redirect;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Pagination\Paginator;

class ProductController extends Controller
{

    public function index(){
        // $products = Product::all();
        // $categories = ProductCategories::all();
        // $discounts = Discount::all() ;

        // dd($products);
        // return view('pages.admins.product.productlist', compact('products','categories','discounts'));

        $products = DB::table('products')
            ->select('products.*')->paginate(5);
        Paginator::useBootstrap();
        $categories = DB::table('product_categories')
            ->join('product_category_details','product_categories.id','=','product_category_details.category_id')
            ->select('product_categories.*','product_category_details.*')
            ->get();
        $discount = DB::table('discounts')
            ->select('discounts.*')
            ->get();
        return view('pages.admins.product.productlist', compact('products','categories','discount'));
    }

    public function create(){
        $categories = Product_categories::all();
        return view('pages.admins.product.productcreate', compact('categories'));
    }

    public function store(Request $request){
        $this->validate($request,[
            'product_name' => 'required|unique:products|max:100',
            'price' => 'required|numeric',
            'weight' => 'required|numeric|min:0',
        ]);

        $product = new Product;

        $product->product_name = $request->product_name;
        $product->price = $request->price;
        $product->description = $request->description;
        $product->product_rate = 0;
        $product->weight = $request->weight;
        $product->save();

        $kategoridata = $request->category_id;
        foreach($kategoridata as $kategori){
            $category = new Product_category_details;
            $product_id = Product::orderBy('id','desc')->first()->id;
            $category->category_id = $kategori;
            $category->product_id = $product_id;
            $category->save();
        }

        $this->validate($request, [
            'files.*' => 'required',
        ]);
        
        $id = Product::orderBy('id','desc')->first()->id;       
        if($id){
            $files = [];
            foreach($request->file('files') as $file){
                if($file->isValid()){
                    $nama_image = time()."_".$file->getClientOriginalName();
                    Storage::putFileAs('public', $file, $nama_image);
                    $files[] = [
                        'product_id' => $id,
                        'image_name' => 'storage/' . $nama_image,
                    ];
                }
            }
            Product_images::insert($files);
        }

        return Redirect::to('/admin/products')->with(['success' => 'Berhasil menambahkan produk']);
    }

    public function edit($id){
        $category = Product_categories::all();
        $categoryDetail = DB::table('product_category_details')
            ->select('category_id')
            ->where('product_id', '=', $id)->get();
        $products = Product::find($id); 
        // $discount = Discount::all();
        // dd($discount);
        return view('pages.admins.product.productedit', compact('category','categoryDetail','products'));
    }

    public function update(Request $request, $id){
        $this->validate($request,[            
            'price' => 'required|numeric',
            'weight' => 'required|numeric|min:0',
        ]);

        $update = [
            'product_name' => $request->product_name,
            'price' => $request->price,
            'description' => $request->description,
            'weight' => $request->weight,
        ];
        Product::where('id', $id)->update($update);

        Product_category_details::where('product_id','=',$id)->delete();
        $kategoridata = $request->category_id;
        foreach($kategoridata as $category){
            $categoryDetail = new Product_category_details;
            $categoryDetail->product_id = $id;
            $categoryDetail->category_id = $category;
            $categoryDetail->save();
        }

        $discount = new Discounts;
        $discount->percentage = $request->percentage;
        $discount->product_id = $id;
        $discount->start = $request->start;
        $discount->end = $request->end;
        if(!empty($request->percentage)) {
            $discount->save();    
        }
        
        return Redirect::to('/admin/products')->with(['success' => 'Berhasil mengedit produk']);
    }

    public function delete($id){
        Product_category_details::where('product_id',$id)->delete();
        // Discounts::where('id_product',$id)->delete();
        Product_images::where('product_id',$id)->delete();
        Product::where('id', $id)->delete();

        return Redirect::to('/admin/products')->with(['error' => 'Berhasil menghapus produk']);
    }

    public function show($id){
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
        $category_details = DB::table('product_category_details')
        ->select('product_category_details.*')
        ->get();
        $categories = DB::table('product_categories')
            ->join('product_category_details', 'product_categories.id', '=', 'product_category_details.category_id')
            ->join('products', 'products.id', '=', 'product_category_details.product_id')
            ->select('product_categories.category_name', 'product_category_details.id')
            ->where('products.id', '=', $id)->get();
        $stoks = DB::table('product_stoks')
            ->join('product_stok_details', 'product_stoks.id', '=', 'product_stok_details.stok_id')
            ->join('products', 'products.id', '=', 'product_stok_details.product_id')
            ->select('product_stoks.stok_name', 'product_stok_details.id', 'product_stok_details.stok')
            ->where('products.id', '=', $id)->get();
        $reviews = DB::table('product_reviews')->join('users', 'users.id', '=', 'product_reviews.user_id')
            ->select('product_reviews.*', 'users.name')->where('product_reviews.product_id', '=',$id)
            ->orderby('product_reviews.id', 'desc')->get();
        $responses = DB::table('responses')->select('responses.*')->get();
        $discount = DB::table('discounts')
        ->select('discounts.*')
        ->get();
        return view('pages.admins.product.productdetail', compact('products','reviews','responses', 'image','categories','id','discount', 'category_details','stoks'));
    }
    
    // Images

    public function uploadImage($id){
        $products = Product::find($id);
        return view('pages.admins.product.productaddimage', compact('products','id'));
    }

    public function upload(Request $request, $id){
        $this->validate($request, [
            'files.*' => 'required',
        ]);   
        
        $files = [];
        foreach($request->file('files') as $file){
            if($file->isValid()){
                $nama_image = time()."_".$file->getClientOriginalName();
                Storage::putFileAs('public', $file, $nama_image);
                $files[] = [
                    'product_id' => $id,
                    'image_name' => 'storage/' . $nama_image,
                ];
            }
        }
        Product_images::insert($files);
        
        return redirect()->back(); 
    }

    public function deleteImage($id){
        $categories = Product_images::find($id)->image_name;
        Storage::disk('local')->delete('public/storage/'.$categories);
        Product_images::where('id',$id)->delete();
        return redirect()->back(); 
    }

    // Discount
    
    public function addDiscount($id){
        $products = Product::find($id);
        return view('pages.admins.product.productadddiscount', compact('products','id'));
    }

    public function editDiscount($id){
        $products = Product::find($id);
        $discounts = DB::table('discounts')
            ->join('products', 'products.id', '=', 'discounts.product_id')
            ->select('discounts.id','discounts.product_id','discounts.start','discounts.end','discounts.percentage')
            ->where('products.id', '=',$id)->first();
        return view('pages.admins.product.producteditdiscount', compact('products','id','discounts'));
    }

    public function uploadDiscount(Request $request, $id){
        $this->validate($request, [
            'percentage' => 'required|numeric|max:100',
            'end' => 'required',
            'start' => 'required',
        ]);   
        
        $discount = new Discounts;
        $discount->percentage = $request->percentage;
        $discount->product_id = $id;
        $discount->start = $request->start;
        $discount->end = $request->end;
        if(!empty($request->percentage)) {
            $discount->save();    
        }
        
        return redirect()->route('admin.productdetail', $discount->product_id);
    }

    public function updateDiscount(Request $request, $id){
        $this->validate($request, [
            'percentage' => 'required|numeric|max:100',
            'end' => 'required',
            'start' => 'required',
        ]);  
        
        $dicounts = [
            'percentage' => $request->percentage,
            'end' => $request->end,
            'start' => $request->start
        ];
        Discounts::where('id',$id)->update($dicounts);
        $diskon = DB::table('discounts')
        ->select('product_id')
        ->where('id','=',$id)
        ->first();
        return redirect()->route('admin.productdetail', $diskon->product_id);
    }

    public function deleteDiscount($id){
        Discounts::find($id);
        $discounts = Discounts::find($id);
        $discounts->delete();
        return redirect()->back(); 
    }

    // Category
    
    public function addCategory($id){
        $data = DB::table('product_categories')
        ->join('product_category_details', 'product_categories.id', '=', 'product_category_details.category_id')
        ->join('products', 'products.id', '=', 'product_category_details.product_id')
        ->select('product_categories.category_name', 'product_category_details.id')
        ->where('products.id', '=', $id)->get();
        $products = Product::find($id);
        $categories = Product_categories::all();
        return view('pages.admins.product.productaddcategory', compact('products','id','categories','data'));
    }

    public function uploadCategory(Request $request, $id){ 
        $kategoridata = $request->category_id;
        foreach($kategoridata as $category){
            $categoryDetail = new Product_category_details;
            $categoryDetail->product_id = $id;
            $categoryDetail->category_id = $category;
            $categoryDetail->save();
        }
        
        return redirect()->route('admin.productdetail', $categoryDetail->product_id); 
    }

    public function deleteCategory($id){
        Product_category_details::find($id);
        $categories =  Product_category_details::find($id);
        $categories->delete();
        return redirect()->back(); 
    }

    // Stok

    public function addStok($id){
        $data = DB::table('product_stoks')
        ->join('product_stok_details', 'product_stoks.id', '=', 'product_stok_details.stok_id')
        ->join('products', 'products.id', '=', 'product_stok_details.product_id')
        ->select('product_stoks.stok_name', 'product_stok_details.id', 'product_stok_details.stok')
        ->where('products.id', '=', $id)->get();
        $products = Product::find($id);
        $stoks = Product_stoks::all();
        return view('pages.admins.product.productaddstok', compact('products','id','stoks','data'));
    }

    public function editStok($id){
        $stoks = DB::table('product_stoks')
        ->join('product_stok_details', 'product_stoks.id', '=', 'product_stok_details.stok_id')
        ->join('products', 'products.id', '=', 'product_stok_details.product_id')
        ->select('product_stoks.stok_name', 'product_stok_details.stok_id', 'product_stok_details.id', 'product_stok_details.stok', 'product_stok_details.product_id')
        ->where('product_stok_details.id', '=', $id)->first();
        return view('pages.admins.product.producteditstok', compact('stoks'));
    }

    public function uploadStok(Request $request, $id){ 
        $this->validate($request,[
            'stok' => 'required|numeric|min:0',
        ]);

        $stokdata = $request->stok_id;
        foreach($stokdata as $stock){
            $stokDetail = new Product_stok_details;
            $stokDetail->product_id = $id;
            $stokDetail->stok_id = $stock;
        }

        $stokDetail->stok = $request->stok;
        $stokDetail->save();
        return redirect()->route('admin.productdetail', $stokDetail->product_id); 
    }

    public function updateStok(Request $request, $id){
        $this->validate($request,[
            'stok' => 'required|numeric|min:0',
        ]);

        $stokDetail = [
            'stok' => $request->stok,
        ];
        Product_stok_details::where('id',$id)->update($stokDetail);
        $stok = DB::table('product_stok_details')
        ->select('product_id')
        ->where('id','=',$id)
        ->first();
        return redirect()->route('admin.productdetail', $stok->product_id);
    }

    public function deleteStok($id){
        Product_stok_details::find($id);
        $stoks =  Product_stok_details::find($id);
        $stoks->delete();
        return redirect()->back(); 
    }
    
    
}

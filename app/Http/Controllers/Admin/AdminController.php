<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Admin;
use App\Models\Carts;
use App\Models\Cities;
use App\Models\Product;
use App\Models\Couriers;
use App\Models\Discounts;
use App\Models\Provinces;
use App\Models\Responses;
use App\Models\Transactions;
use Illuminate\Http\Request;
use App\Models\Product_images;
use App\Models\Product_review;
use App\Models\Product_categories;
use App\Models\User_notifications;
use App\Models\Admin_notifications;
use App\Models\Transaction_details;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\Paginator;
use App\Models\Personal_access_tokens;
use App\Models\Product_category_details;

class AdminController extends Controller
{
    //Admin
    public function list_admin()
    {
        $admin = Admin::orderBy('id')->paginate(5);
        Paginator::useBootstrap();
        // dd($kondisi->kondisi);
        return view('list_admin', compact('admin'));
    }

    public function create_admin()
    {
        return view('create_admin')->with('create', 'create');
    }

    public function store_admin(Request $request)
    {
        $this->validate($request,[
            'username' => 'required',
            'password' => 'required',
            'name' => 'required',
            'profile_image' => 'required',
            'phone' => 'required'
        ]);

        Admin::create($request->all());
        return redirect()->route('store_admin')->with('success', 'Berhasil Tambah admin');
    }

    public function edit_admin($id)
    {
        $admin = Admin::find($id);
        return view('edit_admin', compact('admin'))->with('ubah', 'ubah');
    }

    public function update_admin(Request $request, $id)
    {
        $this->validate($request,[
            'username' => 'required',
            'password' => 'required',
            'name' => 'required',
            'profile_image' => 'required',
            'phone' => 'required'
        ]);

        Admin::find($id)->update($request->all());
        return redirect()->route('update_admin')->with('success', 'Berhasil Ubah Data Admin');

    }

    public function hapus_admin($id)
    {
        $admin = Admin::where('id', '=', $id)->get();
        $admin->delete();
        return redirect()->route('hapus_admin')->with('success', 'Berhasil Hapus Data Admin');

    }

    //User
    public function list_user()
    {
        $user = User::orderBy('id')->paginate(5);
        Paginator::useBootstrap();
        // dd($kondisi->kondisi);
        return view('list_user', compact('user'));
    }

    public function create_user()
    {
        return view('create_user')->with('create', 'create');
    }

    public function store_user(Request $request)
    {
        $this->validate($request,[
            'name' => 'required',
            'email' => 'required',
            'profile_image' => 'required',
            'status' => 'required',
            'email_verified_at' => 'required',
            'password' => 'required'
        ]);

        User::create($request->all());
        return redirect()->route('store_user')->with('success', 'Berhasil Tambah Data User');
    }

    public function edit_user($id)
    {
        $user = User::find($id);
        return view('edit_user', compact('user'))->with('ubah', 'ubah');
    }

    public function update_user(Request $request, $id)
    {
        $this->validate($request,[
            'name' => 'required',
            'email' => 'required',
            'profile_image' => 'required',
            'status' => 'required',
            'email_verified_at' => 'required',
            'password' => 'required'
        ]);

        User::find($id)->update($request->all());
        return redirect()->route('update_user')->with('success', 'Berhasil Ubah Data User');

    }

    public function hapus_user($id)
    {
        $user = User::where('id', '=', $id)->get();
        $user->delete();
        return redirect()->route('hapus_user')->with('success', 'Berhasil Hapus Data User');

    }
    
    //product categories
    public function list_product_categories()
    {
        $product_categories = Product_categories::orderBy('id')->paginate(5);
        Paginator::useBootstrap();
        return view('list_product_categories', compact('product_categories'));
    }

    public function create_product_categories()
    {
        return view('create_product_categories')->with('create', 'create');
    }

    public function store_product_categories(Request $request)
    {
        $this->validate($request,[
            'category_name' => 'required'
        ]);

        Product_categories::create($request->all());
        return redirect()->route('store_product_categories')->with('success', 'Berhasil Tambah Data Product Categories');
    }

    public function edit_product_categories($id)
    {
        $product_categories = Product_categories::find($id);
        return view('edit_product_categories', compact('product_categories'))->with('ubah', 'ubah');
    }

    public function update_product_categories(Request $request, $id)
    {
        $this->validate($request,[
            'category_name' => 'required'
        ]);

        Product_categories::find($id)->update($request->all());
        return redirect()->route('update_product_categories')->with('success', 'Berhasil Ubah Data Product Categories');

    }

    public function hapus_product_categories($id)
    {
        $product_categories = Product_categories::where('id', '=', $id)->get();
        $product_categories->delete();
        return redirect()->route('hapus_product_categories')->with('success', 'Berhasil Hapus Data Product Categories');

    }
    
    //couriers
    public function list_couriers()
    {
        $couriers = Couriers::orderBy('id')->paginate(5);
        Paginator::useBootstrap();
        return view('list_couriers', compact('list_couriers'));
    }

    public function create_couriers()
    {
        return view('create_couriers')->with('create', 'create');
    }

    public function store_couriers(Request $request)
    {
        $this->validate($request,[
            'courier' => 'required'
        ]);

        Couriers::create($request->all());
        return redirect()->route('store_couriers')->with('success', 'Berhasil Tambah Data Couriers');
    }

    public function edit_couriers($id)
    {
        $couriers = Couriers::find($id);
        return view('edit_couriers', compact('couriers'))->with('ubah', 'ubah');
    }

    public function update_couriers(Request $request, $id)
    {
        $this->validate($request,[
            'courier' => 'required'
        ]);

        Couriers::find($id)->update($request->all());
        return redirect()->route('update_couriers')->with('success', 'Berhasil Ubah Data Couriers');

    }

    public function hapus_couriers($id)
    {
        $couriers = Couriers::where('id', '=', $id)->get();
        $couriers->delete();
        return redirect()->route('hapus_couriers')->with('success', 'Berhasil Hapus Data Couriers');

    }

    //products
    public function list_products()
    {
        $products = Product::orderBy('id')->paginate(5);
        Paginator::useBootstrap();
        return view('list_products', compact('list_products'));
    }

    public function create_products()
    {
        return view('create_products')->with('create', 'create');
    }

    public function store_products(Request $request)
    {
        $this->validate($request,[
            'user_id' => 'required',
            'product_name' => 'required',
            'slug' => 'required',
            'price' => 'required',
            'description' => 'required',
            'product_rate' => 'required',
            'stock' => 'required',
            'weight' => 'required',
            'kondisi' => 'required'
        ]);

        Product::create($request->all());
        return redirect()->route('store_products')->with('success', 'Berhasil Tambah Data products');
    }

    public function edit_products($id)
    {
        $products = Product::find($id);
        return view('edit_products', compact('products'))->with('ubah', 'ubah');
    }

    public function update_products(Request $request, $id)
    {
        $this->validate($request,[
            'user_id' => 'required',
            'product_name' => 'required',
            'slug' => 'required',
            'price' => 'required',
            'description' => 'required',
            'product_rate' => 'required',
            'stock' => 'required',
            'weight' => 'required',
            'kondisi' => 'required'
        ]);

        Product::find($id)->update($request->all());
        return redirect()->route('update_products')->with('success', 'Berhasil Ubah Data products');

    }

    public function hapus_products($id)
    {
        $products = Product::where('id', '=', $id)->get();
        $products->delete();
        return redirect()->route('hapus_products')->with('success', 'Berhasil Hapus Data products');
    }

    //Discount
    public function list_discounts()
    {
        $discounts = Discounts::orderBy('id')->paginate(5);
        Paginator::useBootstrap();
        return view('list_discounts', compact('list_discounts'));
    }

    public function create_discounts()
    {
        return view('create_discounts')->with('create', 'create');
    }

    public function store_discounts(Request $request)
    {
        $this->validate($request,[
            'user_id' => 'required',
            'product_name' => 'required',
            'slug' => 'required',
            'price' => 'required',
            'description' => 'required',
            'product_rate' => 'required',
            'stock' => 'required',
            'weight' => 'required',
            'kondisi' => 'required'
        ]);

        Discounts::create($request->all());
        return redirect()->route('store_discounts')->with('success', 'Berhasil Tambah Data discounts');
    }

    public function edit_discounts($id)
    {
        $discounts = Discounts::find($id);
        return view('edit_discounts', compact('discounts'))->with('ubah', 'ubah');
    }

    public function update_discounts(Request $request, $id)
    {
        $this->validate($request,[
            'user_id' => 'required',
            'Discounts_name' => 'required',
            'slug' => 'required',
            'price' => 'required',
            'description' => 'required',
            'Discounts_rate' => 'required',
            'stock' => 'required',
            'weight' => 'required',
            'kondisi' => 'required'
        ]);

        Discounts::find($id)->update($request->all());
        return redirect()->route('update_discounts')->with('success', 'Berhasil Ubah Data discounts');

    }

    public function hapus_discounts($id)
    {
        $discounts = Discounts::where('id', '=', $id)->get();
        $discounts->delete();
        return redirect()->route('hapus_discounts')->with('success', 'Berhasil Hapus Data discounts');
    }
    
    // MASTER DATA

    //provinces
    public function list_provinces()
    {
        $provinces = Provinces::orderBy('id')->paginate(5);
        Paginator::useBootstrap();
        return view('list_provinces', compact('list_provinces'));
    }

    public function create_provinces()
    {
        return view('create_provinces')->with('create', 'create');
    }

    public function store_provinces(Request $request)
    {
        $this->validate($request,[
            'province' => 'required'
        ]);

        Provinces::create($request->all());
        return redirect()->route('store_provinces')->with('success', 'Berhasil Tambah Data Provinces');
    }

    public function edit_provinces($id)
    {
        $provinces = Provinces::find($id);
        return view('edit_provinces', compact('provinces'))->with('ubah', 'ubah');
    }

    public function update_provinces(Request $request, $id)
    {
        $this->validate($request,[
            'province' => 'required'
        ]);

        Provinces::find($id)->update($request->all());
        return redirect()->route('update_provinces')->with('success', 'Berhasil Ubah Data Provinces');

    }

    public function hapus_provinces($id)
    {
        $provinces = Provinces::where('id', '=', $id)->get();
        $provinces->delete();
        return redirect()->route('hapus_provinces')->with('success', 'Berhasil Hapus Data Provinces');
    }

    //cities
    public function list_cities()
    {
        $cities = Cities::orderBy('id')->paginate(5);
        Paginator::useBootstrap();
        return view('list_cities', compact('list_cities'));
    }

    public function create_cities()
    {
        return view('create_cities')->with('create', 'create');
    }

    public function store_cities(Request $request)
    {
        $this->validate($request,[
            'province_id' => 'required',
            'type' => 'required',
            'city_name' => 'required',
            'postal_code' => 'required'
        ]);

        Cities::create($request->all());
        return redirect()->route('store_cities')->with('success', 'Berhasil Tambah Data Cities');
    }

    public function edit_cities($id)
    {
        $cities = Cities::find($id);
        return view('edit_cities', compact('cities'))->with('ubah', 'ubah');
    }

    public function update_cities(Request $request, $id)
    {
        $this->validate($request,[
            'province_id' => 'required',
            'type' => 'required',
            'city_name' => 'required',
            'postal_code' => 'required'
        ]);

        Cities::find($id)->update($request->all());
        return redirect()->route('update_cities')->with('success', 'Berhasil Ubah Data Cities');

    }

    public function hapus_cities($id)
    {
        $cities = Cities::where('id', '=', $id)->get();
        $cities->delete();
        return redirect()->route('hapus_cities')->with('success', 'Berhasil Hapus Data Cities');
    }
    
}

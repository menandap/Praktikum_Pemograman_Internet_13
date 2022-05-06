<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product_categories;
use App\Models\Product_category_details;
use Illuminate\Http\Request;
use Redirect;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\Paginator;

class CategoryController extends Controller
{

    public function index(){
        $categories = Product_categories::paginate(5);
        Paginator::useBootstrap();
        return view('pages.admins.category.index', compact('categories'));
    }
    
    public function create(){
        return view('pages.admins.category.create');
    }
    
    public function store(Request $request){
        $this->validate($request,[
            'category_name' => 'required|unique:product_categories|max:100'
        ]);

        $category = Product_categories::create([
            'category_name' => $request->category_name
        ]);
        $category->save();
        return Redirect::to('/admin/categories')->with(['success' => 'Berhasil menambahkan kategori']);
    }

    public function edit($id){
        $category = Product_categories::find($id);        
        return view('pages.admins.category.edit', compact('category'));        
    }    

    public function update(Request $request, $id){
        $this->validate($request,[
            'category_name' => 'required|unique:product_categories|max:100'
        ]);
        $category = Product_categories::find($id);
        $category->update([
            'category_name' => $request->category_name
        ]);
        return Redirect::to('/admin/categories')->with(['success' => 'Berhasil mengedit kategori']);
    }

    public function delete($id){
        // Product_category_details::where('category_id',$id)->delete();
        $categories = Product_categories::find($id);
        $categories->delete();
        return Redirect::to('/admin/categories')->with(['error' => 'Berhasil menghapus kategori']);
    }

}

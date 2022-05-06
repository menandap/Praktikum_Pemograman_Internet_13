<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Couriers;
use Redirect;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\Paginator;

class CourierController extends Controller
{
    
    public function index(){
        $couriers = Couriers::paginate(5);
        Paginator::useBootstrap();
        return view('pages.admins.courier.courierlist', compact('couriers'));
    }
    
    public function create(){
        return view('pages.admins.courier.couriercreate');
    }
    
    public function store(Request $request){
        $this->validate($request,[
            'courier' => 'required|unique:couriers|max:100'
        ]);

        $couriers = Couriers::create([
            'courier' => $request->courier
        ]);
        $couriers->save();
        return Redirect::to('/admin/couriers')->with(['success' => 'Berhasil menambahkan kurir']);
    }

    public function edit($id){
        $courier = Couriers::find($id);
        return view('pages.admins.courier.courieredit', compact('courier'));        
    }    

    public function update(Request $request, $id){
        $this->validate($request,[
            'courier' => 'required|unique:couriers|max:100'
        ]);

        $courier = Couriers::find($id);
        $courier->update([
            'courier' => $request->courier
        ]);
        return Redirect::to('/admin/couriers')->with(['success' => 'Berhasil mengedit kurir']);
    }

    public function delete($id){
        $couriers = Couriers::find($id);
        $couriers->delete();
        return Redirect::to('/admin/couriers')->with(['error' => 'Berhasil menghapus kurir']);
    }
}

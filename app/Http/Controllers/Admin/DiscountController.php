<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product_categories;
use App\Models\Product_category_details;
use App\Models\Product_images;
use App\Models\Product_reviews;
use App\Models\Discounts;
use App\Models\Responses;
use Redirect;
use Illuminate\Support\Facades\DB;

class DiscountController extends Controller
{
    
    public function edit($id){
        $where = array('id' => $id);
        $data['discount_info'] = Discounts::where($where)->first();

        return view('pages.admins.product.discountedit',$data);
    }

    public function update(Request $request, $id){
        $update = [
            'percentage' => $request->percentage,
            'start' => $request->start,
            'end' => $request->end,
        ];

        Discounts::where('id',$id)->update($update);
        $categories = DB::table('discounts')
            ->select('id_product')
            ->where('id','=',$id)
            ->first();
        return Redirect::to('/admins/discounts'."{$categories->id_product}");
    }

    public function show($id){
        $where = array('id_product' => $id);
        $discounts['discounts'] = DB::table('discounts')
            ->select('discounts.*')
            ->where('id_product',$where)->first();
        $valid = Discounts::select('id','percentage','start','end')->where('id_product','=',$where)->get();
        $prd = $id;
        return view('pages.admins.product.discountlist',compact('discounts','prd','valid','id'));
    }

    public function delete($id){
        Discounts::where('id',$id)->delete();
        return redirect()->back();
    }
    
}

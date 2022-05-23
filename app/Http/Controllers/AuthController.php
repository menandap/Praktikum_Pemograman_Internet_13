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
use App\Models\Carts;
use App\Models\User;
use App\Models\Admin;
use App\Models\Couriers;
use App\Models\Transactions;
use App\Models\Transaction_details;
use App\Models\User_notifications;
use Redirect;
use Carbon\Carbon;
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
        // $reviews = Product_reviews::where('product_id', '=', $id)->paginate(5);
        // Paginator::useBootstrap();
        return view('homepage', ['product' => $products, 'product_categories' => $categories, 'discount' => $discounts]);
    }

    public function product()
    {
        $categories = Product_categories::with('product')->get();
        $products = Product::with('product_images','product_category_details','product_categories')->get();
        $discounts = DB::table('discounts')
        ->select('discounts.*')
        ->get();
        // $reviews = Product_reviews::where('product_id', '=', $id)->paginate(5);
        // Paginator::useBootstrap();
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
        $reviews = Product_reviews::where('product_id', '=', $id)->paginate(5);
        Paginator::useBootstrap();
        $cek_transaksi = DB::table('transactions')
        ->join('transaction_details', 'transactions.id', '=', 'transaction_details.transaction_id')
        ->select('transaction_details.product_id', 'transactions.user_id','transactions.status')
        ->where('transaction_details.product_id', '=', $id)->where('transactions.user_id', '=', auth()->user()->id)->where('transactions.status', '=', "barang telah sampai di tujuan")->count();
        // return $transaksi;
        $cek_review = Product_reviews::where('user_id', '=', auth()->user()->id)->where('product_id', '=', $id)->count();
        $cek = $cek_transaksi - $cek_review;
        // return $cek_transaksi;
        return view('detail_product', compact('cek','products','reviews','responses', 'image','categories','id','discount','stoks','reviews'));
    }

    public function cart()
    {
        
        $user_id = auth()->user()->id;
        $keranjang = Carts::where('user_id', '=', $user_id)->where('status', '=', 'aktif')->get();

        return view('cart', compact('keranjang'));
    }

    public function cart_add($id, Request $request)
    {
        $user_id = auth()->user()->id;
        $cart = Carts::where('user_id', '=', $user_id)->where('product_id', '=', $id)->where('stok', '=', $request->stok)->where('status', '=', 'aktif')->get();
        if (count($cart) > 0) {
            foreach ($cart as $carts) {
                $carts->qty = $carts->qty + $request->jumlah_keranjang;
                $carts->save();
            }
        } else {
            $insert_cart = array(
                'user_id' => $user_id,
                'product_id' => $id,
                'stok' => $request->stok,
                'qty' => $request->jumlah_keranjang,
                'status' => "aktif"
            );
            Carts::create($insert_cart);
        }
        return redirect()->back();

        // switch ($request->input('action')) {
        //     case 'cart':
        //         return redirect()->back();
    
        //     case 'buy':
        //         return redirect()->route('cart');
        //     }
        // $request->tes;
        // return  $request;

    }

    public function cart_buy($id, Request $request)
    {
        $user_id = auth()->user()->id;
        $cart = Carts::where('user_id', '=', $user_id)->where('product_id', '=', $id)->where('stok', '=', $request->stok)->where('status', '=', 'aktif')->get();
        if (count($cart) > 0) {
            foreach ($cart as $carts) {
                $carts->qty = $carts->qty + $request->jumlah_keranjang;
                $carts->save();
            }
        } else {
            $insert_cart = array(
                'user_id' => $user_id,
                'product_id' => $id,
                'stok' => $request->stok,
                'qty' => $request->jumlah_keranjang,
                'status' => "aktif"
            );
            Carts::create($insert_cart);
        }
        return redirect()->route('cart');
    }

    public function cart_delete($id)
    {
        $keranjang = Carts::find($id);
        $keranjang->delete();

        return redirect()->back();
    }

    public function cart_address(Request $request)
    {
        $user_id = auth()->user()->id;
        $keranjang = Carts::where('user_id', '=', $user_id)->get();
        $kurir = Couriers::all();
        $i = 0;
        foreach ($keranjang as $keranjangs) {
            $keranjangs->qty = $request->jumlah[$i];
            $keranjangs->save();
        }

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.rajaongkir.com/starter/province",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "key: 400f496a78d8de8e403cb03633e42774"
            ),
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        $province = json_decode($response, true);
        // foreach ($province["rajaongkir"]["results"] as $provinces) {
        //     return $provinces["province_id"];
        // }

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.rajaongkir.com/starter/city",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "key: 400f496a78d8de8e403cb03633e42774"
            ),
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        $city = json_decode($response, true);
        return view('cart_address', compact('province', 'city', 'kurir'));
    }

    public function cart_checkout(Request $request)
    {
        $validatedData = $request->validate([
            'province' => 'required|min:1',
            'regency' => 'required|min:1',
            'address' => 'required|min:1',
            'courier_id' => 'required|min:1'
        ]);

        $user_id = auth()->user()->id;
        $keranjang = Carts::where('user_id', '=', $user_id)->where('status', '=', 'aktif')->get();
        $kurir = Couriers::find($request->courier_id);

        list($province, $province_name) = explode('|', $request->province);
        list($regency, $regency_name) = explode('|', $request->regency);
        $address = $request->address;

        $discount =  array();
        $selling_price = array();

        $subtotal = 0;
        $weight = 0;
        $tanggal = Carbon::now()->format('Y-m-d');
        foreach ($keranjang as $keranjangs) {
            $weight = $weight + ($keranjangs->qty * $keranjangs->product->weight * 1000);
            $diskon = Discounts::where('product_id', '=', $keranjangs->product_id)->where('start', '<=', $tanggal)->where('end', '>=', $tanggal)->get();
            if (count($diskon) > 0) {
                $harga = $diskon[0]->percentage * $keranjangs->product->price / 100;
                $subtotal = $subtotal + ($keranjangs->qty * $harga);
                array_push($discount, $diskon[0]->percentage);
                array_push($selling_price, $harga);
            } else {
                $subtotal = $subtotal + ($keranjangs->qty * $keranjangs->product->price);
                array_push($discount, 0);
                array_push($selling_price, $keranjangs->product->price);
            }
        }


        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.rajaongkir.com/starter/cost",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "origin=17&destination=" . $regency . "&weight=" . $weight . "&courier=" . $kurir->courier,
            CURLOPT_HTTPHEADER => array(
                "content-type: application/x-www-form-urlencoded",
                "key: 400f496a78d8de8e403cb03633e42774"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        $cost = json_decode($response, true);

        // return $cost;
        foreach ($cost["rajaongkir"]["results"] as $costs) {
            foreach ($costs["costs"] as $costss) {
                foreach ($costss["cost"] as $costsss) {
                    $shipping_cost = $costsss["value"];
                    break;
                }
                break;
            }
            break;
        }

        $total = $shipping_cost + $subtotal;
        return view('cart-checkout', compact('keranjang', 'kurir', 'subtotal', 'discount', 'selling_price', 'province_name', 'regency_name', 'address', 'shipping_cost', 'total'));
    }

    public function cart_confir(Request $request)
    {
        $user_id = auth()->user()->id;
        $courier = Couriers::where('courier', '=', $request->courier)->first();
        $timeout = Carbon::now();
        $timeout->addDays(1);
        $timeout->format('Y-m-d H:i:s');
        $transaksi = array(
            'user_id' => $user_id,
            'courier_id' => $courier->id,
            'timeout' => $timeout,
            'address' => $request->address,
            'regency' => $request->regency,
            'province' => $request->province,
            'total' => $request->total,
            'shipping_cost' => $request->shipping_cost,
            'subtotal' => $request->subtotal,
            'status' => "menunggu bukti pembayaran",
        );

        Transactions::create($transaksi);

        $transaction = Transactions::where('user_id', '=', $user_id)->where('total', '=', $request->total)->orderBy('id', 'DESC')->first();

        $i = 0;
        foreach ($request->keranjang as $keranjangs) {
            $keranjang = Carts::find($keranjangs);
            $editKeranjang = [
                'status' => "tidak",
            ];
            Carts::where('id',$keranjangs)->update($editKeranjang);
            $transaksi_detail = array(
                'transaction_id' => $transaction->id,
                'product_id' => $keranjang->product_id,
                'stok' => $keranjang->stok,
                'qty' => $keranjang->qty,
                'discount' => $request->discount[$i],
                'selling_price' => $request->selling_price[$i],
            );
            Transaction_details::create($transaksi_detail);
            $i++;
        }

      //----------------------------------------------------------------------------
      $user=auth()->user();
      $data_user=User::find($user->id);
      $admin = Admin::find(1);
      $data = [
          'nama'=> $user->name,
          'message'=>'membeli product!',
          'id'=> $transaction->id,
          'category' => 'transaction'
      ];
      $data_encode = json_encode($data);
      $admin->createNotif($data_encode);
      //Notif Admin-------------------------------------------------------------------
      $data = [
          'nama'=> 'Admin',
          'message'=>'Upload Bukti Pembayaran!',
          'id'=> $transaction->id,
          'category' => 'transcation'
      ];
      $data_encode = json_encode($data);
      $data_user->createNotifUser($data_encode);
      //Notif User-------------------------------------------------------------------
        return redirect()->route('transaksi-detail', $transaction->id);
    }

    public function transaction()
    {
        $user_id = auth()->user()->id;
        $transaction = Transactions::where('user_id', '=', $user_id)->orderBy('id', 'DESC')->get();
        $tanggal = Carbon::now();
        $interval = array();
        foreach ($transaction as $transactions) {
            if ($transactions->status == "menunggu bukti pembayaran" && $transactions->timeout < $tanggal) {
                $transactions->status = "transaksi expired";
                $transactions->save();
            }
            $date = Carbon::createFromFormat('Y-m-d H:s:i', $transactions->timeout);
            $countdown = $tanggal->diffAsCarbonInterval($date);
            array_push($interval, $countdown);
        }

        return view('transaksi', compact('transaction', 'interval'));
    }

    public function transaction_detail($id)
    {
        $transaction = Transactions::find($id);
        $transaction_detail = Transaction_details::where('transaction_id', '=', $id)->get();
        $tanggal = Carbon::now();
        if ($transaction->status == "menunggu bukti pembayaran" && $transaction->timeout < $tanggal) {
            $transaction->status = "transaksi expired";
            $transaction->save();
            return view('transaksi-detail', compact('transaction', 'transaction_detail'));
        } else if ($transaction->status == "menunggu bukti pembayaran" && $transaction->timeout >= $tanggal) {
            $date = Carbon::createFromFormat('Y-m-d H:s:i', $transaction->timeout);
            $interval = $tanggal->diffAsCarbonInterval($date);
            return view('transaksi-detail', compact('transaction', 'interval', 'transaction_detail'));
        } else {
            return view('transaksi-detail', compact('transaction', 'transaction_detail'));
        }
    }

    public function transaction_bukti($id, Request $request)
    {

        $validatedData = $request->validate([
            'proof_of_payment' => 'required|file|image|max:8192'
        ]);
        $transaction = Transactions::find($id);

        $tanggal = Carbon::now();
        if ($transaction->status == "menunggu bukti pembayaran" && $transaction->timeout < $tanggal) {
            $transaction->status = "transaksi expired";
            $transaction->save();
            return redirect()->back();;
        }

        $image = $request->file('proof_of_payment');
        $image_name = rand() . "." . $image->getClientOriginalExtension();

        $transaction->proof_of_payment = $image_name;
        $transaction->status = "menunggu verifikasi";
        $transaction->save();

        $image->move(public_path('proof_of_payment'), $image_name);

         //notif admin---------------------------------------
         $user=auth()->user();
         //$user_data=User::find($user->id);
         $admin = Admin::find(1);
         $data = [
            'nama'=> $user->name,
            'message'=>'Verifikasi Pembayaran!',
            'id'=> $id,
            'category' => 'Transcation'
        ];
        $data_encode = json_encode($data);
        $admin->createNotif($data_encode);
        //notif admin---------------------------------------

        return redirect()->back();
    }

    public function transaction_batal($id)
    {
        $transaction = Transactions::find($id);
        $transaction->status = "transaksi dibatalkan";
        $transaction->save();

         //notif admin---------------------------------------
         $user=auth()->user();
         //$user_data=User::find($user->id);
         $admin = Admin::find(1);
         $data = [
            'nama'=> $user->name,
            'message'=>'Transaksi Dibatalkan!',
            'id'=> $id,
            'category' => 'canceled'
        ];
        $data_encode = json_encode($data);
        $admin->createNotif($data_encode);
        //notif admin---------------------------------------
 
         //notif user---------------------------------------
         $user=auth()->user();
         $user_data = User::find($user->id);
         $admin = Admin::find(1);
         $data = [
            'nama'=> 'Admin',
            'message'=>'Transaksi Berhasil Dibatalkan!',
            'id'=> $id,
            'category' => 'canceled'
        ];
        $data_encode = json_encode($data);
        $user_data->createNotifUser($data_encode);
        //notif user---------------------------------------

        return redirect()->back();
    }

    public function transaction_confir($id)
    {
        $transaction = Transactions::find($id);
        $transaction->status = "barang telah sampai di tujuan";
        $transaction->save();

        //notif admin---------------------------------------
        $user=auth()->user();
        //$user_data=User::find($user->id);
        $admin = Admin::find(1);
        $data = [
           'nama'=> $user->name,
           'message'=>'Barang Telah Sampai ke Pelanggan!',
           'id'=> $id,
           'category' => 'canceled'
       ];
       $data_encode = json_encode($data);
       $admin->createNotif($data_encode);
       //notif admin---------------------------------------

        return redirect()->back();
    }

    public function uploadReview(Request $request, $id){ 
        $detail = array(
            'product_id' => $id,
            'user_id' => $request->user_id,
            'content' => $request->content,
            'rate' => $request->rate
        );
        Product_reviews::create($detail);

        $jumlah_rate = Product_reviews::where('product_id', '=', $id)->get();
        if (count($jumlah_rate) > 0) {
            $jumlah = 0;
            $total = 0;
            foreach ($jumlah_rate as $jumlah_rates) {
                $jumlah++;
                $total = $total + $jumlah_rates->rate;
            }
            $product_rate = $total / $jumlah;

            $product = Product::find($id);
            $product->product_rate = $product_rate;
            $product->save();
        }

        $user = auth()->user();
        $data_user = User::find($user->id);

          //----------------------------------------------------------------------------
          $admin = Admin::find(1);
          $data = [
              'nama'=> $user->name,
              'message'=>'seseorang mereview product!',
              'id'=> $id,
              'category' => 'review'
          ];
          $data_encode = json_encode($data);
          $admin->createNotif($data_encode);


        return redirect()->route('detail_product',  $id); 
    }

    public function user_notif($id) 
    {
        $notification = User_notifications::find($id);
        $notif = json_decode($notification->data);
        
        $date = Carbon::now('Asia/Makassar');
        $baca= User_notifications::find($id);
        $baca->read_at =$date;
        $baca->update();

        if ($notif->category == 'review') {
            return redirect()->route('detail_product',$notif->id);
        } else{
            return redirect()->route('transaksi-detail',$notif->id);
        } 
     
    }

}

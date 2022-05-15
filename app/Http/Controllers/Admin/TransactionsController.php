<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Pagination\Paginator;
use Redirect;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Models\Product_categories;
use App\Models\Product_category_details;
use App\Models\Product_stoks;
use App\Models\Product_stok_details;
use App\Models\Product_images;
use App\Models\Product_reviews;
use App\Models\Product;
use App\Models\Discounts;
use App\Models\Responses;
use App\Models\User;
use App\Models\Admin;
use App\Models\Carts;
use App\Models\Cities;
use App\Models\Couriers;
use App\Models\Provinces;
use App\Models\Transactions;
use App\Models\Product_review;
use App\Models\User_notifications;
use App\Models\Admin_notifications;
use App\Models\Transaction_details;

class TransactionsController extends Controller
{
    public function transaksi()
    {
        $transaction = Transactions::orderBy('id', 'DESC')->paginate(10);
        Paginator::useBootstrap();
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

        return view('pages.admins.transactions.transactionlist', compact('transaction', 'interval'));
    }

    public function transaksi_detail($id)
    {
        $transaction = Transactions::find($id);
        $transaction_detail = Transaction_details::where('transaction_id', '=', $id)->get();
        $tanggal = Carbon::now();
        if ($transaction->status == "menunggu bukti pembayaran" && $transaction->timeout < $tanggal) {
            $transaction->status = "transaksi expired";
            $transaction->save();
            return view('pages.admins.transactions.transactiondetail', compact('transaction', 'transaction_detail'));
        } else if ($transaction->status == "menunggu bukti pembayaran" && $transaction->timeout >= $tanggal) {
            $date = Carbon::createFromFormat('Y-m-d H:s:i', $transaction->timeout);
            $interval = $tanggal->diffAsCarbonInterval($date);
            return view('pages.admins.transactions.transactiondetail', compact('transaction', 'interval', 'transaction_detail'));
        } else {
            return view('pages.admins.transactions.transactiondetail', compact('transaction', 'transaction_detail'));
        }
    }

    public function transaksi_status($id, Request $request)
    {
        $transaction = Transactions::find($id);

        $tanggal = Carbon::now();
        if ($transaction->status == "menunggu bukti pembayaran" && $transaction->timeout < $tanggal) {
            $transaction->status = "transaksi expired";
            $transaction->save();
            return redirect()->back();;
        } else if ($transaction->status == "barang dalam pengiriman" || $transaction->status == "barang telah sampai di tujuan"){
            $detail = Transaction_details::where('transaction_id', '=', $transaction->id)->get();
            foreach($detail as $details){
            $stoks = Product_stok_details::where('id', '=', $details->stok)->first();
            $stok_new = $stoks->stok - $details->qty;
            $editstok = [
                'stok' => $stok_new
            ];
            Product_stok_details::where('id',$details->stok)->update($editstok);
            }
        }

        $transaction->status = $request->status;
        $transaction->save();

        return redirect()->back();
    }

    public function transaksi_bukti($id)
    {
        $transaction = Transactions::find($id);

        return view('pages.admins.transactions.transactionbukti', compact('transaction'));
    }
}

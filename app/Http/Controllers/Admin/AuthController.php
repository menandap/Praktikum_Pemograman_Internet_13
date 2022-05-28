<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use App\Models\User;
use App\Models\Product;
use App\Models\Transactions;
use App\Models\Admin_notifications;
use App\Models\Couriers;
use Carbon\Carbon;


class AuthController extends Controller
{
    public function dashboard()
    {
        $user = User::count();
        if (!$user) {
            $user = 0;
        }
        $product = Product::count();
        if (! $product) {
            $product = 0;
        }
        $transaction = Transactions::count();
        if (!$transaction) {
            $transactiont = 0;
        }
        $courier = Couriers::count();
        if (!$courier) {
            $courier = 0;
        }

        $now = Carbon::now('Asia/Makassar');
        $allTransactions = Transactions::where('status', 'barang telah sampai di tujuan')->get();
        //dd($allTransactions);
        $allSales = Transactions::where('status','barang telah sampai di tujuan')->count();
        $monthlySales = Transactions::where('status','barang telah sampai di tujuan')->whereMonth('created_at', $now->month)->count();
        $annualSales = Transactions::where('status','barang telah sampai di tujuan')->whereYear('created_at', $now->year)->count();
        $monthlyTransactions = Transactions::where('status', 'barang telah sampai di tujuan')->whereMonth('created_at', $now->month)->get();
        $annualTranscations = Transactions::where('status', 'barang telah sampai di tujuan')->whereYear('created_at', $now->year)->get();
        //dd($allTransactions);
        $incomeTotal = 0;
        $incomeMonthly = 0;
        $incomeAnnual = 0;

        foreach ($allTransactions as $transaction) {
            $incomeTotal+=$transaction->total;
        }

        
        foreach ($monthlyTransactions as $monthly) {
            $incomeMonthly+=$monthly->total;
        }

        foreach ($annualTranscations as $annual) {
            $incomeAnnual+=$annual->total;
        }

        
        $january = Transactions::where('status', 'barang telah sampai di tujuan')->whereMonth('created_at', '01')->count();
        $february = Transactions::where('status', 'barang telah sampai di tujuan')->whereMonth('created_at', '02')->count();
        $march = Transactions::where('status', 'barang telah sampai di tujuan')->whereMonth('created_at', '03')->count();
        $april = Transactions::where('status', 'barang telah sampai di tujuan')->whereMonth('created_at', '04')->count();
        $may = Transactions::where('status', 'barang telah sampai di tujuan')->whereMonth('created_at', '05')->count();
        $june = Transactions::where('status', 'barang telah sampai di tujuan')->whereMonth('created_at', '06')->count();
        $july = Transactions::where('status', 'barang telah sampai di tujuan')->whereMonth('created_at', '07')->count();
        $august = Transactions::where('status', 'barang telah sampai di tujuan')->whereMonth('created_at', '08')->count();
        $september = Transactions::where('status', 'barang telah sampai di tujuan')->whereMonth('created_at', '09')->count();
        $october = Transactions::where('status', 'barang telah sampai di tujuan')->whereMonth('created_at', '10')->count();
        $november = Transactions::where('status', 'barang telah sampai di tujuan')->whereMonth('created_at', '11')->count();
        $december = Transactions::where('status', 'barang telah sampai di tujuan')->whereMonth('created_at', '12')->count();

        $b_january = Transactions::where('status', 'transaksi dibatalkan')->whereMonth('created_at', '01')->count();
        $b_february = Transactions::where('status', 'transaksi dibatalkan')->whereMonth('created_at', '02')->count();
        $b_march = Transactions::where('status', 'transaksi dibatalkan')->whereMonth('created_at', '03')->count();
        $b_april = Transactions::where('status', 'transaksi dibatalkan')->whereMonth('created_at', '04')->count();
        $b_may = Transactions::where('status', 'transaksi dibatalkan')->whereMonth('created_at', '05')->count();
        $b_june = Transactions::where('status', 'transaksi dibatalkan')->whereMonth('created_at', '06')->count();
        $b_july = Transactions::where('status', 'transaksi dibatalkan')->whereMonth('created_at', '07')->count();
        $b_august = Transactions::where('status', 'transaksi dibatalkan')->whereMonth('created_at', '08')->count();
        $b_september = Transactions::where('status', 'transaksi dibatalkan')->whereMonth('created_at', '09')->count();
        $b_october = Transactions::where('status', 'transaksi dibatalkan')->whereMonth('created_at', '10')->count();
        $b_november = Transactions::where('status', 'transaksi dibatalkan')->whereMonth('created_at', '11')->count();
        $b_december = Transactions::where('status', 'transaksi dibatalkan')->whereMonth('created_at', '12')->count();

        return view('pages.admins.dashboard.index', compact(
            'user','product','transaction','courier',
            'now', 'allSales', 'monthlySales', 'annualSales', 'incomeTotal', 'incomeMonthly', 'incomeAnnual', 
            'january', 'february', 'march', 'april', 'may', 'june', 'july', 'august', 'september', 'october', 'november', 'december',
            'b_january', 'b_february', 'b_march', 'b_april', 'b_may', 'b_june', 'b_july', 'b_august', 'b_september', 'b_october', 'b_november', 'b_december'
        ));
    }
    
    public function home()
    {
        return view('pages.admins.dashboard.index');
    }
    
    public function store(Request $requests)
    {
        if(!Auth::guard('admin')->attempt($requests->only('username','password'), $requests->filled('remember'))){
            throw ValidationException::withMessages([
                'username' => 'invalid username or password'
            ]);
        }

        return redirect()->route('admin.dashboard');
    }

    public function dummy()
    {
        return redirect()->route('admin.dummy');
    }

    public function destroy()
    {
        Auth::guard('admin')->logout();

        return redirect()->route('admin.dashboard');
    }

    public function admin_notif($id) 
    {
        $notification = Admin_notifications::find($id);
        $notif = json_decode($notification->data);
        $date = Carbon::now('Asia/Makassar');
        $baca = Admin_notifications::find($id);
        $baca->read_at = $date;
        $baca->update();

        if ($notif->category == 'review' ) {
            return redirect()->route('admin.productdetail',$notif->id);
        } else{
            return redirect()->route('admin.adm-transaksi-detail',$notif->id);
        } 
        
    }
}

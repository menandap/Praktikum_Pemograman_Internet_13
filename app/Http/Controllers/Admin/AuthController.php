<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use App\Models\User;
use App\Models\Product;
use App\Models\Transactions;
use App\Models\Couriers;

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
        return view('pages.admins.dashboard.index', compact(
            'user',
            'product',
            'transaction',
            'courier'
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
}

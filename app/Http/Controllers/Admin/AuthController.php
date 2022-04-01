<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function index()
    {
        view('admin.home');
    }
    
    public function store(Request $requests)
    {
        if(!Auth::guard('admin')->attempt($requests->only('username','password'), $requests->filled('remember'))){
            throw ValidationException::withMessages([
                'username' => 'invalid username or password'
            ]);
        }

        return redirect()->route('admin.home');
    }

    public function destroy()
    {
        Auth::guard('admin')->logout();

        return redirect()->route('admin.login');
    }
}

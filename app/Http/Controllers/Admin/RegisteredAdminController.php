<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;

class RegisteredAdminController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|string|min:8|unique:admins|regex:/^\S*$/u',
            'name' => 'required|string|max:255',
            'password' => 'required|string|confirmed|min:8',
            'phone' => 'required|string|max:15',
            'profile_image' => 'required|mimes:jpg,png,jpeg,gif,svg|max:2048',
        ]);

        $name = $request->file('profile_image')->getClientOriginalName();
 
        $path = $request->file('profile_image')->store('public/images/admin-profile');


        Auth::login($admin = Admin::create([
            'username' => $request->username,
            'name' => $request->name,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'profile_image' => $path,
        ]));

        return redirect()->route('admin.home');
    }
}

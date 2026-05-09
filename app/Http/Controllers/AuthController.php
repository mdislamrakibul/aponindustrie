<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;



class AuthController extends Controller
{
    // 1. Login page show
    public function showLogin()
    {
        return view('auth.login');
    }

// 2. Login process
    public function login(Request $request)
    {
        // Validation
        $request->validate([
            'mobile_no' => 'required|digits:11',
            'password' => 'required|min:6'
        ]);

        // Login attempt
        if (Auth::attempt([
            'mobile_no' => $request->mobile_no,
            'password' => $request->password
        ])) {
            return redirect('/')->with('success', 'Login Successful');
        }

        return back()->withErrors([
            'mobile_no' => 'Invalid mobile number or password'
        ]);

        
    }

    

        // Register page show
    public function showRegister()
    {
        return view('auth.register');
    }



    // Register process
    public function register(Request $request)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'mobile_no' => 'required|digits:11',
            'password' => 'required|min:6'
        ]);

        User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'mobile_no' => $request->mobile_no,
            'password' => Hash::make($request->password)
        ]);

        return redirect('/login')->with('success', 'Account created successfully');
        }

        //admin
    
    public function showAdminLogin()
    {
        return view('admin.auth.login');
    }
    public function adminLogin(Request $request)
    {
        $request->validate([
            'mobile_no' => 'required|digits:11',
            'password' => 'required'
        ]);

        if(Auth::attempt([
            'mobile_no' => $request->mobile_no,
            'password' => $request->password,
            'role' => 'admin'
        ]))
        {
        return redirect('/admin/dashboard');
        }

        return back()->withErrors([
        'mobile_no' => 'Invalid admin credentials'
        ]);
    }
}


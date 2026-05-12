<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
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
        $request->validate([
            'mobile_no' => [
                'required',
                'regex:/^(01)[3-9]\d{8}$/'
            ],
            'password' => 'required|min:6'
        ]);

        $user = User::where('mobile_no', $request->mobile_no)
            ->first();
        

        if ($user && Hash::check($request->password, $user->password)) {

            session([
                'user_id' => $user->id,
                'user_name' => $user->first_name . ' ' . $user->last_name,
                'user_mobile' => $user->mobile_no,
                'user_role' => $user->role,
            ]);

            $request->session()->regenerate();

            return redirect('/')
                ->with('success', 'Login Successful');
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
            'mobile_no' => 'required',
            'password' => 'required',
        ]);

        $mobile = $this->normalizeBdNumber($request->mobile_no);

        $user = User::where('mobile_no', $mobile)->first();

        if (!$user) {
            return back()->with('error', 'Invalid credentials');
        }

        if (!Hash::check($request->password, $user->password)) {
            return back()->with('error', 'Invalid credentials');
        }

        // ONLY ADMIN + VENDOR ALLOWED
        if (!in_array($user->role, ['admin', 'vendor'])) {
            return back()->with('error', 'Unauthorized access');
        }

        session([
            'user_id' => $user->id,
            'user_name' => $user->first_name,
            'user_mobile' => $user->mobile_no,
            'user_role' => $user->role,
        ]);

        return redirect('/admin/dashboard');
    }
    private function normalizeBdNumber($number)
    {
        // Remove spaces and special characters
        $number = preg_replace('/[^0-9]/', '', $number);

        // Convert 8801XXXXXXXXX -> 01XXXXXXXXX
        if (str_starts_with($number, '880')) {
            $number = '0' . substr($number, 3);
        }

        // Convert +8801XXXXXXXXX -> 01XXXXXXXXX
        if (str_starts_with($number, '+880')) {
            $number = '0' . substr($number, 4);
        }

        return $number;
    }

    //logout//
    public function logout(Request $request)

    {
        session()->forget([
            'user_id',
            'user_name',
            'user_mobile',
            'user_role'
        ]);

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')
            ->with('success', 'Logged out successfully');
    }
}


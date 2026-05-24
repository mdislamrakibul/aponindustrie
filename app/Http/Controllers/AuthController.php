<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Login;


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

        $user = Login::where('phone', $request->mobile_no)->first();


        if ($user && Hash::check($request->password, $user->password)) {
            // CHECK ACCOUNT STATUS
            if ($user->status !== 'ACTIVE') {
                return back()->withErrors([
                    'mobile_no' => 'Account is inactive or blocked'
                ]);
            }

            // UPDATE LAST LOGIN
            $user->last_login_at = now();
            $user->save();
            session([
                'user_id' => $user->id,
                'user_name' => $user->name,
                'user_mobile' => $user->phone,
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

            'first_name' => 'required|string|max:255',

            'last_name' => 'required|string|max:255',

            'mobile_no' => [
                'required',
                'regex:/^(01)[3-9]\d{8}$/',
                'unique:tbl_info_login,phone'
            ],

            'password' => 'required|min:6'
        ]);

        Login::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'phone' => $request->mobile_no,
            'password' => Hash::make($request->password),
            'role' => 'USER',
            'status' => 'ACTIVE'
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
        if (!in_array($user->role, ['ADMIN', 'VENDOR'])) {
            return back()->with('error', 'Unauthorized access');
        }


        // Update session
        session([
            'user_id' => $user->id,
            'user_name' => trim($user->first_name . ' ' . $user->last_name),
            'user_mobile' => $user->mobile_no,
            'user_role' => strtolower($user->role),
        ]);

        // Security
        $request->session()->regenerate();

        return redirect('/admin/dashboard')
            ->with('success', 'Admin login successful');
    }
    private function normalizeBdNumber($number)
    {
        $number = preg_replace('/[^0-9]/', '', $number);

        if (str_starts_with($number, '880')) {
            $number = '0' . substr($number, 3);
        }

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

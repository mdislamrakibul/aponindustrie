<?php

namespace App\Http\Controllers;

use App\Models\Login;
use App\Models\Order;
use App\Models\User;

class CustomerProfileController extends Controller
{
    /**
     * session('user_id') is now always tbl_info_user.id (fixed in AuthController@login).
     * Resolve the Login record via the login_id column stored in tbl_info_user.
     */
    private function resolveLogin(): ?Login
    {
        $sid = session('user_id');
        if (!$sid) {
            return null;
        }

        // Primary: look up the User record, then follow login_id to tbl_info_login
        $userRecord = User::find($sid);
        if ($userRecord && $userRecord->login_id) {
            $login = Login::find($userRecord->login_id);
            if ($login) {
                return $login;
            }
        }

        // Fallback: match by mobile number in case login_id is not set
        $mobile = session('user_mobile');
        if ($mobile) {
            return Login::where('phone', $mobile)->first();
        }

        return null;
    }

    public function index()
    {
        $login = $this->resolveLogin();

        if (!$login) {
            return redirect()->route('login')->with('error', 'Please log in to view your account.');
        }

        // session('user_id') = tbl_info_user.id (current); old orders may still
        // carry the former tbl_info_login.id — include both to cover migrated data.
        $sid     = session('user_id');
        $loginId = $login->id;

        $orders = Order::with(['order_items.product', 'order_address'])
            ->where(function ($q) use ($sid, $loginId) {
                $q->where('user_id', $sid)
                  ->orWhere('user_id', $loginId);
            })
            ->latest()
            ->get();

        return view('profile.my_account', compact('login', 'orders'));
    }

    public function orderSummary(int $id)
    {
        $login = $this->resolveLogin();

        if (!$login) {
            return response()->json(['success' => false, 'message' => 'Unauthenticated'], 401);
        }

        $sid     = session('user_id');
        $loginId = $login->id;

        $order = Order::with(['order_items.product', 'order_address'])
            ->where('id', $id)
            ->where(function ($q) use ($sid, $loginId) {
                $q->where('user_id', $sid)
                  ->orWhere('user_id', $loginId);
            })
            ->first();

        if (!$order) {
            return response()->json(['success' => false, 'message' => 'Order not found'], 404);
        }

        return response()->json(['success' => true, 'order' => $order]);
    }
}

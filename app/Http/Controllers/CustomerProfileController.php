<?php

namespace App\Http\Controllers;

use App\Models\Login;
use App\Models\Order;

class CustomerProfileController extends Controller
{
    /**
     * Resolve the Login record for the current session regardless of login flow:
     *   Customer (/login)       → session('user_id') = tbl_info_login.id → Login::find()
     *   Admin (/admin/login)    → session('user_id') = tbl_info_user.id  → Login::where('user_id')
     */
    private function resolveLogin(): ?Login
    {
        $sid = session('user_id');
        if (!$sid) {
            return null;
        }

        return Login::find($sid)                           // customer: session = login id
            ?? Login::where('user_id', $sid)->first();     // admin: session = user id
    }

    public function index()
    {
        $login = $this->resolveLogin();

        if (!$login) {
            return redirect()->route('login')->with('error', 'Please log in to view your account.');
        }

        // Orders may be stored under either the login id (customers) or the
        // user id (admins), so we check both to cover both login flows.
        $sid = session('user_id');
        $orders = Order::with(['order_items.product', 'order_address'])
            ->where(function ($q) use ($login, $sid) {
                $q->where('user_id', $login->id)
                  ->orWhere('user_id', $sid);
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

        $sid   = session('user_id');
        $order = Order::with(['order_items.product', 'order_address'])
            ->where('id', $id)
            ->where(function ($q) use ($login, $sid) {
                $q->where('user_id', $login->id)
                  ->orWhere('user_id', $sid);
            })
            ->first();

        if (!$order) {
            return response()->json(['success' => false, 'message' => 'Order not found'], 404);
        }

        return response()->json(['success' => true, 'order' => $order]);
    }
}

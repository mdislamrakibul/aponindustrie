<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | CUSTOMER LIST (Registered + Guest)
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $customers = DB::table('tbl_info_user')
            ->where('role', 'customer')
            ->select(
                'id',
                'first_name',
                'last_name',
                'phone',
                'mobile_no',
                'created_at',
                'customer_type',
                DB::raw('CASE WHEN password IS NULL THEN 1 ELSE 0 END as is_guest'),
                DB::raw('(SELECT toa.email FROM tbl_order_addresses toa
                    JOIN tbl_orders tor ON toa.order_id = tor.id
                    WHERE tor.user_id = tbl_info_user.id
                    LIMIT 1) as email')
            )
            ->latest()
            ->get();

        return view('admin.customers.index', compact('customers'));
    }

    /*
    |--------------------------------------------------------------------------
    | ORDER HISTORY (works for both registered & guest)
    |--------------------------------------------------------------------------
    */

    public function orderHistory($id)
    {
        $customer = DB::table('tbl_info_user')
            ->where('id', $id)
            ->select(
                'id', 'first_name', 'last_name', 'phone', 'mobile_no',
                'created_at', 'customer_type',
                DB::raw('CASE WHEN password IS NULL THEN 1 ELSE 0 END as is_guest')
            )
            ->first();

        $orders = DB::table('tbl_orders')
            ->where('user_id', $id)
            ->latest()
            ->get();

        // For guest customers, try to get contact from order address
        $contactInfo = null;
        if ($customer && $customer->is_guest) {
            $contactInfo = DB::table('tbl_order_addresses')
                ->join('tbl_orders', 'tbl_order_addresses.order_id', '=', 'tbl_orders.id')
                ->where('tbl_orders.user_id', $id)
                ->select('tbl_order_addresses.email', 'tbl_order_addresses.phone', 'tbl_order_addresses.address_line1')
                ->first();
        }

        return response()->json([
            'customer'    => $customer,
            'orders'      => $orders,
            'contactInfo' => $contactInfo,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | TOP CUSTOMERS — Real spending + filter support
    |--------------------------------------------------------------------------
    */

    public function topCustomers(Request $request)
    {
        // Default sort: total_spending DESC
        // ?filter=orders  → sort by total_orders DESC
        // ?filter=spending → sort by total_spending DESC (default)
        $filter = $request->get('filter', 'spending');

        try {
            $query = DB::table('tbl_info_user')
                ->leftJoin('tbl_orders', 'tbl_info_user.id', '=', 'tbl_orders.user_id')
                ->select(
                    'tbl_info_user.id',
                    'tbl_info_user.first_name',
                    'tbl_info_user.last_name',
                    'tbl_info_user.phone',
                    'tbl_info_user.mobile_no',
                    'tbl_info_user.created_at',
                    'tbl_info_user.customer_type',
                    DB::raw('CASE WHEN tbl_info_user.password IS NULL THEN 1 ELSE 0 END as is_guest'),
                    DB::raw('COUNT(tbl_orders.id) as total_orders'),
                    DB::raw('COALESCE(SUM(tbl_orders.total_amount), 0) as total_spending'),
                    DB::raw('(SELECT toa.email FROM tbl_order_addresses toa
                        JOIN tbl_orders tor ON toa.order_id = tor.id
                        WHERE tor.user_id = tbl_info_user.id
                        LIMIT 1) as email')
                    )
                ->where('tbl_info_user.role', 'customer')
                ->groupBy(
                    'tbl_info_user.id',
                    'tbl_info_user.first_name',
                    'tbl_info_user.last_name',
                    'tbl_info_user.phone',
                    'tbl_info_user.mobile_no',
                    'tbl_info_user.created_at',
                    'tbl_info_user.customer_type',
                    'tbl_info_user.password'
                );

            if ($filter === 'orders') {
                $query->orderByDesc('total_orders');
            } else {
                $query->orderByDesc('total_spending');
            }

            $topCustomers = $query->get();

        } catch (\Exception $e) {
            $topCustomers = collect([]);
        }

        return view('admin.customers.top-customers', compact('topCustomers', 'filter'));
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE CUSTOMER TYPE
    |--------------------------------------------------------------------------
    */

    public function updateCustomerType(Request $request, $id)
    {
        DB::table('tbl_info_user')
            ->where('id', $id)
            ->update([
                'customer_type' => $request->customer_type,
                'updated_at'    => now(),
            ]);

        return redirect()->back()->with('success', 'Customer type updated successfully');
    }
}
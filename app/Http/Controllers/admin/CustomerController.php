<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | CUSTOMER LIST
    |--------------------------------------------------------------------------
    */

    public function index()
    {

        $customers = DB::table('tbl_info_user')
            ->where('role', 'customer')
            ->latest()
            ->get();

        return view(
            'admin.customers.index',
            compact('customers')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | ORDER HISTORY
    |--------------------------------------------------------------------------
    */

    public function orderHistory($id)
    {

        $customer = DB::table('tbl_info_user')
            ->where('id', $id)
            ->first();

        $orders = DB::table('tbl_orders')
            ->where('user_id', $id)
            ->latest()
            ->get();

        return response()->json([
            'customer' => $customer,
            'orders' => $orders,
        ]);
    }
    /*
|--------------------------------------------------------------------------
| TOP CUSTOMERS
|--------------------------------------------------------------------------
*/

    public function topCustomers()
    {
        /*
        |--------------------------------------------------------------------------
        | TOP CUSTOMERS
        |--------------------------------------------------------------------------
        | Future Ready Query
        | If order table columns are missing,
        | UI will still work safely.
        */

        try {

            $topCustomers = DB::table('tbl_info_user')
                ->leftJoin(
                    'tbl_orders',
                    'tbl_info_user.id',
                    '=',
                    'tbl_orders.user_id'
                )

                ->select(
                    'tbl_info_user.id',
                    'tbl_info_user.first_name',
                    'tbl_info_user.last_name',
                    'tbl_info_user.phone',
                    'tbl_info_user.created_at',
                    'tbl_info_user.customer_type',

                    DB::raw('COUNT(tbl_orders.id) as total_orders'),

                    // SAFE TEMPORARY VALUE
                    DB::raw('0 as total_spending')
                )

                ->where('tbl_info_user.role', 'customer')

                ->groupBy(
                    'tbl_info_user.id',
                    'tbl_info_user.first_name',
                    'tbl_info_user.last_name',
                    'tbl_info_user.phone',
                    'tbl_info_user.created_at',
                    'tbl_info_user.customer_type'
                )

                ->orderByDesc('total_orders')

                ->get();
        } catch (\Exception $e) {

            /*
            |--------------------------------------------------------------------------
            | FALLBACK DATA
            |--------------------------------------------------------------------------
            */

            $topCustomers = collect([]);
        }

        return view(
            'admin.customers.top-customers',
            compact('topCustomers')
        );
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
                'updated_at' => now(),
            ]);

        return redirect()
            ->back()
            ->with('success', 'Customer type updated successfully');
    }
}

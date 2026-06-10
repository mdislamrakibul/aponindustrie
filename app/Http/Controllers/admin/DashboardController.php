<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{

    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        /*
        |--------------------------------------------------------------------------
        | USER SUMMARY
        |--------------------------------------------------------------------------
        */

        $totalUsers = DB::table('tbl_info_user')->count();

        $activeUsers = DB::table('tbl_info_user')
            ->where('status', 'active')
            ->count();

        $inactiveUsers = DB::table('tbl_info_user')
            ->where('status', '!=', 'active')
            ->count();

        $customerUsers = DB::table('tbl_info_user')
            ->where('role', 'customer')
            ->count();

        // TOTAL PRODUCTS
        $totalProducts = DB::table('tbl_products')->count();

        // PRODUCT STATUS COUNTS
        $inStockProducts = DB::table('tbl_products')
            ->where('stock_quantity', '>=', 100)
            ->count();

        $lowStockProducts = DB::table('tbl_products')
            ->whereBetween('stock_quantity', [1, 99])
            ->count();

        $outOfStockProducts = DB::table('tbl_products')
            ->where('stock_quantity', 0)
            ->count();

        // QUANTITY SUMMARY
        $totalStockQuantity = DB::table('tbl_products')
            ->sum('stock_quantity');

        $inStockQuantity = DB::table('tbl_products')
            ->where('stock_quantity', '>=', 100)
            ->sum('stock_quantity');

        $lowStockQuantity = DB::table('tbl_products')
            ->whereBetween('stock_quantity', [1, 99])
            ->sum('stock_quantity');

        return view(
            'admin.dashboard',

            compact(

                // USER
                'totalUsers',
                'activeUsers',
                'inactiveUsers',
                'customerUsers',

                // PRODUCT
                'totalProducts',
                'inStockProducts',
                'lowStockProducts',
                'outOfStockProducts',

                // QUANTITY
                'totalStockQuantity',
                'inStockQuantity',
                'lowStockQuantity'
            )
        );
    }
}

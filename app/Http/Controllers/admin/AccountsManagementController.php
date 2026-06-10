<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItems;
use App\Models\Product;
use Illuminate\Http\Request;

class AccountsManagementController extends Controller
{
    public function orderHistory(Request $request)
    {
        $filterType = $request->filter_type ?? 'all';
        $year       = $request->year  ?? now()->year;
        $month      = $request->month ?? now()->month;
        $date       = $request->date  ?? now()->toDateString();
        $productId  = $request->product_id;

        // ── Base query builder (reusable) ──
        $baseQuery = function () use ($filterType, $year, $month, $date, $productId) {

            $q = Order::query();

            if ($filterType === 'day') {
                $q->whereDate('created_at', $date);
            } elseif ($filterType === 'month') {
                $q->whereYear('created_at', $year)
                  ->whereMonth('created_at', $month);
            } elseif ($filterType === 'year') {
                $q->whereYear('created_at', $year);
            }

            if ($productId) {
                $q->whereHas('order_items', fn($qi) =>
                    $qi->where('product_id', $productId)
                );
            }

            return $q;
        };

        // ── Paginated table data ──
        $orders = $baseQuery()
            ->with(['order_items.product', 'order_address'])
            ->latest()
            ->paginate(20);

        // ── Total Sale (delivered orders total_amount) ──
        $totalSale = (clone $baseQuery())
            ->where('order_status', 'DELIVERED')
            ->sum('total_amount');

        // ── Cancelled orders ──
        $cancelledOrders = (clone $baseQuery())
            ->where('order_status', 'CANCELLED')
            ->get(['id', 'shipping_amount']);

        $cancelledCount  = $cancelledOrders->count();

        // ── Loss = sum of shipping_amount of cancelled orders ──
        $loss = $cancelledOrders->sum('shipping_amount');

        // ── Profit = (item.price - product.purchase_price) × quantity
        //            for DELIVERED orders only ──
        $deliveredOrderIds = (clone $baseQuery())
            ->where('order_status', 'DELIVERED')
            ->pluck('id');

        $profitItems = OrderItems::with('product')
            ->whereIn('order_id', $deliveredOrderIds)
            ->get();

        $profit = $profitItems->sum(function ($item) {
            $purchasePrice = $item->product->purchase_price ?? 0;
            $salePrice     = $item->price; // price at time of order
            return ($salePrice - $purchasePrice) * $item->quantity;
        });

        // ── Other stats ──
        $totalOrders    = (clone $baseQuery())->count();
        $deliveredCount = $deliveredOrderIds->count();

        // ── Dropdowns ──
        $products = Product::orderBy('name')->get(['id', 'name']);

        $years = Order::selectRaw('YEAR(created_at) as year')
            ->groupBy('year')
            ->orderByDesc('year')
            ->pluck('year');

        return view('admin.accounts.order_history', compact(
            'orders',
            'totalSale',
            'cancelledCount',
            'loss',
            'profit',
            'totalOrders',
            'deliveredCount',
            'products',
            'years',
            'filterType',
            'year',
            'month',
            'date',
            'productId'
        ));
    }
}
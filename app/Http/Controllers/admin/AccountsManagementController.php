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

        // ── Profit per order — delivered only ──
        // Formula: package_price × packages − discount − purchase_price × packages
        // packages = quantity ÷ minimum_order  (all prices are per-package)
        $deliveredOrderIds = (clone $baseQuery())
            ->where('order_status', 'DELIVERED')
            ->pluck('id');

        $profitByOrder = OrderItems::with('product')
            ->whereIn('order_id', $deliveredOrderIds)
            ->get()
            ->groupBy('order_id')
            ->map(function ($items) {
                return $items->sum(function ($item) {
                    $prod = $item->product;
                    if (!$prod) { return 0; }   // deleted product → no contribution

                    $packagePrice  = (float) ($prod->package_price  ?? 0);
                    $purchasePrice = (float) ($prod->purchase_price ?? 0);
                    $minOrder      = max(1, (int) ($prod->minimum_order ?? 1));
                    $packages      = $item->quantity / $minOrder;

                    $revenue     = $packagePrice * $packages;
                    $discountAmt = 0;
                    if ($prod->is_discounted) {
                        $dValue = (float) ($prod->discount_value ?? 0);
                        if ($prod->discount_type === 'PERCENTAGE') {
                            $discountAmt = $revenue * ($dValue / 100);
                        } elseif ($prod->discount_type === 'FLAT') {
                            $discountAmt = $dValue * $packages;
                        }
                    }
                    return $revenue - $discountAmt - ($purchasePrice * $packages);
                });
            });

        $totalProfit = $profitByOrder->sum();

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
            'profitByOrder',
            'totalProfit',
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
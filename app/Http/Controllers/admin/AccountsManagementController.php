<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItems;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class AccountsManagementController extends Controller
{
    /**
     * Profit per order for a set of DELIVERED order ids.
     * Formula: revenue actually charged − purchase_price × packages.
     *
     * Revenue comes from the order_item's own snapshotted `price`/`total`
     * (what the customer was actually charged), NOT the product's current
     * live package_price — otherwise editing a price today would silently
     * change the reported profit of past, already-completed orders.
     *
     * No discount is subtracted here: neither the checkout flow
     * (CartController/CheckoutController) nor the admin manual-order flow
     * (AdminOrderController::storeManual) ever deducts discount_value from
     * what's charged — product discounts are storefront-badge-only. So
     * subtracting one here would understate profit for a discount that was
     * never actually given away.
     *
     * Caveat: purchase_price (cost) has no per-order snapshot in the schema,
     * so it's read from the product's current record — if the cost price is
     * edited after the sale, that changes reported profit for past orders
     * too. Fixing that would need a new column + changes to both
     * order-creation flows.
     *
     * Kept in one place so orderHistory() and salesReport() can't drift apart.
     */
    private function profitByOrder($orderIds)
    {
        return OrderItems::with('product')
            ->whereIn('order_id', $orderIds)
            ->get()
            ->groupBy('order_id')
            ->map(function ($items) {
                return $items->sum(function ($item) {
                    $revenue = (float) $item->total;
                    $price   = (float) $item->price;
                    $packages = $price > 0 ? $revenue / $price : 0;

                    $prod = $item->product;
                    $purchasePrice = $prod ? (float) ($prod->purchase_price ?? 0) : 0;

                    return $revenue - ($purchasePrice * $packages);
                });
            });
    }

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
        $deliveredOrderIds = (clone $baseQuery())
            ->where('order_status', 'DELIVERED')
            ->pluck('id');

        $profitByOrder = $this->profitByOrder($deliveredOrderIds);

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

    /**
     * Sales report data for a period (daily/weekly/monthly/yearly), used by
     * the "Download Report" button on the Order History page. Returns JSON;
     * the report itself is built client-side and downloaded via html2pdf.js,
     * same as the existing invoice download.
     */
    public function salesReport(Request $request)
    {
        $period  = $request->get('period', 'daily');
        $refDate = $request->filled('ref_date')
            ? Carbon::parse($request->get('ref_date'))
            : now();

        switch ($period) {
            case 'weekly':
                $start = $refDate->copy()->startOfWeek();
                $end   = $refDate->copy()->endOfWeek();
                $rangeLabel = $start->format('d M Y') . ' – ' . $end->format('d M Y');
                break;
            case 'monthly':
                $start = $refDate->copy()->startOfMonth();
                $end   = $refDate->copy()->endOfMonth();
                $rangeLabel = $start->format('F Y');
                break;
            case 'yearly':
                $start = $refDate->copy()->startOfYear();
                $end   = $refDate->copy()->endOfYear();
                $rangeLabel = $start->format('Y');
                break;
            default: // daily
                $period = 'daily';
                $start = $refDate->copy()->startOfDay();
                $end   = $refDate->copy()->endOfDay();
                $rangeLabel = $start->format('d M Y');
        }

        $delivered = Order::with(['order_items.product'])
            ->whereBetween('created_at', [$start, $end])
            ->where('order_status', 'DELIVERED')
            ->get();

        $cancelled = Order::whereBetween('created_at', [$start, $end])
            ->where('order_status', 'CANCELLED')
            ->get(['id', 'shipping_amount']);

        $profitByOrder = $this->profitByOrder($delivered->pluck('id'));

        // Group rows: daily → each order; weekly → by day; monthly → by
        // week-of-month; yearly → by month. Keeps every report short enough
        // to stay compact regardless of period.
        $rows = collect();

        if ($period === 'daily') {
            foreach ($delivered as $order) {
                $rows->push([
                    'label'  => $order->order_number,
                    'orders' => 1,
                    'sales'  => (float) $order->total_amount,
                    'profit' => (float) $profitByOrder->get($order->id, 0),
                ]);
            }
        } else {
            $groups = $delivered->groupBy(function ($order) use ($period) {
                if ($period === 'weekly') return $order->created_at->format('Y-m-d');
                if ($period === 'monthly') return $order->created_at->copy()->startOfWeek()->format('Y-m-d');
                return $order->created_at->format('Y-m'); // yearly
            });

            foreach ($groups as $key => $group) {
                $label = match ($period) {
                    'weekly'  => Carbon::parse($key)->format('D, d M'),
                    'monthly' => 'Week of ' . Carbon::parse($key)->format('d M'),
                    'yearly'  => Carbon::parse($key . '-01')->format('F'),
                };
                $rows->push([
                    'label'  => $label,
                    'orders' => $group->count(),
                    'sales'  => (float) $group->sum('total_amount'),
                    'profit' => (float) $group->sum(fn($o) => $profitByOrder->get($o->id, 0)),
                ]);
            }
        }

        return response()->json([
            'success'     => true,
            'period'      => $period,
            'range_label' => $rangeLabel,
            'rows'        => $rows->values(),
            'totals'      => [
                'orders'    => $delivered->count(),
                'sales'     => (float) $delivered->sum('total_amount'),
                'profit'    => (float) $profitByOrder->sum(),
                'cancelled' => $cancelled->count(),
                'loss'      => (float) $cancelled->sum('shipping_amount'),
            ],
        ]);
    }
}
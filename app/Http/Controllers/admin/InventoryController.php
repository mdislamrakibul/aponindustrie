<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use App\Models\ActivityLog;

class InventoryController extends Controller
{
    public function inventoryList(Request $request)
    {
        $search = $request->search;

        $products = Product::with('category')
            ->when($search, function ($query) use ($search) {

                $query->where('id', $search)
                    ->orWhere('name', 'LIKE', "%{$search}%")
                    ->orWhereHas('category', function ($q) use ($search) {
                        $q->where('name', 'LIKE', "%{$search}%");
                    });
            })
            ->get()->all();

        // Dashboard Statistics
        $totalProducts = Product::count();

        $inStockProducts = Product::where('stock_quantity', '>=', 100)
            ->count();

        $lowStockProducts = Product::whereBetween('stock_quantity', [1, 99])
            ->count();

        $outOfStockProducts = Product::where('stock_quantity', 0)
            ->count();

        $totalProducts = DB::table('tbl_products')->count();

        /*
        |--------------------------------------------------------------------------
        | QUANTITY BASED COUNTS
        |--------------------------------------------------------------------------
        */

        $totalStockQuantity = DB::table('tbl_products')
            ->sum('stock_quantity');

        $inStockQuantity = DB::table('tbl_products')
            ->where('stock_quantity', '>=', 100)
            ->sum('stock_quantity');

        $lowStockQuantity = DB::table('tbl_products')
            ->whereBetween('stock_quantity', [1, 99])
            ->sum('stock_quantity');

        $outOfStockQuantity = DB::table('tbl_products')
            ->where('stock_quantity', 0)
            ->sum('stock_quantity');

        return view(
            'admin.inventory.inventory-list',
            compact(
                'products',
                'totalProducts',
                'inStockProducts',
                'lowStockProducts',
                'outOfStockProducts',

                'totalStockQuantity',
                'inStockQuantity',
                'lowStockQuantity',
                'outOfStockQuantity'
            )
        );
    }

    public function inventoryUpdate(Request $request)
    {
        $request->validate([
            'product_id'     => 'required|exists:tbl_products,id',
            'stock_quantity' => 'nullable|numeric|min:0', // required → nullable
            'purchase_per_piece_price' => 'nullable|numeric|min:0',
            'per_piece_price'=> 'required|numeric|min:0',
            'minimum_order'  => 'required|integer|min:1',
            'tax_percentage' => 'nullable|numeric|min:0|max:100',
            'discount_value' => 'nullable|numeric|min:0',
            'discount_type'  => 'nullable|in:NONE,FLAT,PERCENTAGE',
        ]);

        $product = Product::findOrFail($request->product_id);

        // ── Stock ──

        $addStock = (int) ($request->stock_quantity ?? 0);
        $product->stock_quantity = (int) $product->stock_quantity + $addStock;

        // ── Per Piece Price → sale_price ──
        $product->sale_price = $request->per_piece_price;

        // ── Minimum Order ──
        $product->minimum_order = $request->minimum_order;

        // ── Regular Price = per_piece × minimum_order (base, undiscounted package total) ──
        $product->regular_price = round(
            $request->per_piece_price * $request->minimum_order,
            2
        );

        // ── Discount amount off Regular Price ──
        $discountType  = $request->discount_type ?? 'NONE';
        $discountValue = (float) ($request->discount_value ?? 0);

        $discountAmount = 0;
        if ($discountType === 'FLAT') {
            $discountAmount = $discountValue;
        } elseif ($discountType === 'PERCENTAGE') {
            $discountAmount = $product->regular_price * ($discountValue / 100);
        }

        // ── Package Price = actual final selling price after discount ──
        $product->package_price = round(
            max($product->regular_price - $discountAmount, 0),
            2
        );

        // ── Purchase Per Piece Price × minimum_order = Purchase Package Price ──
        $purchasePerPiece = (float) ($request->purchase_per_piece_price ?? 0);
        $product->purchase_price = round($purchasePerPiece * $request->minimum_order, 2);

        // ── Tax / VAT ──
        $product->tax_percentage = $request->tax_percentage ?? 0;

        // ── Discount ──
        $product->discount_value = $discountValue;
        $product->discount_type  = $discountType;

        $product->save();

        ActivityLog::create([
            'user_id'      => session('user_id'),
            'performed_by' => session('user_name'),
            'module'       => 'Inventory Management',
            'action'       => 'STOCK UPDATE',
            'item'         => $product->name,
            'details'      => 'Stock: '          . $product->stock_quantity .
                             ' | Per Piece: ৳'  . $product->sale_price .
                             ' | Min Order: '   . $product->minimum_order .
                             ' | Regular: ৳'    . $product->regular_price .
                             ' | Package: ৳'    . $product->package_price .
                             ' | Purchase Package: ৳' . $product->purchase_price .
                             ' | Tax: '         . $product->tax_percentage . '%',
        ]);

        return redirect()
            ->route('inventory.list')
            ->with('success', 'Inventory updated successfully.');
    }
    public function accountsTracking()
    {
        $products = Product::latest()->get();

        return view('admin.inventory.accounts-tracking', compact('products'));
    }
    public function inventoryAccounts()
    {
        $products = \App\Models\Product::latest()->get();

        return view(
            'admin.inventory.accounts-tracking',
            compact('products')
        );
    }
}

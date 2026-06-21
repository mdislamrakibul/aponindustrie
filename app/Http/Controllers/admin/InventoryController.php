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
            'purchase_price' => 'nullable|numeric|min:0',
            'regular_price'  => 'nullable|numeric|min:0',
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

        // ── Purchase Price ──

        if ($request->filled('purchase_price')) {
            $product->purchase_price = $request->purchase_price;
        }

        // ── Per Piece Price → sale_price ──
        $product->sale_price = $request->per_piece_price;

        // ── Minimum Order ──
        $product->minimum_order = $request->minimum_order;

        // ── Package Price = per_piece × minimum_order ──
        $product->package_price = round(
            $request->per_piece_price * $request->minimum_order
        );

        // ── Regular Price ──
       
        if ($request->filled('regular_price')) {
            $product->regular_price = $request->regular_price;
        } else {
            $product->regular_price = $product->package_price;
        }

        // ── Tax / VAT ──
        $product->tax_percentage = $request->tax_percentage ?? 0;

        // ── Discount ──
        $product->discount_value = $request->discount_value ?? 0;
        $product->discount_type  = $request->discount_type  ?? 'NONE';

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
                             ' | Package: ৳'    . $product->package_price .
                             ' | Regular: ৳'    . $product->regular_price .
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

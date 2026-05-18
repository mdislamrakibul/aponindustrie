<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class InventoryController extends Controller
{
    public function inventoryList()
    {
        $products = Product::paginate(10);

        return view(
            'admin.inventory.inventory-list',
            compact('products')
        );
    }

    public function accountsTracking()
    {
        $products = Product::paginate(10);

        return view(
            'admin.inventory.accounts-tracking',
            compact('products')
        );
    }
}
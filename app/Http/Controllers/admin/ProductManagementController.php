<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Product;
use App\Models\Category;

class ProductManagementController extends Controller
{

    public function index(Request $request)
    {

        $query = Product::with(['category', 'media']);

        // SEARCH
        if ($request->search) {

            $query->where(function($q) use ($request){

                $q->where('name', 'LIKE', '%'.$request->search.'%')
                  ->orWhere('id', $request->search);

            });
        }

        // CATEGORY FILTER
        if ($request->category_id) {

            $query->where('category_id', $request->category_id);
        }

        $products = $query
            ->latest()
            ->paginate(10);

        $categories = Category::whereNull('parent_id')->get();

        return view('admin.products.index', compact(
            'products',
            'categories'
        ));
    }
    public function create()
    {
        $categories = Category::whereNull('parent_id')->get();

        return view('admin.products.create', compact('categories'));
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);

        return view('admin.products.edit', compact('product'));
    }
    public function show($id)
    {
        $product = Product::with(['category', 'media', 'brand'])
            ->findOrFail($id);

        return view('admin.products.show', compact('product'));
    }
    public function store(Request $request)
    {
        return back()->with('success', 'Product form submitted.');
    }
    public function toggleStatus($id)
    {
        $product = Product::findOrFail($id);

        $product->status =
            $product->status == 'PUBLISHED'
            ? 'INACTIVE'
            : 'PUBLISHED';

        $product->save();

        return redirect()
            ->back()
            ->with('success', 'Product status updated successfully');
    }

}
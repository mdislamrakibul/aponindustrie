<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Product;
use App\Models\Category;
use App\Models\Media;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

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

        $categories = Category::with('children')
            ->where('parent_id', 0)
            ->get();

        return view('admin.products.index', compact(
            'products',
            'categories'
        ));
    }
    public function create()
    {
        $categories = Category::with('children')
            ->where('parent_id', 0)
            ->get();

        return view('admin.products.create', compact('categories'));
    }

    public function edit($id)
    {
        $product = Product::with(['media', 'category'])
            ->findOrFail($id);

        $categories = Category::with('children')
            ->where('parent_id', 0)
            ->get();

        return view('admin.products.edit', compact(
            'product',
            'categories'
        ));
    }
    public function show($id)
    {
        $product = Product::with(['category', 'media', 'brand'])
            ->findOrFail($id);

        return view('admin.products.show', compact('product'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'sku' => 'required|string|unique:tbl_products,sku',
            'category_id' => 'required',
            'short_description' => 'required',
            'description' => 'required',
            'status' => 'required',
            'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ], [
            'name.required' => 'Product name is required',
            'sku.required' => 'SKU is required',
            'sku.unique' => 'This SKU already exists',
            'category_id.required' => 'Please select category',
            'image.required' => 'Product image is required',
        ]);

        $product = new Product();

        $product->uploader_id = session('user_id');

        $product->name = $request->name;

        $product->slug = Str::slug($request->name);

        $product->category_id = $request->category_id;

        $product->description = $request->description;

        $product->short_description = $request->short_description;

        $product->sku = $request->sku;

        $product->barcode = $request->barcode;

        $product->regular_price = $request->regular_price ?? 0;

        $product->sale_price = $request->sale_price ?? 0;

        $product->stock_quantity = $request->stock_quantity ?? 0;

        $product->minimum_order = $request->minimum_order ?? 1;

        $product->status = $request->status;

        $product->tags = $request->tags;

        // FEATURED TYPES
        if ($request->featured_sections) {

            $product->product_adv_type = json_encode(
                $request->featured_sections
            );

            $product->is_featured = 1;
        }

        $product->save();

        // IMAGE UPLOAD
        if ($request->hasFile('image')) {

            $image = $request->file('image');

            $imageName = time() . '_' . uniqid() . '.' . $image->extension();

            $destinationPath = public_path('uploads/products/');

            // CREATE FOLDER IF NOT EXISTS
            if (!file_exists($destinationPath)) {

                mkdir($destinationPath, 0777, true);
            }

            // MOVE IMAGE
            $image->move($destinationPath, $imageName);

            // SAVE DATABASE
            Media::create([
                'title' => $product->name,
                'model_id' => $product->id,
                'model_type' => Product::class,
                'file_path' => 'uploads/products/',
                'image_name' => $imageName,
                'file_type' => 'image',
                'image_type' => 'PRODUCT',
                'is_active' => 1,
            ]);
        }

        return redirect()
            ->back()
            ->with('success', 'Product created successfully');
    }
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'sku' => 'required|unique:tbl_products,sku,' . $product->id,
            'category_id' => 'required',
            'short_description' => 'required',
            'description' => 'required',
            'status' => 'required',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $product->name = $request->name;

        $product->slug = Str::slug($request->name);

        $product->category_id = $request->category_id;

        $product->description = $request->description;

        $product->short_description = $request->short_description;

        $product->sku = $request->sku;

        //$product->barcode = $request->barcode;

        $product->status = $request->status;

        $product->tags = $request->tags;

        // FEATURED TYPES
        if ($request->featured_sections) {

            $product->product_adv_type = json_encode(
                $request->featured_sections
            );

            $product->is_featured = 1;

        } else {

            $product->product_adv_type = null;

            $product->is_featured = 0;
        }

        $product->save();

        // IMAGE UPDATE
        
        if ($request->hasFile('image')) {

            $image = $request->file('image');

            $imageName = time() . '_' . uniqid() . '.' . $image->extension();

            $destinationPath = public_path('uploads/products/');

            if (!file_exists($destinationPath)) {

                mkdir($destinationPath, 0777, true);
            }

            $image->move($destinationPath, $imageName);

            Media::updateOrCreate(

                [
                    'model_id' => $product->id,
                    'model_type' => Product::class,
                ],

                [
                    'image_name' => $imageName,
                    'file_path' => 'uploads/products/',
                ]
            );
        }

        return redirect()
            ->back()
            ->with('success', 'Product updated successfully');
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

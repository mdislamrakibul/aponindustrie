<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Product;
use App\Models\Category;
use App\Models\Media;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Models\ActivityLog;

class ProductManagementController extends Controller
{

    public function index(Request $request)
    {

        $query = Product::with(['category', 'media']);

        // SEARCH
        if ($request->search) {

            $query->where(function ($q) use ($request) {

                $q->where('name', 'LIKE', '%' . $request->search . '%')
                    ->orWhere('id', $request->search);
            });
        }

        // CATEGORY FILTER
        if ($request->category_id) {

            $query->where('category_id', $request->category_id);
        }

        $products = $query
            ->latest()
            ->paginate(100);

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
            'short_description' => 'required|string|max:500',
            'description' => 'required|string|max:5000',
            'additional_info_rows'          => 'nullable|array',
            'additional_info_rows.*.label'  => 'nullable|string|max:255',
            'additional_info_rows.*.value'  => 'nullable|string|max:1000',
            'additional_info_active'        => 'nullable|boolean',
            'status' => 'required',
            'image'  => 'required|image|mimes:jpg,jpeg,png,webp|max:4096',
            'image2' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
            'image3' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
            'regular_price' => 'nullable|numeric',
            'sale_price' => 'nullable|numeric',
            'stock_quantity' => 'nullable|integer',
            'minimum_order' => 'nullable|integer',
        ], [
            'name.required' => 'Product name is required',
            'sku.required' => 'SKU is required',
            'sku.unique' => 'This SKU already exists',
            'category_id.required' => 'Please select category',
            'image.required' => 'Product image is required',
            'short_description.max'
            => 'Short description maximum 300 characters',

            'description.max'
            => 'Full description maximum 3000 characters',
        ]);

        $product = new Product();

        $product->uploader_id = session('user_id');

        $product->name = $request->name;

        $product->slug = Str::slug($request->name);

        $product->category_id = $request->category_id;

        $product->description = $request->description;

        $product->short_description = $request->short_description;

        $product->additional_info        = self::encodeAdditionalInfo($request->input('additional_info_rows', []));
        $product->additional_info_active = $request->boolean('additional_info_active');

        $product->sku = $request->sku;

        //$product->barcode = $request->barcode;

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
        ActivityLog::create([
            'user_id'      => session('user_id'),
            'performed_by' => session('user_name'),
            'module'       => 'Product Management',
            'action'       => 'CREATE',
            'item'         => $product->name,
            'details'      => 'New product created',
        ]);

        // IMAGE UPLOAD
        if ($request->hasFile('image')) {

            $image = $request->file('image');

            $imageName = time() . '_' . uniqid() . '.' . $image->extension();

            $destinationPath = upload_root('uploads/products');

            // CREATE FOLDER IF NOT EXISTS
            if (!file_exists($destinationPath)) {

                mkdir($destinationPath, 0755, true);
            }

            // MOVE IMAGE
            $image->move($destinationPath, $imageName);

            // SAVE DATABASE
            Media::create([

                'title' => $product->name,

                'model_id' => $product->id,

                'file_path' => 'uploads/products/',

                'image_name' => $imageName,

                'file_type' => 'image',

                'image_type' => 'PRODUCT',

                'position' => 1,

                'is_active' => 1,

                'device_type' => 'ALL',

            ]);
            
        }
        // IMAGE 2 UPLOAD (optional)
        if ($request->hasFile('image2')) {

            $image2     = $request->file('image2');
            $imageName2 = time() . '_' . uniqid() . '.' . $image2->extension();

            $dir2 = upload_root('uploads/products');
            if (!file_exists($dir2)) {
                mkdir($dir2, 0755, true);
            }
            $image2->move($dir2, $imageName2);

            Media::create([
                'title'      => $product->name,
                'model_id'   => $product->id,
                'file_path'  => 'uploads/products/',
                'image_name' => $imageName2,
                'file_type'  => 'image',
                'image_type' => 'PRODUCT',
                'position'   => 2,
                'is_active'  => 1,
                'device_type'=> 'ALL',
            ]);
        }

        // IMAGE 3 UPLOAD (optional)
        if ($request->hasFile('image3')) {
            $image3     = $request->file('image3');
            $imageName3 = time() . '_' . uniqid() . '.' . $image3->extension();

            $dir3 = upload_root('uploads/products');
            if (!file_exists($dir3)) {
                mkdir($dir3, 0755, true);
            }
            $image3->move($dir3, $imageName3);
            Media::create([
                'title'      => $product->name,
                'model_id'   => $product->id,
                'file_path'  => 'uploads/products/',
                'image_name' => $imageName3,
                'file_type'  => 'image',
                'image_type' => 'PRODUCT',
                'position'   => 3,
                'is_active'  => 1,
                'device_type'=> 'ALL',
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
            'additional_info_rows'         => 'nullable|array',
            'additional_info_rows.*.label' => 'nullable|string|max:255',
            'additional_info_rows.*.value' => 'nullable|string|max:1000',
            'additional_info_active'       => 'nullable|boolean',
            'status' => 'required',
            'image'  => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
            'image2' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
            'image3' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
        ]);

        $product->name = $request->name;

        $product->slug = Str::slug($request->name);

        $product->category_id = $request->category_id;

        $product->description = $request->description;

        $product->short_description = $request->short_description;

        $product->additional_info        = self::encodeAdditionalInfo($request->input('additional_info_rows', []));
        $product->additional_info_active = $request->boolean('additional_info_active');

        $product->sku = $request->sku;

        //$product->barcode = $request->barcode;

        $product->regular_price = $request->regular_price;

        $product->sale_price = $request->sale_price;

        $product->stock_quantity = $request->stock_quantity;

        $product->minimum_order = $request->minimum_order;

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
        ActivityLog::create([
            'user_id'      => session('user_id'),
            'performed_by' => session('user_name'),
            'module'       => 'Product Management',
            'action'       => 'UPDATE',
            'item'         => $product->name,
            'details'      => 'Product information updated',
        ]);


        // IMAGE UPDATE

        if ($request->hasFile('image')) {

            $image = $request->file('image');

            $imageName = time() . '_' . uniqid() . '.' . $image->extension();

            $destinationPath = upload_root('uploads/products');

            if (!file_exists($destinationPath)) {

                mkdir($destinationPath, 0755, true);
            }

            $image->move($destinationPath, $imageName);

            Media::updateOrCreate(
                [
                    'model_id' => $product->id,
                    'position' => 1,
                ],
                [
                    'title'       => $product->name,
                    'image_name'  => $imageName,
                    'file_path'   => 'uploads/products/',
                    'file_type'   => 'image',
                    'image_type'  => 'PRODUCT',
                    'is_active'   => 1,
                    'device_type' => 'ALL',
                ]
            );
            ActivityLog::create([
                'user_id'      => session('user_id'),
                'performed_by' => session('user_name'),
                'module'       => 'Product Management',
                'action'       => 'IMAGE UPDATE',
                'item'         => $product->name,
                'details'      => 'Updated product image',
            ]);
        }

        // IMAGE 2 UPDATE (optional)
        if ($request->hasFile('image2')) {

            $image2     = $request->file('image2');
            $imageName2 = time() . '_' . uniqid() . '.' . $image2->extension();

            $dir2 = upload_root('uploads/products');
            if (!file_exists($dir2)) {
                mkdir($dir2, 0755, true);
            }
            $image2->move($dir2, $imageName2);

            Media::updateOrCreate(
                ['model_id' => $product->id, 'position' => 2],
                [
                    'title'      => $product->name,
                    'image_name' => $imageName2,
                    'file_path'  => 'uploads/products/',
                    'file_type'  => 'image',
                    'image_type' => 'PRODUCT',
                    'is_active'  => 1,
                    'device_type'=> 'ALL',
                ]
            );
        }

        // IMAGE 3 UPDATE (optional)
        if ($request->hasFile('image3')) {
            $image3     = $request->file('image3');
            $imageName3 = time() . '_' . uniqid() . '.' . $image3->extension();

            $dir3 = upload_root('uploads/products');
            if (!file_exists($dir3)) {
                mkdir($dir3, 0755, true);
            }
            $image3->move($dir3, $imageName3);
            Media::updateOrCreate(
                ['model_id' => $product->id, 'position' => 3],
                [
                    'title'      => $product->name,
                    'image_name' => $imageName3,
                    'file_path'  => 'uploads/products/',
                    'file_type'  => 'image',
                    'image_type' => 'PRODUCT',
                    'is_active'  => 1,
                    'device_type'=> 'ALL',
                ]
            );
        }

        return redirect()
            ->back()
            ->with('success', 'Product updated successfully');
    }
    private static function encodeAdditionalInfo(array $rows): ?string
    {
        $filtered = array_values(array_filter($rows, function ($r) {
            return !empty(trim($r['label'] ?? '')) || !empty(trim($r['value'] ?? ''));
        }));
        return !empty($filtered) ? json_encode($filtered) : null;
    }

    public function toggleStatus($id)
    {
        $product = Product::findOrFail($id);

        $product->status =
            $product->status == 'PUBLISHED'
            ? 'INACTIVE'
            : 'PUBLISHED';

        $product->save();
        ActivityLog::create([
            'user_id'      => session('user_id'),
            'performed_by' => session('user_name'),
            'module'       => 'Product Management',
            'action'       => 'STATUS UPDATE',
            'item'         => $product->name,
            'details'      => 'Changed status to ' . $product->status,
        ]);

        return redirect()
            ->back()
            ->with('success', 'Product status updated successfully');
    }
}

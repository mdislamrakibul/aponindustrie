<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class ProductController extends Controller
{
    /**
     * Product_by_category
     *
     * @param  mixed  $request
     * @return void
     */
    public function Product_by_category(Request $request)
    {
        $newProducts = [];
        // dd($request->all());
        $products_by_category = Product::query()
            ->with([
                'media' => function ($q) {
                    $q->where('image_type', 'PRODUCT')
                    ->orderBy('position', 'asc');
                },
                'category'
            ])
            ->GetProductByLevelOrCategory($request->sub_category_id, $request->category_id)
            ->inRandomOrder()
            ->get()
            ->toArray();

        // dd($products_by_category);
        // ->latest()
        // ->paginate(48);

        // dd($products_by_category);
        $products = Product::published([
            'id',
            'name',
            'category_id',
            'sale_price',
            'regular_price',
            'discount_type',
            'discount_value',
            'product_type',
            'is_discounted',
        ])
            ->with(['category:id,name,slug', 'media:id,title,file_path,image_type,position,model_id,image_name'])
            ->withAvg(['reviews' => function ($q) {
                $q->where('status', 'approved');
            }], 'rating')
            // ->inStock()
            ->inRandomOrder()
            // ->limit(8)
            ->get()
            ->toArray();


        foreach ($products as $item => $value) {
            if (isset($value['product_type']) && in_array('NEW', is_string($value['product_type'])
                ? json_decode($value['product_type'], true)
                : $value['product_type'])) {
                $newProducts[] = $value;
            }
        }


        // dd([
        //     'products' => $products,
        //     'category_name' => $request->category_name,
        //     'sub_category_name' => $request->sub_category_name,
        // ]);
        return view('product.Product_By_Category', [
            'products' => $products_by_category,
            'category_name' => $request->category_name,
            'newProduct' => collect($newProducts)->shuffle()->take(7),
            'sub_category_name' => $request->sub_category_name,
            'total_item' => count($products_by_category),
        ]);
    }

    /**
     * Product_Details
     *
     * @return void
     */
    public function Product_Details(Request $request)
    {

        $newProducts = [];

        $product = Product::query()
            ->with(['media', 'category', 'brand', 'reviews'])
            ->with(['reviews' => function ($query) {
                $query->where('status', 'approved');
            }, 'reviews.user'])
            ->withAvg(['reviews' => function ($q) {
                $q->where('status', 'approved');
            }], 'rating')
            // Pass sub_category_id or category_id from the URL
            ->GetProductByProductId($request->product_id)
            // ->inStock()
            ->first();

        // dd($product->reviews[0]['user']);


        $products = Product::published([
            'id',
            'name',
            'category_id',
            'sale_price',
            'regular_price',
            'discount_type',
            'discount_value',
            'product_type',
            'is_discounted',

        ])
            ->with(['category:id,name,slug', 'media:id,title,file_path,image_type,position,model_id,image_name'])
            ->withAvg(['reviews' => function ($q) {
                $q->where('status', 'approved');
            }], 'rating')
            // ->inStock()
            ->inRandomOrder()
            // ->limit(8)
            ->get()
            ->toArray();


        foreach ($products as $item => $value) {
            if (isset($value['product_type']) && in_array('NEW', is_string($value['product_type'])
                ? json_decode($value['product_type'], true)
                : $value['product_type'])) {
                $newProducts[] = $value;
            }
        }




        $relatedProducts = Product::query()
            ->with(['media', 'category'])
            // Pass sub_category_id or category_id from the URL
            ->GetProductByLevelOrCategory($request->category_id, null)
            ->withAvg(['reviews' => function ($q) {
                $q->where('status', 'approved');
            }], 'rating')
            // ->inStock()
            ->inRandomOrder()

            ->get()
            ->toArray();

        // dd($newProducts);

        $category = Category::with('parent')->find($request->category_id);

        // dd($product);

        $ratingCounts = $product->reviews()
            ->where('status', 'approved')
            ->select('rating', DB::raw('count(*) as total'))
            ->groupBy('rating')
            ->pluck('total', 'rating');



        $totalReviews = $ratingCounts->sum();

        // dd([
        //     'product' => $product,
        //     'relatedProducts' => $relatedProducts,
        //     'category_name' => $category->name,
        //     'sub_category_name' => $category->parent ? $category->parent->name : null,
        //     '$ratingCounts' => $ratingCounts,
        //     '$totalReviews' => $totalReviews
        // ]);

        return view('product.Product_Details', [
            'product' => $product,
            'relatedProducts' => $relatedProducts,
            'newProduct' => collect($newProducts)->shuffle()->take(7),
            'category_name' => $category->name,
            'sub_category_name' => $category->parent ? $category->parent->name : null,
            '$ratingCounts' => $ratingCounts,
            '$totalReviews' => $totalReviews
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class StoreController extends Controller
{


    /**
     * Weekly_Featured
     *
     * @param  mixed $request
     * @return void
     */
    public function Weekly_Featured(Request $request)
    {

        $featuredProducts = Product::published([
            'id',
            'name',
            'category_id',
            'sale_price',
            'regular_price',
            'discount_type',
            'discount_value',
            'product_type',
            'is_discounted'
        ])
            ->with(['category:id,name,slug', 'media:id,title,file_path,image_type,position,model_id,image_name'])
            // ->weeklyFeatured()
            ->WithTag('WEEKLYFEATURED')
            ->withAvg(['reviews' => function ($q) {
                $q->where('status', 'approved');
            }], 'rating')
            // ->inStock()
            ->inRandomOrder()
            ->latest()
            ->paginate(24);


        $new_products = Product::published([
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
            // ->productType("FEATURED")
            ->withAvg(['reviews' => function ($q) {
                $q->where('status', 'approved');
            }], 'rating')
            // ->inStock()
            ->inRandomOrder()
            // ->limit(8)
            ->get()
            ->toArray();


        foreach ($new_products as $item => $value) {
            if (isset($value['product_type']) && in_array('NEW', is_string($value['product_type'])
                ? json_decode($value['product_type'], true)
                : $value['product_type'])) {
                $newProducts[] = $value;
            }
        }


        // echo "<pre>";
        // print_r($products);
        // echo "</pre>";
        // dd($featuredProducts);
        return view('other_store.Weekly_Featured', [
            'featuredProducts' => $featuredProducts,
            'newProduct' => collect($newProducts)->shuffle()->take(5),
            'total_item' => count($featuredProducts)
        ]);
    }





    /**
     * Hot_Sale_Item
     *
     * @param  mixed $request
     * @return void
     */
    public function Hot_Sale_Item(Request $request)
    {

        $featuredProducts = Product::published([
            'id',
            'name',
            'category_id',
            'sale_price',
            'regular_price',
            'discount_type',
            'discount_value',
            'product_type',
            'is_discounted'
        ])
            ->with(['category:id,name,slug', 'media:id,title,file_path,image_type,position,model_id,image_name'])
            ->WithTag('HOTSALEITEMS')
            ->withAvg(['reviews' => function ($q) {
                $q->where('status', 'approved');
            }], 'rating')
            // ->inStock()
            ->inRandomOrder()
            ->latest()

            ->paginate(24);

        $new_products = Product::published([
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
            ->get()
            ->toArray();


        foreach ($new_products as $item => $value) {
            if (isset($value['product_type']) && in_array('NEW', is_string($value['product_type'])
                ? json_decode($value['product_type'], true)
                : $value['product_type'])) {
                $newProducts[] = $value;
            }
        }

        // dd($featuredProducts);
        return view('other_store.Hot_Sale_Item', [
            'featuredProducts' => $featuredProducts,
            'total_item' => count($featuredProducts),
            'newProduct' => collect($newProducts)->shuffle()->take(5),
        ]);
    }

    /**
     * Top_New_Items
     *
     * @param  mixed $request
     * @return void
     */
    public function Top_New_Items(Request $request)
    {
        $featuredProducts = Product::published([
            'id',
            'name',
            'category_id',
            'sale_price',
            'regular_price',
            'discount_type',
            'discount_value',
            'product_type',
            'is_discounted'
        ])
            ->with(['category:id,name,slug', 'media:id,title,file_path,image_type,position,model_id,image_name'])
            ->WithTag('TOPNEWITEMS')
            ->withAvg(['reviews' => function ($q) {
                $q->where('status', 'approved');
            }], 'rating')
            // ->inStock()
            ->inRandomOrder()
            ->latest()
            ->paginate(24);;


        $new_products = Product::published([
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
            ->get()
            ->toArray();


        foreach ($new_products as $item => $value) {
            if (isset($value['product_type']) && in_array('NEW', is_string($value['product_type'])
                ? json_decode($value['product_type'], true)
                : $value['product_type'])) {
                $newProducts[] = $value;
            }
        }


        return view('other_store.Top_New_Items', [
            'featuredProducts' => $featuredProducts,
            'total_item' => count($featuredProducts),
            'newProduct' => collect($newProducts)->shuffle()->take(5),
        ]);
    }

    /**
     * Top_Selling
     *
     * @param  mixed $request
     * @return void
     */
    public function Top_Selling(Request $request)
    {

        $featuredProducts = Product::published([
            'id',
            'name',
            'category_id',
            'sale_price',
            'regular_price',
            'discount_type',
            'discount_value',
            'product_type',
            'is_discounted'
        ])
            ->with(['category:id,name,slug', 'media:id,title,file_path,image_type,position,model_id,image_name', 'reviews'])
            ->WithTag('TOPSELLING')
            ->withAvg(['reviews' => function ($q) {
                $q->where('status', 'approved');
            }], 'rating')
            // ->inStock()
            ->inRandomOrder()

            ->latest()
            ->paginate(24);


        $new_products = Product::published([
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
            ->get()
            ->toArray();


        foreach ($new_products as $item => $value) {
            if (isset($value['product_type']) && in_array('NEW', is_string($value['product_type'])
                ? json_decode($value['product_type'], true)
                : $value['product_type'])) {
                $newProducts[] = $value;
            }
        }


        return view('other_store.Top_Selling', [
            'featuredProducts' => $featuredProducts,
            'total_item' => count($featuredProducts),
            'newProduct' => collect($newProducts)->shuffle()->take(5),
        ]);
    }

    /**
     * Top_Rated_Item
     *
     * @param  mixed $request
     * @return void
     */
    public function Top_Rated_Item(Request $request)
    {

        $featuredProducts = Product::published([
            'id',
            'name',
            'category_id',
            'sale_price',
            'regular_price',
            'discount_type',
            'discount_value',
            'product_type',
            'is_discounted'
        ])
            ->with(['category:id,name,slug', 'media:id,title,file_path,image_type,position,model_id,image_name'])
            ->WithTag('TOPRATEDITEMS')
            ->withAvg(['reviews' => function ($q) {
                $q->where('status', 'approved');
            }], 'rating')
            // ->inStock()
            ->inRandomOrder()

            ->latest()
            ->paginate(24);




        $new_products = Product::published([
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
            ->get()
            ->toArray();


        foreach ($new_products as $item => $value) {
            if (isset($value['product_type']) && in_array('NEW', is_string($value['product_type'])
                ? json_decode($value['product_type'], true)
                : $value['product_type'])) {
                $newProducts[] = $value;
            }
        }



        return view('other_store.Top_Rated_Item', [
            'featuredProducts' => $featuredProducts,
            'total_item' => count($featuredProducts),
            'newProduct' => collect($newProducts)->shuffle()->take(5),
        ]);
    }
}

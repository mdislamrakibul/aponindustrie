<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Index
     *
     * @return void
     */
    public function Index()
    {

        $featuredProducts = [];
        $popularProducts = [];
        $newAddedProducts = [];

        $products = Product::published([
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
            ->with([
                'category:id,name,slug',
                'media' => function ($q) {
                    $q->where('image_type', 'PRODUCT')
                    ->orderBy('position', 'asc')
                    ->select('id', 'title', 'file_path', 'image_type', 'position', 'model_id', 'image_name');
                }
            ])
            // ->productType("FEATURED")
            ->withAvg(['reviews' => function ($q) {
                $q->where('status', 'approved');
            }], 'rating')
            // ->inStock()
            ->inRandomOrder()
            // ->limit(8)
            ->get()
            ->toArray();


        foreach ($products as $item => $value) {
            if (isset($value['product_type']) && in_array('FEATURED', is_string($value['product_type'])
                ? json_decode($value['product_type'], true)
                : $value['product_type'])) {
                $featuredProducts[] = $value;
            }
        }
        foreach ($products as $item => $value) {
            if (isset($value['product_type']) && in_array('POPULAR', is_string($value['product_type'])
                ? json_decode($value['product_type'], true)
                : $value['product_type'])) {
                $popularProducts[] = $value;
            }
        }
        foreach ($products as $item => $value) {
            if (isset($value['product_type']) && in_array('NEW', is_string($value['product_type'])
                ? json_decode($value['product_type'], true)
                : $value['product_type'])) {
                $newAddedProducts[] = $value;
            }
        }


        // dd(collect($featuredProducts));
        return view('Home', [
            'featuredProducts' => collect($featuredProducts)->shuffle()->take(8),
            'popularProducts' => collect($popularProducts)->shuffle()->take(8),
            'newAddedProducts' => collect($newAddedProducts)->shuffle()->take(8),
            'newArrivals1stRow' => collect($newAddedProducts)->shuffle(),
            'newArrivals2ndRow' => collect($newAddedProducts)->shuffle(),
            'mostSellingProducts' => collect($popularProducts)->shuffle(),
            'mostPopularProducts' => collect($popularProducts)->shuffle(),
        ]);
    }

    /**
     * About_Us
     *
     * @return void
     */
    public function About_Us()
    {
        return view('About_Us');
    }

    /**
     * Privacy_Policy
     *
     * @return void
     */
    public function Privacy_Policy()
    {
        return view('Privacy_Policy');
    }

    /**
     * Terms_And_Conditions
     *
     * @return void
     */
    public function Terms_And_Conditions()
    {
        return view('Terms_And_Conditions');
    }
    /**
     * FAQ
     *
     * @return void
     */
    public function FAQ()
    {
        return view('FAQ');
    }


    /**
     * Our_Service
     *
     * @return void
     */
    public function Our_Service()
    {
        return view('Our_Service');
    }
}

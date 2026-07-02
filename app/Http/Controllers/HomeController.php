<?php

namespace App\Http\Controllers;

use App\Models\Banner;
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

        $featuredProducts    = [];
        $popularProducts     = [];
        $mostSellingProducts = [];
        $mostPopularProducts = [];

        $products = Product::published([
            'id',
            'name',
            'category_id',
            'sale_price',
            'regular_price',
            'discount_type',
            'discount_value',
            'product_type',
            'product_adv_type',
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
            ->withAvg(['reviews' => function ($q) {
                $q->where('status', 'approved');
            }], 'rating')
            ->inRandomOrder()
            ->get()
            ->toArray();

        foreach ($products as $value) {
            $advTypes = is_string($value['product_adv_type'] ?? null)
                ? (json_decode($value['product_adv_type'], true) ?? [])
                : ($value['product_adv_type'] ?? []);
            $advTypes = (array) $advTypes;

            if (in_array('WEEKLYFEATURED', $advTypes)) {
                $featuredProducts[] = $value;
            }
            if (in_array('HOTSALEITEMS', $advTypes)) {
                $popularProducts[] = $value;
            }
            if (in_array('TOPSELLING', $advTypes)) {
                $mostSellingProducts[] = $value;
            }
            if (in_array('TOPRATEDITEMS', $advTypes)) {
                $mostPopularProducts[] = $value;
            }
        }

        // Most recently added products — ordered by created_at desc
        $newAddedProducts = Product::published([
            'id', 'name', 'category_id', 'sale_price', 'regular_price',
            'discount_type', 'discount_value', 'product_type', 'product_adv_type', 'is_discounted',
        ])
            ->with([
                'category:id,name,slug',
                'media' => function ($q) {
                    $q->where('image_type', 'PRODUCT')
                      ->orderBy('position', 'asc')
                      ->select('id', 'title', 'file_path', 'image_type', 'position', 'model_id', 'image_name');
                }
            ])
            ->withAvg(['reviews' => function ($q) {
                $q->where('status', 'approved');
            }], 'rating')
            ->latest()
            ->take(16)
            ->get()
            ->toArray();


        try {
            $sliders = Banner::where('type', 'SLIDER')
                ->where('is_active', 1)
                ->orderBy('sort_order')
                ->get();

            $banners = Banner::where('type', 'BANNER')
                ->where('is_active', 1)
                ->get()
                ->keyBy('slot');
        } catch (\Throwable $e) {
            $sliders = collect();
            $banners = collect();
        }

        // dd(collect($featuredProducts));
        return view('Home', [
            'featuredProducts'    => collect($featuredProducts)->shuffle()->take(8),
            'popularProducts'     => collect($popularProducts)->shuffle()->take(8),
            'newAddedProducts'    => collect($newAddedProducts)->take(8),
            'newArrivals1stRow'   => collect($newAddedProducts),
            'newArrivals2ndRow'   => collect($newAddedProducts),
            'mostSellingProducts' => collect($mostSellingProducts)->shuffle(),
            'mostPopularProducts' => collect($mostPopularProducts)->shuffle(),
            'sliders'             => $sliders,
            'banners'             => $banners,
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

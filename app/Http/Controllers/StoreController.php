<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    private function mediaQuery(): \Closure
    {
        return function ($q) {
            $q->where('image_type', 'PRODUCT')
              ->orderBy('position', 'asc')
              ->select('id', 'title', 'file_path', 'image_type',
                        'position', 'model_id', 'image_name');
        };
    }

    private function newProductsQuery(): array
    {
        $newProducts = [];
        $items = Product::published([
            'id', 'name', 'category_id', 'sale_price',
            'regular_price', 'discount_type', 'discount_value',
            'product_type', 'is_discounted',
        ])
        ->with(['category:id,name,slug', 'media' => $this->mediaQuery()])
        ->withAvg(['reviews' => fn($q) => $q->where('status', 'approved')], 'rating')
        ->inRandomOrder()
        ->get()
        ->toArray();

        foreach ($items as $value) {
            if (isset($value['product_type']) && in_array('NEW',
                is_string($value['product_type'])
                    ? json_decode($value['product_type'], true)
                    : $value['product_type']
            )) {
                $newProducts[] = $value;
            }
        }
        return $newProducts;
    }

    public function Weekly_Featured(Request $request)
    {
        $featuredProducts = Product::published([
            'id', 'name', 'category_id', 'sale_price', 'regular_price',
            'discount_type', 'discount_value', 'product_type', 'is_discounted',
        ])
        ->with(['category:id,name,slug', 'media' => $this->mediaQuery()])
        ->WithTag('WEEKLYFEATURED')
        ->withAvg(['reviews' => fn($q) => $q->where('status', 'approved')], 'rating')
        ->inRandomOrder()
        ->latest()
        ->paginate(24);

        return view('other_store.Weekly_Featured', [
            'featuredProducts' => $featuredProducts,
            'newProduct'       => collect($this->newProductsQuery())->shuffle()->take(5),
            'total_item'       => count($featuredProducts),
        ]);
    }

    public function Hot_Sale_Item(Request $request)
    {
        $featuredProducts = Product::published([
            'id', 'name', 'category_id', 'sale_price', 'regular_price',
            'discount_type', 'discount_value', 'product_type', 'is_discounted',
        ])
        ->with(['category:id,name,slug', 'media' => $this->mediaQuery()])
        ->WithTag('HOTSALEITEMS')
        ->withAvg(['reviews' => fn($q) => $q->where('status', 'approved')], 'rating')
        ->inRandomOrder()
        ->latest()
        ->paginate(24);

        return view('other_store.Hot_Sale_Item', [
            'featuredProducts' => $featuredProducts,
            'total_item'       => count($featuredProducts),
            'newProduct'       => collect($this->newProductsQuery())->shuffle()->take(5),
        ]);
    }

    public function Top_New_Items(Request $request)
    {
        $featuredProducts = Product::published([
            'id', 'name', 'category_id', 'sale_price', 'regular_price',
            'discount_type', 'discount_value', 'product_type', 'is_discounted',
        ])
        ->with(['category:id,name,slug', 'media' => $this->mediaQuery()])
        ->WithTag('TOPNEWITEMS')
        ->withAvg(['reviews' => fn($q) => $q->where('status', 'approved')], 'rating')
        ->inRandomOrder()
        ->latest()
        ->paginate(24);

        return view('other_store.Top_New_Items', [
            'featuredProducts' => $featuredProducts,
            'total_item'       => count($featuredProducts),
            'newProduct'       => collect($this->newProductsQuery())->shuffle()->take(5),
        ]);
    }

    public function Top_Selling(Request $request)
    {
        $featuredProducts = Product::published([
            'id', 'name', 'category_id', 'sale_price', 'regular_price',
            'discount_type', 'discount_value', 'product_type', 'is_discounted',
        ])
        ->with(['category:id,name,slug', 'media' => $this->mediaQuery(), 'reviews'])
        ->WithTag('TOPSELLING')
        ->withAvg(['reviews' => fn($q) => $q->where('status', 'approved')], 'rating')
        ->inRandomOrder()
        ->latest()
        ->paginate(24);

        return view('other_store.Top_Selling', [
            'featuredProducts' => $featuredProducts,
            'total_item'       => count($featuredProducts),
            'newProduct'       => collect($this->newProductsQuery())->shuffle()->take(5),
        ]);
    }

    public function Top_Rated_Item(Request $request)
    {
        $featuredProducts = Product::published([
            'id', 'name', 'category_id', 'sale_price', 'regular_price',
            'discount_type', 'discount_value', 'product_type', 'is_discounted',
        ])
        ->with(['category:id,name,slug', 'media' => $this->mediaQuery()])
        ->WithTag('TOPRATEDITEMS')
        ->withAvg(['reviews' => fn($q) => $q->where('status', 'approved')], 'rating')
        ->inRandomOrder()
        ->latest()
        ->paginate(24);

        return view('other_store.Top_Rated_Item', [
            'featuredProducts' => $featuredProducts,
            'total_item'       => count($featuredProducts),
            'newProduct'       => collect($this->newProductsQuery())->shuffle()->take(5),
        ]);
    }
}

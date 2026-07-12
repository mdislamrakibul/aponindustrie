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
        return Product::published([
            'id', 'name', 'category_id', 'sale_price',
            'regular_price', 'package_price', 'discount_type', 'discount_value',
            'product_type', 'is_discounted',
        ])
        ->with(['category:id,name,slug', 'media' => $this->mediaQuery()])
        ->withAvg(['reviews' => fn($q) => $q->where('status', 'approved')], 'rating')
        ->latest()
        ->take(5)
        ->get()
        ->toArray();
    }

    public function shop(Request $request)
    {
        $products = Product::where('status', 'PUBLISHED')
            ->with(['category:id,name,slug', 'media' => $this->mediaQuery()])
            ->when($request->discount, fn($q) => $q->where('is_discounted', 1))
            ->orderBy('name', 'asc')
            ->paginate(20)
            ->withQueryString();

        $newProduct = collect($this->newProductsQuery())->shuffle()->take(5);

        return view('product.shop', compact('products', 'newProduct'));
    }

    public function Weekly_Featured(Request $request)
    {
        $featuredProducts = Product::published([
            'id', 'name', 'category_id', 'sale_price', 'regular_price', 'package_price',
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
            'id', 'name', 'category_id', 'sale_price', 'regular_price', 'package_price',
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
            'id', 'name', 'category_id', 'sale_price', 'regular_price', 'package_price',
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
            'id', 'name', 'category_id', 'sale_price', 'regular_price', 'package_price',
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
            'id', 'name', 'category_id', 'sale_price', 'regular_price', 'package_price',
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

    public function searchSuggestions(Request $request)
    {
        $q = trim($request->get('q', ''));

        if ($q === '') {
            return response()->json(['success' => true, 'products' => []]);
        }

        $products = Product::query()
            ->where('status', 'PUBLISHED')
            ->where(function ($w) use ($q) {
                $w->where('name', 'like', "%{$q}%")
                  ->orWhere('sku', 'like', "%{$q}%")
                  ->orWhere('short_description', 'like', "%{$q}%");
            })
            ->with(['category:id,name', 'media' => $this->mediaQuery()])
            ->select('id', 'name', 'category_id', 'sale_price', 'regular_price')
            ->latest()
            ->take(8)
            ->get()
            ->map(function ($prod) {
                $thumb = $prod->media->firstWhere('position', 1) ?? $prod->media->first();

                return [
                    'id'        => $prod->id,
                    'name'      => $prod->name,
                    'thumbnail' => $thumb
                        ? asset($thumb->file_path . $thumb->image_name)
                        : asset('assets/imgs/shop/product-placeholder.png'),
                    'price'     => number_format($prod->sale_price, 2),
                    'url'       => route('Product_Details', [
                        'product_name'     => $prod->name,
                        'category_name'    => optional($prod->category)->name,
                        'auth_expired_key' => 'eyJhbGciOiJFZERTQSIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiYWRtaW4iOnRydWUsImlhdCI6MTUxNjIzOTAyMn0.JkKWCY39IdWEQttmdqR7VdsvT-_QxheW_eb0S5wr_j83ltux_JDUIXs7a3Dtn3xuqzuhetiuJrWIvy5TzimeCg',
                        'category_id'      => optional($prod->category)->id,
                        'product_id'       => $prod->id,
                    ]),
                ];
            });

        return response()->json(['success' => true, 'products' => $products]);
    }

    public function search(Request $request)
    {
        $q = trim($request->get('q', ''));

        $products = Product::query()
            ->where('status', 'PUBLISHED')
            ->when($q !== '', function ($query) use ($q) {
                $query->where(function ($w) use ($q) {
                    $w->where('name', 'like', "%{$q}%")
                      ->orWhere('sku', 'like', "%{$q}%")
                      ->orWhere('short_description', 'like', "%{$q}%");
                });
            })
            ->with(['media' => $this->mediaQuery()])
            ->withAvg(['reviews as reviews_avg_rating' => fn($r) => $r->where('status', 'approved')], 'rating')
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('product.search', compact('products', 'q'));
    }
}

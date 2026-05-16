<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
use App\Models\Media;

class Product extends Model
{   

    use HasFactory;
    protected $table = 'tbl_products';
    protected $casts = [
        'publish_date' => 'datetime',
    ];
    protected $fillable = [
        'name',
        'slug',
        'sku',
        'barcode',
        'category_id',
        'brand_id',
        'short_description',
        'description',
        'sale_price',
        'regular_price',
        'package_price',
        'discount_type',
        'discount_value',
        'is_discounted',
        'stock_quantity',
        'availability',
        'status',
        'minimum_order',
        'product_type',
        'product_adv_type',
        'publish_date',
        'tags',
    ];

    
    public function category()
    {
        // 1st param: The Model name
        // 2nd param: The foreign key in tbl_products
        // 3rd param: The owner key in tbl_categories
        return $this->belongsTo(Category::class);
    }
    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id', 'id');
    }

    // --- SCOPES (For cleaner Controller Queries) ---

    public function scopePublished($query, $data)
    {
        return $query
            ->select($data)
            ->where('status', 'PUBLISHED');
    }

    // --- SCOPES (For cleaner Controller Queries) ---
    public function scopeGetProductByProductId($query, $product_id)
    {
        return $query->where('id', $product_id);
    }




    public function scopeInStock($query)
    {
        return $query->where('availability', 'INSTOCK')
            ->where('stock_quantity', '>', 0);
    }


    // --- ACCESSORS (Calculated Data) ---

    // Get current price (checks if sale price exists)
    public function getActivePriceAttribute()
    {
        return $this->sale_price > 0 ? $this->sale_price : $this->regular_price;
    }

    // Check if product is on sale
    public function getOnSaleAttribute()
    {
        return $this->sale_price > 0 && $this->sale_price < $this->regular_price;
    }


    //Media Pull from Media table
    public function media()
    {
        // 1st param: The Media Model
        // 2nd param: The foreign key in tbl_media (model_id)
        // 3rd param: The local key in tbl_products (id)
        return $this->hasMany(Media::class, 'model_id')
            ->where('image_type', 'PRODUCT')
            ->orderBy('position');
    }


    /**
     * Scope to filter products by a specific JSON tag
     * * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $tag (e.g., 'TOPSELLING')
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithTag($query, $tag)
    {
        // 'product_tags' is the name of your JSON column
        return $query->whereJsonContains('product_adv_type', $tag);
    }


    public function scopeTypeNewProductTag($query, $tag)
    {
        return $query->whereJsonContains('product_type', $tag);
    }


    public function scopeProductType($query, $tag)
    {
        return $query->whereJsonContains('product_type', $tag);
    }


    /**
     * Fetch products by either a specific sub-category or a parent category.
     * * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int|null $subCategoryId
     * @param int|null $categoryId (Parent)
     */
    public function scopeGetProductByLevelOrCategory($query, $subCategoryId = null, $categoryId = null)
    {
        if ($categoryId) {
            // Scenario B: Parent category provided
            // 1. Get all child IDs belonging to this parent
            $childIds = \App\Models\Category::where('parent_id', $categoryId)->pluck('id');

            // dd($childIds->push($categoryId)->unique());

            // 2. Fetch products where their sub_category_id is in that list
            return $query->whereIn('category_id', $childIds->push($categoryId)->unique());
        }


        if ($subCategoryId) {
            /**
             *
             * the category_id in product table is actually sub category id
             *
             */
            return $query->where('category_id', $subCategoryId);
        }

        return $query;
    }

    // A product has many reviews
    public function reviews()
    {
        return $this->hasMany(ProductReview::class);
    }

    // In Product.php model get average ratings
    public function getAverageRating()
    {
        // Use the reviews relationship, filter by approved, and get average of 'rating'
        $avg = $this->reviews()->where('status', 'approved')->avg('rating');

        return $avg ? number_format($avg, 1) : 0;
    }
}

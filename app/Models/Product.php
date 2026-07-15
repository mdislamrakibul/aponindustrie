<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
use App\Models\Media;
use Illuminate\Database\Eloquent\SoftDeletes;
class Product extends Model
{   

    use HasFactory;
    protected $table = 'tbl_products';
    protected $casts = [
        'publish_date'           => 'datetime',
        'additional_info_active' => 'boolean',
    ];

    // total_discount_percent has no backing column — Eloquent only includes
    // accessor-only ("virtual") attributes like this in toArray()/toJson()
    // if they're appended here. is_discounted has a real column but is
    // overridden by an accessor below, so it serializes correctly on its
    // own and doesn't need to be listed.
    protected $appends = [
        'total_discount_percent',
    ];
    protected $fillable = [

        'name',
        'slug',
        'category_id',
        'brand_id',
        'uploader_id',

        'description',
        'short_description',

        'additional_info',
        'additional_info_active',

        'sku',
        'barcode',

        'purchase_price',
        'regular_price',
        'sale_price',

        'discount_type',
        'discount_value',

        'tax_percentage',

        'stock_quantity',
        'minimum_order',

        'package_price',

        'availability',
        'status',

        'product_type',
        'product_adv_type',

        'is_featured',
        'is_discounted',

        'tags',

        'meta_title',
        'meta_description',

        'thumbnail',

        'attributes',

        'view_count',
        'total_sales',

        'publish_date',
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

    // Discount already implied by package_price being below regular_price, as a %
    public function getBaseDiscountPercentAttribute()
    {
        $regular = (float) $this->regular_price;
        $package = (float) $this->package_price;

        if ($regular <= 0 || $package <= 0 || $package >= $regular) {
            return 0.0;
        }

        return round((($regular - $package) / $regular) * 100, 2);
    }

    // Extra discount configured via discount_type/discount_value, as a %
    // (FLAT amounts are converted to a % of regular_price so they can be
    // combined with the base discount below)
    public function getExtraDiscountPercentAttribute()
    {
        $value = (float) $this->discount_value;
        $type  = $this->discount_type;

        if ($value <= 0 || !in_array($type, ['PERCENTAGE', 'FLAT'])) {
            return 0.0;
        }

        if ($type === 'PERCENTAGE') {
            return round($value, 2);
        }

        $regular = (float) $this->regular_price;
        return $regular > 0 ? round(($value / $regular) * 100, 2) : 0.0;
    }

    // Total discount % shown as the storefront offer badge.
    // As of the Inventory Update rework, package_price is saved as the
    // ACTUAL final selling price (regular_price minus the discount_type/
    // discount_value amount already applied) — so the regular-vs-package
    // gap (base_discount_percent) already IS the full discount. Adding
    // extra_discount_percent on top would double-count the same discount.
    public function getTotalDiscountPercentAttribute()
    {
        $total = $this->base_discount_percent;

        // Sanity cap so stacked discounts can never show a silly >95% badge
        return $total > 95 ? 95.0 : round($total, 2);
    }

    // Whether the product has any discount at all — drives whether the
    // offer badge shows on the storefront. Overrides the raw is_discounted
    // DB column (which is never written by any controller) with a value
    // computed live from the actual prices/discount fields.
    public function getIsDiscountedAttribute()
    {
        return $this->total_discount_percent > 0;
    }


    //Media Pull from Media table
    public function media()
    {
        // 1st param: The Media Model
        // 2nd param: The foreign key in tbl_media (model_id)
        // 3rd param: The local key in tbl_products (id)
        return $this->hasMany(Media::class, 'model_id')
            ->where('image_type', 'PRODUCT')
            ->orderBy('position', 'asc');
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

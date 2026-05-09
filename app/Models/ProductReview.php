<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductReview extends Model
{
    use HasFactory;
    protected $table = 'tbl_product_reviews';
    // A review belongs to a user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

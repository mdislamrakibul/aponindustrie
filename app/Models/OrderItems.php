<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItems extends Model
{
    use HasFactory;
    protected $table = 'tbl_order_items';
    // Add order_id here
    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'price',
        'total'
        // add any other columns you are saving here
    ];
}

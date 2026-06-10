<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $table = 'tbl_orders';
    protected $fillable = [
        'user_id',
        'order_number',
        'total_amount',
        'tax_amount',
        'shipping_amount',
        'payment_method',
        'payment_status',
        'order_status',
        'transaction_id',
        'notes',
    ];
    

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // A product has many reviews
    public function order_items()
    {
        return $this->hasMany(OrderItems::class);
    }

    public function order_address()
    {
        return $this->hasOne(OrderAddress::class);
    }
}

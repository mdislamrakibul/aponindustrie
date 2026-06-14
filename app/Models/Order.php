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
        'payer_number',
        'payment_screenshot',
        'notes',
        'accepted_by',
    ];

    /**
     * order_status values:
     *   PENDING    → newly placed, waiting for admin review (shown in notification panel)
     *   PROCESSING → accepted by admin (shown in order management table)
     *   SHIPPED    → dispatched
     *   DELIVERED  → completed
     *   CANCELLED  → rejected or cancelled
     */

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function order_items()
    {
        return $this->hasMany(OrderItems::class);
    }

    public function order_address()
    {
        return $this->hasOne(OrderAddress::class);
    }

    public function acceptedBy()
    {
        return $this->belongsTo(User::class, 'accepted_by');
    }
}

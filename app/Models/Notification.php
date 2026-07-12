<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = [
        'title',
        'message',
        'target_role',
        'triggered_by_user_id',
        'triggered_by_name',
        'is_read',
    ];

    protected $casts = [
        'is_read' => 'boolean',
    ];
}

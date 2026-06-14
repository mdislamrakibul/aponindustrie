<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    protected $table = 'tbl_banners';

    protected $fillable = [
        'type', 'slot', 'label', 'image_path',
        'rec_width', 'rec_height', 'sort_order',
        'is_locked', 'is_active',
        'text_top', 'text_title', 'text_highlight', 'text_sub',
    ];

    protected $casts = [
        'is_locked' => 'boolean',
        'is_active' => 'boolean',
    ];
}

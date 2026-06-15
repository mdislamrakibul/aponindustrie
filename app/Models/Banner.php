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
        'slide_top', 'slide_title', 'slide_highlight', 'slide_desc',
        'hide_text',
    ];

    protected $casts = [
        'is_locked'  => 'boolean',
        'is_active'  => 'boolean',
        'hide_text'  => 'boolean',
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    protected $table = 'tbl_media';

    protected $fillable = [
        'title',
        'model_id',
        'file_path',
        'image_name',
        'file_type',
        'image_type',
        'position',
        'is_active',
        'device_type',
    ];
}
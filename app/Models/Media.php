<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    use HasFactory;

    protected $table = 'tbl_media';

    protected $guarded = [];

    public function product()
    {
        return $this->belongsTo(Product::class, 'model_id');
    }
}
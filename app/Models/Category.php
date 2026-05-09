<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'tbl_categories';

    protected $primaryKey = 'id';

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id', 'id')
            ->select(['id', 'name', 'slug', 'parent_id', 'description']);
    }

    // Recursive relationship to get all sub-children (infinitely)
    public function childrenRecursive()
    {
        return $this->children()->with('childrenRecursive');
    }
}

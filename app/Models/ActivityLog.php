<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    protected $fillable = [
        'user_id',
        'performed_by',
        'module',
        'action',
        'item',
        'details',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($log) {
            if (empty($log->performed_by)) {
                $log->performed_by = session('user_name');
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(
            User::class,
            'user_id'
        );
    }
}
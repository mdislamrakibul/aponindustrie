<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Login extends Model
{
    protected $table = 'tbl_info_login';

    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'name',
        'email',
        'address',
        'password',
        'confirmPassword',
        'phone',
        'role',
        'status',
        'avatar',
        'remember_token',
        'last_login_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'login_id', 'id');
    }
}
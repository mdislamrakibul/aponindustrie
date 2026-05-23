<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoginUser extends Model
{
    protected $table = 'tbl_info_login';

    protected $fillable = [
        'user_id',
        'name',
        'email',
        'password',
        'phone',
        'address',
        'role',
        'status',
        'last_login_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
}
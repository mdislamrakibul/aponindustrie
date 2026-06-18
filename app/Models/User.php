<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    const ROLE_ADMIN = 'admin';
    const ROLE_CUSTOMER = 'customer';
    const ROLE_VENDOR = 'vendor';

    protected $table = 'tbl_info_user';

    protected $fillable = [
        'first_name',
        'last_name',
        'mobile_no',
        'email',
        'password',
        'role',
        'status',
        'salary',
        'profile_photo'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'password' => 'hashed',
    ];
    public function login(): BelongsTo
    {
        return $this->belongsTo(Login::class, 'login_id', 'id');
    }

    public function isAdmin()
    {
        return $this->role === self::ROLE_ADMIN;
    }
    public function isVendor()
    {
        return $this->role === self::ROLE_VENDOR;
    }
    public function isCustomer()
    {
        return $this->role === self::ROLE_CUSTOMER;
    }
}
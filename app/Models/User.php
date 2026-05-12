<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;








class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    const ROLE_ADMIN = 'admin';
    const ROLE_CUSTOMER = 'customer';
    const ROLE_BRANDER = 'brander';

    protected $table = 'tbl_info_user';

    protected $fillable = [
        'first_name',
        'last_name',
        'mobile_no',
        'password'
        //'role'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'password' => 'hashed',
    ];
    public function isAdmin()
    {
        return $this->role === self::ROLE_ADMIN;
    }

    public function isCustomer()
    {
        return $this->role === self::ROLE_CUSTOMER;
    }

    public function isBrander()
    {
        return $this->role === self::ROLE_BRANDER;
    }
}
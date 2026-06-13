<?php

namespace App\Observers;

use App\Models\Login;
use App\Models\User;

class LoginObserver
{
    public function updated(Login $login): void
    {
        // tbl_info_user.login_id = tbl_info_login.id
        $user = User::where('login_id', $login->id)->first();
        if (!$user) {
            return;
        }

        $patch = [];

        if ($login->wasChanged('first_name')) {
            $patch['first_name'] = $login->first_name;
        }
        if ($login->wasChanged('last_name')) {
            $patch['last_name'] = $login->last_name;
        }
        if ($login->wasChanged('phone')) {
            $patch['mobile_no'] = $login->phone;
        }
        if ($login->wasChanged('role')) {
            $patch['role'] = $login->role;
        }
        if ($login->wasChanged('status')) {
            $patch['status'] = $login->status;
        }

        if (!empty($patch)) {
            $user->fill($patch)->saveQuietly();
        }
    }
}

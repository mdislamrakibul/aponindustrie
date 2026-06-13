<?php

namespace App\Observers;

use App\Models\Login;
use App\Models\User;

class UserObserver
{
    public function updated(User $user): void
    {
        // tbl_info_user.login_id → tbl_info_login.id
        $login = Login::find($user->login_id);
        if (!$login) {
            return;
        }

        $patch = [];

        if ($user->wasChanged('first_name')) {
            $patch['first_name'] = $user->first_name;
        }
        if ($user->wasChanged('last_name')) {
            $patch['last_name'] = $user->last_name;
        }
        if ($user->wasChanged('first_name') || $user->wasChanged('last_name')) {
            $patch['name'] = trim($user->first_name . ' ' . $user->last_name);
        }
        if ($user->wasChanged('mobile_no')) {
            $patch['phone'] = $user->mobile_no;
        }
        if ($user->wasChanged('role')) {
            $patch['role'] = strtolower($user->role);
        }
        if ($user->wasChanged('status')) {
            $patch['status'] = $user->status;
        }

        if (!empty($patch)) {
            $login->fill($patch)->saveQuietly();
        }
    }
}

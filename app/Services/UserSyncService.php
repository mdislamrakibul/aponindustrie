<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class UserSyncService
{
    public static function syncToUserTable($loginUser)
    {
        $nameParts = explode(' ', $loginUser->name, 2);

        $firstName = $nameParts[0] ?? '';

        $lastName = $nameParts[1] ?? '';

        DB::table('tbl_info_user')->updateOrInsert(

            [
                'mobile_no' => $loginUser->phone
            ],

            [
                'login_id' => $loginUser->id,

                'first_name' => $firstName,

                'last_name' => $lastName,

                'mobile_no' => $loginUser->phone,

                'phone' => $loginUser->phone,

                'password' => $loginUser->password,

                'role' => strtolower($loginUser->role),

                'status' => strtolower($loginUser->status),

                'updated_at' => now(),

                'created_at' => now(),
            ]
        );
    }
}
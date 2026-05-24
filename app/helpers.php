<?php

use App\Models\ActivityLog;

if (!function_exists('activityLog')) {

    function activityLog(
        $module,
        $action,
        $description
    ) {

        ActivityLog::create([

            'user_id' => session('user_id'),

            'module' => $module,

            'action' => $action,

            'description' => $description,

            'ip_address' => request()->ip(),

        ]);
    }
}
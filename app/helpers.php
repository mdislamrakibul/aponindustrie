<?php

use App\Models\ActivityLog;

if (!function_exists('sliders')) {
    function sliders()
    {
        try {
            return \App\Models\Banner::where('type', 'SLIDER')
                ->where('is_active', 1)
                ->orderBy('sort_order')
                ->get();
        } catch (\Throwable $e) {
            return collect();
        }
    }
}

if (!function_exists('banner')) {
    function banner($slot, $fallback = null)
    {
        try {
            $row = \App\Models\Banner::where('slot', $slot)->where('is_active', 1)->first();
        } catch (\Throwable $e) {
            $row = null;
        }
        if ($row && $row->image_path) {
            return asset($row->image_path);
        }
        return $fallback ? asset($fallback) : asset('admin/no-image.png');
    }
}

if (!function_exists('activityLog')) {

    function activityLog($module, $action, $item, $details = null)
    {
        ActivityLog::create([
            'user_id' => session('user_id'),
            'module'  => $module,
            'action'  => $action,
            'item'    => $item,
            'details' => $details,
        ]);
    }
}
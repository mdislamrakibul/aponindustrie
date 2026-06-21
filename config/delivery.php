<?php

return [
    // ── Apply-Zone options (order management table) ──
    'dhaka_city'             => 75,    // In Dhaka City
    'outside_dhaka_city'     => 110,   // Outside Dhaka City
    'outside_dhaka_district' => 135,   // Outside Dhaka District
    // 'free' zone always resolves to 0 — no key needed

    // ── Legacy keys used by Add-Order modal (storeManual) ──
    'inside_dhaka'   => 75,    // kept for backwards-compat
    'outside_dhaka'  => 135,   // kept for backwards-compat
    'free_threshold' => 1000,
];

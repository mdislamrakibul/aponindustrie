<?php
    use App\Models\User;
    use Illuminate\Support\Facades\Hash;

    User::create([
        'name' => 'Super Admin',
        'email' => 'admin@gmail.com',
        'password' => Hash::make('123456'),
        'role' => 'admin',
    ]);

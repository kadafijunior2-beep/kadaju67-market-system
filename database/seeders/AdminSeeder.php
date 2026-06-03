<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'System Admin',
            'email' => 'admin@kadaju67.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'phone' => '0712345678',
            'is_active' => true,
        ]);

        User::create([
            'name' => 'Manager User',
            'email' => 'manager@kadaju67.com',
            'password' => Hash::make('password'),
            'role' => 'manager',
            'phone' => '0712345679',
            'is_active' => true,
        ]);

        User::create([
            'name' => 'Staff User',
            'email' => 'staff@kadaju67.com',
            'password' => Hash::make('password'),
            'role' => 'staff',
            'phone' => '0712345680',
            'is_active' => true,
        ]);
    }
}

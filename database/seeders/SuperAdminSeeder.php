<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name'             => 'Super Admin',
                'password'         => Hash::make('admin123'),
                'role'             => User::ROLE_SUPER_ADMIN,
                'is_admin'         => true,
                'email_verified_at' => now(),
            ]
        );
    }
}

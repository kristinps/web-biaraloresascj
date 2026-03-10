<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserDemoSeeder extends Seeder
{
    /**
     * User demo untuk testing/login.
     * Email: user@gmail.com | Password: user123
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'user@gmail.com'],
            [
                'name'              => 'User Demo',
                'password'          => Hash::make('user123'),
                'role'              => User::ROLE_USER,
                'is_admin'          => false,
                'email_verified_at' => now(),
            ]
        );
    }
}

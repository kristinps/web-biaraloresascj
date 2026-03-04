<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@biaraloresa.my.id'],
            [
                'name'     => 'Administrator',
                'email'    => 'admin@biaraloresa.my.id',
                'password' => Hash::make('Admin@Loresa2026'),
                'is_admin' => true,
                'email_verified_at' => now(),
            ]
        );
    }
}

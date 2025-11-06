<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin/demo accounts
        User::updateOrCreate(
            ['email' => 'admin@example.com'],
            ['name' => 'Admin', 'password' => Hash::make('password')]
        );
        User::updateOrCreate(
            ['email' => 'user@example.com'],
            ['name' => 'Demo User', 'password' => Hash::make('password')]
        );

        // Additional fake users
        User::factory()->count(8)->create();
    }
}


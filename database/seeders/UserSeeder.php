<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin/demo accounts
        $admin = User::updateOrCreate(
            ['email' => 'admin@example.com'],
            ['name' => 'Admin', 'password' => Hash::make('password')]
        );
        $admin->assignRole('admin');

        $user = User::updateOrCreate(
            ['email' => 'user@example.com'],
            ['name' => 'Demo User', 'password' => Hash::make('password')]
        );
        $user->assignRole('user');

        // Additional fake users
        User::factory()->count(8)->create();
    }
}


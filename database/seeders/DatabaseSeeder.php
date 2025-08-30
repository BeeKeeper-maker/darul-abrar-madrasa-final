<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create admin users
        User::updateOrCreate(
            ['email' => 'admin@darulabrar.bd'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'is_active' => true,
            ]
        );

        User::updateOrCreate(
            ['email' => 'admin@darulabrar.com'],
            [
                'name' => 'System Admin',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'is_active' => true,
            ]
        );

        // Create a teacher user
        User::updateOrCreate(
            ['email' => 'teacher@darulabrar.bd'],
            [
                'name' => 'Test Teacher',
                'password' => Hash::make('password123'),
                'role' => 'teacher',
                'is_active' => true,
            ]
        );

        // Create a student user
        User::updateOrCreate(
            ['email' => 'student@darulabrar.bd'],
            [
                'name' => 'Test Student',
                'password' => Hash::make('password123'),
                'role' => 'student',
                'is_active' => true,
            ]
        );

        // Create a staff user (guardian functionality)
        User::updateOrCreate(
            ['email' => 'guardian@darulabrar.bd'],
            [
                'name' => 'Test Guardian',
                'password' => Hash::make('password123'),
                'role' => 'staff',
                'is_active' => true,
            ]
        );
    }
}

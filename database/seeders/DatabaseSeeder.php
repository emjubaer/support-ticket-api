<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::updateOrCreate([
            'email' => 'customer@example.com',
        ], [
            'name' => 'Customer User',
            'password' => 'password',
            'role' => UserRole::Customer,
        ]);

        User::updateOrCreate([
            'email' => 'agent@example.com',
        ], [
            'name' => 'Agent',
            'password' => 'password',
            'role' => UserRole::Agent,
        ]);

        User::updateOrCreate([
            'email' => 'admin@example.com',
        ], [
            'name' => 'Admin User',
            'password' => 'password',
            'role' => UserRole::Admin,
        ]);



        // User::create([
        //     'email' => 'test@example.com',
        //     'name' => 'Test User',
        //     'password' => 'password',
        //     'role' => UserRole::Customer,
        // ]);
    }
}

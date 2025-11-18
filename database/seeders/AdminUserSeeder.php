<?php

namespace Database\Seeders;

use App\Models\Pengguna;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        Pengguna::create([
            'name' => 'Admin MOVR',
            'email' => 'admin@movr.com',
            'password' => Hash::make('password123'), // You can change this default password
            'role' => 'admin',
        ]);
    }
}
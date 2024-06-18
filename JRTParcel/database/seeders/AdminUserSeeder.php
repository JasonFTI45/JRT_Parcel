<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Admin',
            'email' => 'adminjrt@gmail.com',
            'password' => Hash::make('Admin123'), // Use a secure password in production
            'role' => 'admin',
        ]);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Karyawan;

class KaryawanUserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'user' => [
                    'name' => 'Jason Rianto',
                    'email' => 'jasonri@gmail.com',
                    'password' => Hash::make('Riri123'), // Use a secure password in production
                    'role' => 'karyawan',
                    'karyawan_id' => 1, // This might need to be dynamically set if auto-increment is not used
                ],
                'karyawan' => [
                    'nama' => 'Jason Rianto',
                    'nomor_telepon' => '081234567890',
                    'email' => 'jasonri@gmail.com',
                ],
            ],

            [
                'user' => [
                    'name' => 'Diana Putri',
                    'email' => 'dianaputri@gmail.com',
                    'password' => Hash::make('Diana456'), // Use a secure password in production
                    'role' => 'karyawan',
                    'karyawan_id' => 2,
                ],
                'karyawan' => [
                    'nama' => 'Diana Putri',
                    'nomor_telepon' => '081234567891',
                    'email' => 'dianaputri@gmail.com',
                ],
            ],

            [
                'user' => [
                    'name' => 'Rahmat Hidayat',
                    'email' => 'rahmathidayat@gmail.com',
                    'password' => Hash::make('Rahmat789'), // Use a secure password in production
                    'role' => 'karyawan',
                    'karyawan_id' => 3,
                ],
                'karyawan' => [
                    'nama' => 'Rahmat Hidayat',
                    'nomor_telepon' => '081234567892',
                    'email' => 'rahmathidayat@gmail.com',
                ],
            ],
        ];
    
        foreach ($users as $data) {
            $karyawan = Karyawan::create($data['karyawan']);
            
            // If karyawan_id is auto-incremented and should be dynamically set
            $data['user']['karyawan_id'] = $karyawan->id;
    
            User::create($data['user']);
        }  


    }
}

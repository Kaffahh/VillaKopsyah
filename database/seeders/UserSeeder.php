<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
    $users = [
        [
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('11111111'),
            'role' => 'admin',
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'name' => 'Valen',
            'email' => 'valen@gmail.com',
            'password' => bcrypt('password'),
            'role' => 'pemilik_villa',
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'name' => 'Pemilik Villa 1',
            'email' => 'pemilik1@gmail.com',
            'password' => bcrypt('password'),
            'role' => 'pemilik_villa',
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'name' => 'Petugas',
            'email' => 'petugas@gmail.com',
            'password' => bcrypt('password'),
            'role' => 'petugas',
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'name' => 'Customers',
            'email' => 'customers@gmail.com',
            'password' => bcrypt('password'),
            'role' => 'customers',
            'created_at' => now(),
            'updated_at' => now(),
        ],
    ];

    User::insert($users);
    }
}

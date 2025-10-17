<?php

namespace Database\Seeders;

use App\Models\User; // Pastikan ini adalah model User Anda
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Membuat satu user admin
        User::create([
            'username' => 'admin',
            'email' => 'admin@kelurahantipulu.com',
            // PENTING: Password harus di-hash menggunakan bcrypt()
            // agar bisa digunakan untuk login.
            'password' => bcrypt('pass1234'),
        ]);
    }
}
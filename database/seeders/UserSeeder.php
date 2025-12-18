<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin
        \App\Models\User::create([
            'name' => 'Admin KampuFix',
            'email' => 'admin@kampufix.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        // Teknisi
        \App\Models\User::create([
            'name' => 'Teknisi Budi',
            'email' => 'teknisi@kampufix.com',
            'password' => bcrypt('password'),
            'role' => 'teknisi',
        ]);

        // Mahasiswa
        \App\Models\User::create([
            'name' => 'Mahasiswa Test',
            'email' => 'mahasiswa@kampufix.com',
            'password' => bcrypt('password'),
            'role' => 'mahasiswa',
        ]);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin Kepala',
            'email' => 'admin@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('admin123'),
            'nrp' => '12345678',
            'pangkat' => 'AKBP',
            'jabatan' => 'Kepala Bidang TIK',
            'sub_bidang' => '-',
            'role' => 'KEPALA BIDANG',
            'is_active' => true,
        ]);

        // Menambahkan beberapa user dummy untuk testing
        User::create([
            'name' => 'Admin Kasubid',
            'email' => 'kasubid@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('kasubid123'),
            'nrp' => '87654321',
            'pangkat' => 'KOMPOL',
            'jabatan' => 'Kepala Sub Bidang',
            'sub_bidang' => 'SUBBID TEKINFO',
            'role' => 'KEPALA SUB BIDANG',
            'is_active' => true,
        ]);

        User::create([
            'name' => 'Anggota 1',
            'email' => 'anggota1@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('anggota123'),
            'nrp' => '11223344',
            'pangkat' => 'BRIPTU',
            'jabatan' => 'BANUM',
            'sub_bidang' => 'SUBBID TEKINFO',
            'role' => 'ANGGOTA',
            'is_active' => true,
        ]);
    }
}
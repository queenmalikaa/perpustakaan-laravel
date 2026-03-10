<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class PetugasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'username' => 'petugas',
            'nama_lengkap' => 'Petugas',
            'alamat' => 'Jl. Petugas No. 2',
            'email' => 'petugas@gmail.com',
            'password' => bcrypt('petugas123'),
            'role' => 'petugas',
        ]);
    }
}

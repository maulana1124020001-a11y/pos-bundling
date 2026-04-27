<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'nama' => 'Administrator',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('123'),
                'role_id' => 1, // Sesuaikan dengan ID Admin di tabel roles
                
            ],
            [
                'nama' => 'Kasir Toko',
                'email' => 'kasir@gmail.com',
                'password' => Hash::make('123'),
                'role_id' => 2, // Sesuaikan dengan ID Kasir di tabel roles
               
            ]
        ]);
    }
}
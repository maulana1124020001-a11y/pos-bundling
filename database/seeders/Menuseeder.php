<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Menu;

class Menuseeder extends Seeder
{
    public function run(): void
    {
        Menu::create([
            'kategori_id' => 1,
            'nama' => 'Nasi Goreng',
            'modal' => 10000,
            'harga' => 15000,
            'status' => 'tersedia',
            'gambar' => '1.jpeg',
        ]);

        Menu::create([
            'kategori_id' => 1,
            'nama' => 'Mie Ayam',
            'modal' => 10000,
            'harga' => 15000,
            'status' => 'tersedia',
            'gambar' => '6.jpeg',
        ]);

        Menu::create([
            'kategori_id' => 2,
            'nama' => 'Teh',
            'modal' => 2000,
            'harga' => 5000,
            'status' => 'tersedia',
            'gambar' => '2.jpeg',
        ]);

        Menu::create([
            'kategori_id' => 2,
            'nama' => 'Latte',
            'modal' => 5000,
            'harga' => 10000,
            'status' => 'tersedia',
            'gambar' => '3.jpeg',
        ]);

        Menu::create([
            'kategori_id' => 2,
            'nama' => 'choco',
            'modal' => 5000,
            'harga' => 10000,
            'status' => 'tersedia',
            'gambar' => 'choco.jpeg',
        ]);

        Menu::create([
            'kategori_id' => 2,
            'nama' => ' Matcha Latte',
            'modal' => 5000,
            'harga' => 10000,
            'status' => 'tersedia',
            'gambar' => 'matcha_latte.jpeg',
        ]);

        Menu::create([
            'kategori_id' => 1,
            'nama' => 'Mie Goreng',
            'modal' => 10000,
            'harga' => 13000,
            'status' => 'tersedia',
            'gambar' => '7.jpeg',
        ]);

        Menu::create([
            'kategori_id' => 1,
            'nama' => 'Bakso',
            'modal' => 10000,
            'harga' => 15000,
            'status' => 'tersedia',
            'gambar' => '8.jpeg',
        ]);

        Menu::create([
            'kategori_id' => 3,
            'nama' => 'Tahu',
            'modal' => 5000,
            'harga' => 10000,
            'status' => 'tersedia',
            'gambar' => 'tahu.jpeg',
        ]);

        Menu::create([
            'kategori_id' => 3,
            'nama' => 'Kentang',
            'modal' => 7000,
            'harga' => 12000,
            'status' => 'tersedia',
            'gambar' => 'kentang.jpeg',
        ]);

        Menu::create([
            'kategori_id' => 3,
            'nama' => 'Onion',
            'modal' => 5000,
            'harga' => 10000,
            'status' => 'tersedia',
            'gambar' => 'onion.jpeg',
        ]);
    }
}

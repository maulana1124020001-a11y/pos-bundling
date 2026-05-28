<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Transaksi;
use App\Models\TransaksiDetail;
use App\Models\Menu;
use App\Models\User;
use Carbon\Carbon;

class TransaksiDummySeeder extends Seeder
{
    public function run(): void
    {
        $menus = Menu::pluck('harga', 'id')->toArray();
        $idMenus = array_keys($menus);
        $user = User::first();

        if (count($idMenus) < 4) {
            $this->command->error('Isi minimal 4 data menu terlebih dahulu di database agar simulasi berjalan baik.');
            return;
        }

        if (!$user) {
            $this->command->error('Tabel users masih kosong! Buat minimal 1 user terlebih dahulu.');
            return;
        }

        // Hapus data transaksi lama agar bersih dan tidak menumpuk data acak yang dulu
        TransaksiDetail::truncate();
        Transaksi::whereNotNull('id')->delete();

        $this->command->info('Sedang membuat data dummy dengan pola transaksi terencana...');

        $jumlahTransaksi = 500;

        // 🌟 SETTING POLA ID MENU (Silakan sesuaikan ID-nya dengan yang ada di database Anda)
        $menuUtamaA = $idMenus[0]; // Contoh: ID 1 (Kopi)
        $menuPendampingA = $idMenus[1]; // Contoh: ID 2 (Donat)

        $menuUtamaB = $idMenus[2]; // Contoh: ID 3 (Burger)
        $menuPendampingB = $idMenus[3]; // Contoh: ID 4 (Kentang)

        for ($i = 0; $i < $jumlahTransaksi; $i++) {
            
            $tanggalAcak = Carbon::now()->subDays(rand(0, 365))->subHours(rand(0, 23))->subMinutes(rand(0, 59));

            // Menentukan daftar menu yang dibeli untuk struk ini
            $menuTerpilih = [];

            // 🎲 Buat skenario berdasarkan probabilitas acak (Persentase Tren)
            $chance = rand(1, 100);

            if ($chance <= 40) {
                // 🚀 POLA 1: 40% Pelanggan membeli paket kombinasi Kopi + Donat sekaligus
                $menuTerpilih[] = $menuUtamaA;
                $menuTerpilih[] = $menuPendampingA;
                
                // Selipkan 1 menu acak lain sebagai variasi (opsional)
                if (rand(0, 1)) { $menuTerpilih[] = collect($idMenus)->except([$menuUtamaA, $menuPendampingA])->random(); }

            } elseif ($chance <= 75) {
                // 🚀 POLA 2: 35% Pelanggan membeli paket kombinasi Burger + Kentang sekaligus
                $menuTerpilih[] = $menuUtamaB;
                $menuTerpilih[] = $menuPendampingB;

            } else {
                // 🎲 SISANYA: 25% Pelanggan membeli menu benar-benar acak (pembelian normal)
                $jumlahMenuDibeli = rand(1, 3);
                $acak = array_rand(array_flip($idMenus), $jumlahMenuDibeli);
                $menuTerpilih = is_array($acak) ? $acak : [$acak];
            }

            // Hilangkan duplikasi ID jika ada menu yang tidak sengaja tabrakan
            $menuTerpilih = array_unique($menuTerpilih);

            // Hitung detail item & total_harga
            $detailItems = [];
            $totalHarga = 0;

            foreach ($menuTerpilih as $menuId) {
                $qty = rand(1, 2);
                $hargaAsli = $menus[$menuId] ?? 0;
                $subtotal = $hargaAsli * $qty;
                $totalHarga += $subtotal;

                $detailItems[] = [
                    'menu_id' => $menuId,
                    'jumlah' => $qty,
                    'harga' => $hargaAsli,
                    'subtotal' => $subtotal
                ];
            }

            // Kalkulasi pembayaran standar
            if ($totalHarga <= 20000) { $uangBayar = 20000; }
            elseif ($totalHarga <= 50000) { $uangBayar = 50000; }
            else { $uangBayar = ceil($totalHarga / 50000) * 50000; }
            $kembalian = $uangBayar - $totalHarga;

            // 1. Simpan Master Transaksi
            $transaksi = Transaksi::create([
                'user_id' => $user->id,
                'total_harga' => $totalHarga,
                'uang_bayar' => $uangBayar,
                'kembalian' => $kembalian,
                'status' => 'selesai',
                'waktu' => $tanggalAcak,
                'created_at' => $tanggalAcak,
                'updated_at' => $tanggalAcak,
            ]);

            // 2. Simpan Detail Transaksi
            foreach ($detailItems as $item) {
                TransaksiDetail::create([
                    'transaksi_id' => $transaksi->id,
                    'menu_id' => $item['menu_id'],
                    'jumlah' => $item['jumlah'],
                    'harga' => $item['harga'],
                    'subtotal' => $item['subtotal'],
                ]);
            }
        }

        $this->command->info("Sukses! 500 data dummy berpola berhasil diperbarui.");
    }
}

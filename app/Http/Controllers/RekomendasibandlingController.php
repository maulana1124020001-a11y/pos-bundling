<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\TransaksiDetail;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Menu;
use App\Models\Bundling; // 🌟 TAMBAHKAN INI DI ATAS

class RekomendasibandlingController extends Controller
{
    public function index()
    {
        $totalTransaksi = Transaksi::where('waktu', '>=', now()->subYears(1))->count();

        if ($totalTransaksi <= 300) { $minSupport = 0.01; }
        else if ($totalTransaksi <= 500) { $minSupport = 0.08; }
        else if ($totalTransaksi <= 1000) { $minSupport = 0.10; }
        else if ($totalTransaksi <= 5000) { $minSupport = 0.12; }
        else { $minSupport = 0.15; }

        $minSupportCount = ($totalTransaksi * $minSupport);

        $support1itemset = TransaksiDetail::selectRaw('menu_id, COUNT(*) as total_support')
            ->whereHas('transaksi', function ($query) {
                $query->where('waktu', '>=', now()->subYears(1));
            })->groupBy('menu_id')
            ->havingRaw('COUNT(*) >= ?', [$minSupportCount])
            ->pluck('total_support', 'menu_id');

        $idMenuLolos = array_keys($support1itemset->toArray());
        
        $kombinasi = [];
        $jumlah = count($idMenuLolos);

        for ($i = 0; $i < $jumlah; $i++) {
            for ($j = $i + 1; $j < $jumlah; $j++) {
                $kombinasi[] = [$idMenuLolos[$i], $idMenuLolos[$j]];
            }
        }

        $hasilFrequent2Itemset = [];
        foreach ($kombinasi as $itemset) {
            $jumlahMuncul = TransaksiDetail::select('transaksi_id')
                ->whereIn('menu_id', $itemset)
                ->whereHas('transaksi', function ($query) {
                    $query->where('waktu', '>=', now()->subYear());
                })
                ->groupBy('transaksi_id')
                ->havingRaw('COUNT(DISTINCT menu_id) = 2')
                ->count();

            if ($jumlahMuncul >= $minSupportCount) {
                $hasilFrequent2Itemset[] = [
                    'itemset' => $itemset,
                    'support' => $jumlahMuncul
                ];
            }
        }

        $minimumConfidence = 60; 
        $associationRules = [];
        $namaMenu = Menu::whereIn('id', $idMenuLolos)->pluck('nama', 'id');

        foreach ($hasilFrequent2Itemset as $data) {
            $itemA = $data['itemset'][0];
            $itemB = $data['itemset'][1];
            $supportAB = $data['support'];

            $namaA = $namaMenu[$itemA] ?? "Menu ID $itemA";
            $namaB = $namaMenu[$itemB] ?? "Menu ID $itemB";

            // RULE A -> B
            $confidenceAtoB = ($supportAB / $support1itemset[$itemA]) * 100;
            if ($confidenceAtoB >= $minimumConfidence) {
                $supportB = $support1itemset[$itemB] / $totalTransaksi;
                $lift = ($confidenceAtoB / 100) / $supportB;

                $associationRules[] = [
                    'rule' => "$namaA -> $namaB",
                    'item_a_id' => $itemA, // 🌟 DISIMPAN UNTUK BLADE
                    'item_b_id' => $itemB, // 🌟 DISIMPAN UNTUK BLADE
                    'support' => $supportAB,
                    'confidence' => round($confidenceAtoB, 2),
                    'lift' => round($lift, 2)
                ];
            }

            // RULE B -> A
            $confidenceBtoA = ($supportAB / $support1itemset[$itemB]) * 100;
            if ($confidenceBtoA >= $minimumConfidence) {
                $supportA = $support1itemset[$itemA] / $totalTransaksi;
                $lift = ($confidenceBtoA / 100) / $supportA;

                $associationRules[] = [
                    'rule' => "$namaB -> $namaA",
                    'item_a_id' => $itemB, // 🌟 DISIMPAN UNTUK BLADE
                    'item_b_id' => $itemA, // 🌟 DISIMPAN UNTUK BLADE
                    'support' => $supportAB,
                    'confidence' => round($confidenceBtoA, 2),
                    'lift' => round($lift, 2)
                ];
            }
        }

        $associationRules = collect($associationRules)->sortByDesc('lift')->sortByDesc('confidence')->values()->toArray();

        return view('rekomendasi.index', compact('totalTransaksi', 'minSupport', 'minSupportCount', 'support1itemset', 'idMenuLolos', 'kombinasi', 'hasilFrequent2Itemset', 'associationRules'));
    }

    // 🌟 FUNGSI BARU DI BAWAH INI UNTUK MENYIMPAN DATA BUNDLING
   public function simpanBundling(Request $request)
{
    $request->validate([
        'nama_bundling' => 'required|string|max:255',
        'menu_a_id' => 'required',
        'menu_b_id' => 'required',
    ]);

    // 1. Simpan relasi ke tabel bundlings
    Bundling::create([
        'nama_bundling' => $request->nama_bundling,
        'menu_a_id' => $request->menu_a_id,
        'menu_b_id' => $request->menu_b_id,
    ]);

    // Ambil data Menu A untuk menyontek nilai kategori, gambar, modal, dan statusnya
    $menuA = Menu::find($request->menu_a_id);

    // 2. Simpan sebagai Menu baru ke tabel menus sesuai isi $fillable Anda
    Menu::create([
        'kategori_id' => $menuA ? $menuA->kategori_id : 1, // Ikut kategori Menu A
        'nama'        => $request->nama_bundling,          // Nama paket bundling
        'gambar'      => $menuA ? $menuA->gambar : null,   // Ikut gambar Menu A (atau kosongi)
        'modal'       => 0,                                // Nilai modal awal paket
        'harga'       => 0,                                // Nilai jual awal paket
        'status'      => $menuA ? $menuA->status : 'aktif',// Ikut status Menu A (misal: aktif/tersedia)
    ]);

    return redirect()->back()->with('success', 'Bundling berhasil disimpan dan didaftarkan ke Menu!');
}
}
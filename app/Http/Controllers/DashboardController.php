<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Transaksi;
use App\Models\TransaksiDetail;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // =========================
        // WAKTU BULAN INI
        // =========================

        $awalBulan = Carbon::parse('2026-06-01')->startOfMonth();
$akhirBulan = Carbon::parse('2026-06-01')->endOfMonth();

        // =========================
        // CARD
        // =========================

        // jumlah menu
        $jumlahMenu = Menu::count();

        // jumlah transaksi bulan ini
        $jumlahTransaksi = Transaksi::whereBetween('waktu', [
            $awalBulan,
            $akhirBulan
        ])->count();

        // pendapatan keseluruhan
     $totalPendapatan = Transaksi::whereBetween('waktu', [
    $awalBulan,
    $akhirBulan
])->sum('total_harga');

        // modal bulan ini
        $totalModal = TransaksiDetail::with('menu')
            ->whereHas('transaksi', function ($query) use ($awalBulan, $akhirBulan) {
                $query->whereBetween('waktu', [
                    $awalBulan,
                    $akhirBulan
                ]);
            })
            ->get()
            ->sum(function ($detail) {
                return $detail->menu->modal * $detail->jumlah;
            });

        // pendapatan bulan ini
        $pendapatanBulanIni = Transaksi::whereBetween('waktu', [
            $awalBulan,
            $akhirBulan
        ])->sum('total_harga');

        // keuntungan bersih bulan ini
        $keuntunganBersih = $pendapatanBulanIni - $totalModal;

        return view('dashboard.index', compact(
            'jumlahMenu',
            'jumlahTransaksi',
            'totalPendapatan',
            'totalModal',
            'keuntunganBersih'
        ));
    }
}
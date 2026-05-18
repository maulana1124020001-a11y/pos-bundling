<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\TransaksiDetail;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // =========================
        // CARD
        // =========================

        $totalTransaksi = Transaksi::count();
        //ambil tgl skrg

        $totalPendapatan = Transaksi::sum('total_harga');

        $totalModal = TransaksiDetail::with('menu')->get()->sum(function ($detail) {
            return $detail->menu->modal * $detail->jumlah;
        });

        $keuntungan = $totalPendapatan - $totalModal;

        // =========================
        // TRANSAKSI TERBARU
        // =========================

        $transaksiTerbaru = Transaksi::with('user', 'customer')
            ->latest()
            ->take(10)
            ->get();

        // =========================
        // TRANSAKSI PER BULAN
        // =========================

        $transaksiBulanan = Transaksi::select(
                DB::raw('MONTH(waktu) as bulan'),
                DB::raw('SUM(total_harga) as total')
            )
            ->groupBy(DB::raw('MONTH(waktu)'))
            ->orderBy(DB::raw('MONTH(waktu)'))
            ->get();

        // Label bulan
        $bulan = [
            1 => 'Jan',
            2 => 'Feb',
            3 => 'Mar',
            4 => 'Apr',
            5 => 'Mei',
            6 => 'Jun',
            7 => 'Jul',
            8 => 'Agu',
            9 => 'Sep',
            10 => 'Okt',
            11 => 'Nov',
            12 => 'Des'
        ];

        $labels = [];
        $data = [];

        foreach ($transaksiBulanan as $item) {
            $labels[] = $bulan[$item->bulan];
            $data[] = $item->total;
        }

        return view('dashboard.index', compact(
            'totalTransaksi',
            'totalPendapatan',
            'totalModal',
            'keuntungan',
            'transaksiTerbaru',
            'labels',
            'data'
        ));
    }
}
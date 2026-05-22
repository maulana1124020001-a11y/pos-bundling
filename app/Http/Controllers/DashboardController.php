<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Transaksi;
use App\Models\TransaksiDetail;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Filter Waktu (Bulan Ini)
        $awalBulan = Carbon::now()->startOfMonth();
        $akhirBulan = Carbon::now()->endOfMonth();

        // 2. Data Statistik Utama (Card)
        $jumlahMenu = Menu::count();
        
        $jumlahTransaksi = Transaksi::whereBetween('waktu', [$awalBulan, $akhirBulan])->count();
        
        $totalPendapatan = Transaksi::whereBetween('waktu', [$awalBulan, $akhirBulan])->sum('total_harga');

        // Hitung total modal langsung via relasi TransaksiDetail ke Menu
       // Hitung total modal langsung via relasi TransaksiDetail ke Menu
$totalModal = TransaksiDetail::whereHas('transaksi', function ($query) use ($awalBulan, $akhirBulan) {
        $query->whereBetween('waktu', [$awalBulan, $akhirBulan]);
    })
    ->join('menus', 'transaksi_details.menu_id', '=', 'menus.id') // Perbaikan nama tabel di sini
    ->sum(DB::raw('menus.modal * transaksi_details.jumlah'));
            

        $keuntunganBersih = $totalPendapatan - $totalModal;

        // 3. Data Menu Terlaris & Kurang Laris
        $baseQuery = TransaksiDetail::with('menu')
            ->select('menu_id', DB::raw('SUM(jumlah) as total_terjual'))
            ->whereHas('transaksi', function ($query) use ($awalBulan, $akhirBulan) {
                $query->whereBetween('waktu', [$awalBulan, $akhirBulan]);
            })
            ->groupBy('menu_id');

        // Batasi hasil pencarian maksimal 5 data (sesuai komentar Anda sebelumnya)
        $menuTerlaris = (clone $baseQuery)->orderBy('total_terjual', 'desc')->take(5)->get();
        $menuKurangLaris = (clone $baseQuery)->orderBy('total_terjual', 'asc')->take(5)->get();

        // 4. Kirim Data ke View
        return view('dashboard.index', compact(
            'jumlahMenu', 'jumlahTransaksi', 'totalPendapatan', 
            'totalModal', 'keuntunganBersih', 'menuTerlaris', 'menuKurangLaris'
        ));
    }
}
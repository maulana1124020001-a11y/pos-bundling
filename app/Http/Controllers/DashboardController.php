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
        // Ambil tanggal awal dan akhir bulan sekarang
        $awalBulan = Carbon::now()->startOfMonth();
        $akhirBulan = Carbon::now()->endOfMonth();

        // Hitung jumlah seluruh menu
        $jumlahMenu = Menu::count();

        // Ambil transaksi bulan ini
        $transaksiBulanIni = Transaksi::whereBetween('waktu', [ $awalBulan, $akhirBulan]);

        // Hitung jumlah transaksi
        $jumlahTransaksi = $transaksiBulanIni->count();

        // Hitung total pendapatan
        $totalPendapatan = $transaksiBulanIni->sum('total_harga');

        // Hitung total modal bulan ini dengan join ke tabel menu untuk mendapatkan harga modal per menu dan kalikan dengan jumlah yang terjual fungsi dari = 
        $totalModal = TransaksiDetail::join('menus','transaksi_details.menu_id','=','menus.id')
            ->whereHas('transaksi', function ($query) use ($awalBulan, $akhirBulan) {$query->whereBetween('waktu', [$awalBulan,$akhirBulan]); })
            ->sum(DB::raw('menus.modal * transaksi_details.jumlah'));

        // Keuntungan bersih
        $keuntunganBersih = $totalPendapatan - $totalModal;

       
        $filter = request('filter', 'desc');

        $semuaMenu = TransaksiDetail::with('menu')
            ->select('menu_id', DB::raw('SUM(jumlah) as total_terjual') )

            // Filter transaksi bulan ini
            ->whereHas('transaksi', function ($query) use ($awalBulan, $akhirBulan) {
                $query->whereBetween('waktu', [
                    $awalBulan,
                    $akhirBulan
                ]);
            })

            // Kelompokkan berdasarkan menu
            ->groupBy('menu_id')

            // Urutkan berdasarkan total terjual
            ->orderBy('total_terjual', $filter)

            ->get();


            $penjualanHarian = Transaksi::select(
        DB::raw('DATE(waktu) as tanggal'),
        DB::raw('SUM(total_harga) as total')
    )

    ->whereBetween('waktu', [$awalBulan, $akhirBulan])

    ->groupBy('tanggal')

    ->orderBy('tanggal', 'asc')

    ->get();

        // Kirim data ke view dashboard
        return view('dashboard.index', compact(
            'jumlahMenu',
            'jumlahTransaksi',
            'totalPendapatan',
            'totalModal',
            'keuntunganBersih',
            'semuaMenu',
            'filter',
            'penjualanHarian',
        ));
    }
}
<?php

namespace App\Http\Controllers;

// Import model yang akan dipakai
use App\Models\Menu;
use App\Models\Transaksi;
use App\Models\TransaksiDetail;

// Import Carbon untuk mengatur tanggal
use Carbon\Carbon;

// Import DB untuk query perhitungan SQL
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {


        $awalBulan = Carbon::now()->startOfMonth();
        $akhirBulan = Carbon::now()->endOfMonth();


        $jumlahMenu = Menu::count();

        $jumlahTransaksi = Transaksi::whereBetween(
            'waktu',
            [$awalBulan, $akhirBulan]
        )->count();

        $totalPendapatan = Transaksi::whereBetween(
            'waktu',
            [$awalBulan, $akhirBulan]
        )->sum('total_harga');



       

        $totalModal = TransaksiDetail::whereHas(
            'transaksi',
            function ($query) use ($awalBulan, $akhirBulan) {

                // hanya mengambil transaksi bulan ini
                $query->whereBetween(
                    'waktu',
                    [$awalBulan, $akhirBulan]
                );
            }
        )

        // menghubungkan tabel transaksi_details dengan menus
        ->join(
            'menus',
            'transaksi_details.menu_id',
            '=',
            'menus.id'
        )

        // menghitung:
        // modal menu x jumlah terjual
        ->sum(
            DB::raw('menus.modal * transaksi_details.jumlah')
        );

        $keuntunganBersih = $totalPendapatan - $totalModal;

      /*
|--------------------------------------------------------------------------
| FILTER URUTAN MENU
|--------------------------------------------------------------------------
|
| desc = paling laris
| asc  = paling tidak laris
|
| default:
| desc
|
|--------------------------------------------------------------------------
*/

$filter = request('filter', 'desc');


/*
|--------------------------------------------------------------------------
| SEMUA MENU + TOTAL TERJUAL
|--------------------------------------------------------------------------
*/

$semuaMenu = TransaksiDetail::with('menu')

    ->select(
        'menu_id',
        DB::raw('SUM(jumlah) as total_terjual')
    )

    ->whereHas('transaksi', function ($query) use ($awalBulan, $akhirBulan) {

        $query->whereBetween(
            'waktu',
            [$awalBulan, $akhirBulan]
        );

    })

    ->groupBy('menu_id')

    // urutan dinamis
    ->orderBy('total_terjual', $filter)

    ->get();


       return view('dashboard.index', compact(
    'jumlahMenu',
    'jumlahTransaksi',
    'totalPendapatan',
    'totalModal',
    'keuntunganBersih',
    'semuaMenu',
    'filter'
));
    }
}
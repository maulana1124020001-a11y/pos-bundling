<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\TransaksiDetail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
       
        //  PENGATURAN FILTER TANGGAL (PERIODE)
        
        $bulanSelected = $request->input('bulan', date('m'));
        $tahunSelected = $request->input('tahun', date('Y'));

        if ($bulanSelected == 'semua') {
            $awalPeriode = Carbon::parse("$tahunSelected-01-01")->startOfYear();
            $akhirPeriode = Carbon::parse("$tahunSelected-01-01")->endOfYear();
        } else {
            $awalPeriode = Carbon::parse("$tahunSelected-$bulanSelected-01")->startOfMonth();
            $akhirPeriode = Carbon::parse("$tahunSelected-$bulanSelected-01")->endOfMonth();
        }

       
        //  MENGHITUNG RINGKASAN KEUANGAN
       
        $ringkasan = Transaksi::whereBetween('waktu', [$awalPeriode, $akhirPeriode])
            ->selectRaw('COUNT(id) as jumlah, SUM(total_harga) as pendapatan')
            ->first();

        $jumlahTransaksi = $ringkasan->jumlah ?? 0;
        $totalPendapatan = $ringkasan->pendapatan ?? 0;

        $totalModal = TransaksiDetail::join('menus', 'transaksi_details.menu_id', '=', 'menus.id')
            ->whereHas('transaksi', function ($query) use ($awalPeriode, $akhirPeriode) {
                $query->whereBetween('waktu', [$awalPeriode, $akhirPeriode]);
            })
            ->sum(DB::raw('menus.modal * transaksi_details.jumlah'));

        $keuntunganBersih = $totalPendapatan - $totalModal;

       
        //  FITUR TAMBAHAN: FILTER DISAMAKAN DASHBOARD
       
        // Menangkap filter urutan menu (paling laris 'desc' atau tidak laris 'asc'). 
        // Jika belum dipilih, default diset ke 'desc' (Paling Laris).
        $filterMenu = $request->input('filter_menu', 'desc');

        // Mengambil daftar menu yang terjual dengan pengurutan dinamis sesuai isi $filterMenu
        $semuaMenu = TransaksiDetail::with('menu')
            ->select('menu_id', DB::raw('SUM(jumlah) as total_terjual'))
            ->whereHas('transaksi', function ($query) use ($awalPeriode, $akhirPeriode) {
                $query->whereBetween('waktu', [$awalPeriode, $akhirPeriode]);
            })
            ->groupBy('menu_id')
            ->orderBy('total_terjual', $filterMenu) // <-- Menggunakan variabel di sini
            ->get();

       
        //  DATA GRAFIK
       
        $penjualanGrafik = Transaksi::whereBetween('waktu', [$awalPeriode, $akhirPeriode]);

        if ($bulanSelected == 'semua') {
            $penjualanGrafik = $penjualanGrafik->selectRaw('MONTH(waktu) as bulan_angka, SUM(total_harga) as total')
                ->groupBy('bulan_angka')->orderBy('bulan_angka', 'asc')->get();
            
            $namaBulanIndo = [1=>'Jan', 2=>'Feb', 3=>'Mar', 4=>'Apr', 5=>'Mei', 6=>'Jun', 7=>'Jul', 8=>'Agu', 9=>'Sep', 10=>'Okt', 11=>'Nov', 12=>'Des'];
            $labels = $penjualanGrafik->map(fn($item) => $namaBulanIndo[$item->bulan_angka]);
        } else {
            $penjualanGrafik = $penjualanGrafik->selectRaw('DATE(waktu) as tanggal, SUM(total_harga) as total')
                ->groupBy('tanggal')->orderBy('tanggal', 'asc')->get();
            
            $labels = $penjualanGrafik->pluck('tanggal');
        }

       
        //  DATA PEMBANTU UNTUK DROPDOWN VIEW
       
        $listBulan = ['semua' => 'Semua Bulan', '01' => 'Januari', '02' => 'Februari', '03' => 'Maret', '04' => 'April', '05' => 'Mei', '06' => 'Juni', '07' => 'Juli', '08' => 'Agustus', '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Desember'];
        $listTahun = range(date('Y') - 3, date('Y'));

        // Kirimkan variabel 'filterMenu' ke view agar dropdown di HTML tahu opsi mana yang sedang aktif
        return view('laporan.index', compact(
            'jumlahTransaksi', 'totalPendapatan', 'totalModal', 'keuntunganBersih', 
            'semuaMenu', 'penjualanGrafik', 'labels', 'bulanSelected', 'tahunSelected', 
            'listBulan', 'listTahun', 'filterMenu'
        ));
    }
}
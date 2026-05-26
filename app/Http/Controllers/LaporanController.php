<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Transaksi;
use App\Models\TransaksiDetail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        // Ambil input filter, default ke bulan dan tahun sekarang
        $bulanSelected = $request->input('bulan', Carbon::now()->format('m'));
        $tahunSelected = $request->input('tahun', Carbon::now()->format('Y'));

        // PENJELASAN LOGIKA: Jika pilih 'semua', rentang tanggal diatur 1 tahun penuh. Jika tidak, diatur 1 bulan saja.
        if ($bulanSelected == 'semua') {
            $awalPeriode = Carbon::createFromDate($tahunSelected, 1, 1)->startOfYear();
            $akhirPeriode = Carbon::createFromDate($tahunSelected, 1, 1)->endOfYear();
        } else {
            $awalPeriode = Carbon::createFromDate($tahunSelected, $bulanSelected, 1)->startOfMonth();
            $akhirPeriode = Carbon::createFromDate($tahunSelected, $bulanSelected, 1)->endOfMonth();
        }

        // 1. Hitung ringkasan transaksi berdasarkan rentang periode yang ditentukan di atas
        $transaksiFilter = Transaksi::whereBetween('waktu', [$awalPeriode, $akhirPeriode]);
        $jumlahTransaksi = $transaksiFilter->count();
        $totalPendapatan = $transaksiFilter->sum('total_harga');

        // 2. Hitung total modal pada periode filter
        $totalModal = TransaksiDetail::join('menus', 'transaksi_details.menu_id', '=', 'menus.id')
            ->whereHas('transaksi', function ($query) use ($awalPeriode, $akhirPeriode) { $query->whereBetween('waktu', [$awalPeriode, $akhirPeriode]); })
            ->sum(DB::raw('menus.modal * transaksi_details.jumlah'));

        // 3. Hitung Keuntungan Bersih
        $keuntunganBersih = $totalPendapatan - $totalModal;

        // 4. Ambil data penjualan produk pada periode filter
        $semuaMenu = TransaksiDetail::with('menu')
            ->select('menu_id', DB::raw('SUM(jumlah) as total_terjual'))
            ->whereHas('transaksi', function ($query) use ($awalPeriode, $akhirPeriode) { $query->whereBetween('waktu', [$awalPeriode, $akhirPeriode]); })
            ->groupBy('menu_id')->orderBy('total_terjual', 'desc')->get();

        // 5. Ambil data untuk grafik. PENJELASAN: Jika filter 'semua bulan', grafik dikelompokkan per bulan. Jika filter bulanan, grafik dikelompokkan per tanggal/hari.
        if ($bulanSelected == 'semua') {
            $penjualanGrafik = Transaksi::select(DB::raw('MONTH(waktu) as bulan_angka'), DB::raw('SUM(total_harga) as total'))
                ->whereBetween('waktu', [$awalPeriode, $akhirPeriode])
                ->groupBy('bulan_angka')->orderBy('bulan_angka', 'asc')->get();
            
            // Konversi angka bulan ke nama bulan Indonesia untuk label grafik
            $namaBulanIndo = [1=>'Jan', 2=>'Feb', 3=>'Mar', 4=>'Apr', 5=>'Mei', 6=>'Jun', 7=>'Jul', 8=>'Agu', 9=>'Sep', 10=>'Okt', 11=>'Nov', 12=>'Des'];
            $labels = $penjualanGrafik->map(function($item) use ($namaBulanIndo) { return $namaBulanIndo[$item->bulan_angka]; });
        } else {
            $penjualanGrafik = Transaksi::select(DB::raw('DATE(waktu) as tanggal'), DB::raw('SUM(total_harga) as total'))
                ->whereBetween('waktu', [$awalPeriode, $akhirPeriode])
                ->groupBy('tanggal')->orderBy('tanggal', 'asc')->get();
            $labels = $penjualanGrafik->pluck('tanggal');
        }

        // Data array pembantu untuk dropdown di View
        $listBulan = ['semua' => 'Semua Bulan', '01' => 'Januari', '02' => 'Februari', '03' => 'Maret', '04' => 'April', '05' => 'Mei', '06' => 'Juni', '07' => 'Juli', '08' => 'Agustus', '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Desember'];
        $listTahun = range(Carbon::now()->subYears(3)->format('Y'), Carbon::now()->format('Y'));

        return view('laporan.index', compact('jumlahTransaksi', 'totalPendapatan', 'totalModal', 'keuntunganBersih', 'semuaMenu', 'penjualanGrafik', 'labels', 'bulanSelected', 'tahunSelected', 'listBulan', 'listTahun'));
    }
}
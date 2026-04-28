<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Customer;
use App\Models\Transaksi;
use App\Models\TransaksiDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class TransaksiController extends Controller
{
    /**
     * Menampilkan riwayat transaksi
     */
    public function index()
    {
        $transaksis = Transaksi::with('user')->latest()->get();
        return view('transaksi.index', compact('transaksis'));
    }

    /**
     * Halaman Kasir (Tempat menginput belanjaan)
     */
    public function create()
    {
        $menus = Menu::where('status', 'tersedia')->get();
        $customers = Customer::get();
        return view('transaksi.create', compact('menus', 'customers'));
    }

    /**
     * Proses menyimpan transaksi ke database
     */
    public function store(Request $request)
    {
        $request->validate([
            'total_harga' => 'required|numeric',
            'uang_bayar'  => 'required|numeric|min:' . $request->total_harga,
            'items'       => 'required|array', // Array dari keranjang belanja
        ]);

        // Mulai Database Transaction
        DB::beginTransaction();

        try {
            // 1. Simpan ke tabel Transaksi
            $transaksi = Transaksi::create([
                'user_id'           => Auth::id(),
                'total_harga'       => $request->total_harga,
                'uang_bayar'        => $request->uang_bayar,
                'kembalian'         => $request->uang_bayar - $request->total_harga,
                'status'            => 'selesai',
                'metode_pembayaran' => $request->metode_pembayaran ?? 'cash',
                'waktu'             => now(),
            ]);

            // 2. Simpan setiap item ke TransaksiDetail
            foreach ($request->items as $item) {
                TransaksiDetail::create([
                    'transaksi_id' => $transaksi->id,
                    'menu_id'      => $item['menu_id'],
                    'jumlah'       => $item['jumlah'],
                    'harga'        => $item['harga'],
                    'subtotal'     => $item['jumlah'] * $item['harga'],
                ]);
            }

            DB::commit();
            return redirect()->route('transaksi.index')->with('success', 'Transaksi Berhasil!');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Terjadi Kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Menampilkan struk/detail transaksi tertentu
     */
    public function show(Transaksi $transaksi)
    {
        $transaksi->load('details.menu', 'user');
        return view('transaksi.show', compact('transaksi'));
    }
}
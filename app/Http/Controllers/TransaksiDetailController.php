<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Transaksi;
use App\Models\TransaksiDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class TransaksiController extends Controller
{
    public function index()
    {
        $transaksis = Transaksi::with('user')->latest()->get();
        return view('transaksi.index', compact('transaksis'));
    }

    public function create()
    {
        // Mengambil semua menu yang tersedia
        $menus = Menu::where('status', 'tersedia')->get();
        return view('transaksi.create', compact('menus'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'total_harga' => 'required|numeric',
            'uang_bayar'  => 'required|numeric|min:' . $request->total_harga,
            'items'       => 'required|array',
        ]);

        DB::beginTransaction();

        try {
            // 1. Simpan Header Transaksi
            $transaksi = Transaksi::create([
                'user_id'           => Auth::id(),
                'total_harga'       => $request->total_harga,
                'uang_bayar'        => $request->uang_bayar,
                'kembalian'         => $request->uang_bayar - $request->total_harga,
                'status'            => 'selesai',
                'metode_pembayaran' => $request->metode_pembayaran ?? 'cash',
                'waktu'             => now(),
            ]);

            // 2. Simpan Detail Transaksi (Termasuk Diskon per Item)
            foreach ($request->items as $item) {
                $harga_asli = $item['harga'];
                $diskon_per_item = $item['diskon'] ?? 0;
                $jumlah = $item['jumlah'];
                
                // Kalkulasi subtotal: (Harga - Diskon) * Qty
                $subtotal = ($harga_asli - $diskon_per_item) * $jumlah;

                TransaksiDetail::create([
                    'transaksi_id' => $transaksi->id,
                    'menu_id'      => $item['menu_id'],
                    'jumlah'       => $jumlah,
                    'harga'        => $harga_asli,
                    'diskon'       => $diskon_per_item,
                    'subtotal'     => $subtotal,
                ]);
            }

            DB::commit();
            return redirect()->route('transaksi.index')->with('success', 'Transaksi Berhasil!');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Gagal: ' . $e->getMessage());
        }
    }
}

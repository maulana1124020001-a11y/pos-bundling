<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Kategori;
use App\Models\Menu;
use App\Models\Transaksi;
use App\Models\TransaksiDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TransaksiController extends Controller
{
    // =========================
    // LIST TRANSAKSI
    // =========================
    public function index()
    {
        // admin lihat semua
        if (auth()->user()->role_id == 1) {

            $transaksis = Transaksi::with('user', 'customer')
                ->latest()
                ->get();

        } else {

            // kasir hanya lihat miliknya
            $transaksis = Transaksi::where('user_id', auth()->id())
                ->with('user', 'customer')
                ->latest()
                ->get();

        }

        return view('transaksi.index', compact('transaksis'));
    }


    // =========================
    // HALAMAN TRANSAKSI / KASIR
    // =========================
    public function create()
    {
        // menu tersedia
        $menus = Menu::where('status', 'tersedia')
            ->latest()
            ->get();

        // customer
        $customers = Customer::latest()->get();

        // kategori
        $kategoris = Kategori::latest()->get();

        return view(
            'transaksi.create',
            compact('menus', 'customers', 'kategoris')
        );
    }


    // =========================
    // SIMPAN TRANSAKSI
    // =========================
    public function store(Request $request)
    {
        // ubah json cart menjadi array
        $items = json_decode($request->items, true);

        // validasi
        $request->validate([
            'total_harga' => 'required|numeric',
            'uang_bayar' =>'required|numeric|min:' . $request->total_harga,
            'metode_pembayaran' =>'required',
            'items' => 'required',

        ]);

        // validasi cart kosong
        if (!$items || count($items) == 0) {

            return redirect()
                ->back()
                ->with('error', 'Keranjang kosong');

        }

        DB::beginTransaction();

        try {

            // simpan transaksi
            $transaksi = Transaksi::create([

                'user_id' => Auth::id(),

                'customer_id' =>
                    $request->customer_id ?: null,

                'total_harga' =>
                    $request->total_harga,

                'uang_bayar' =>
                    $request->uang_bayar,

                'kembalian' =>
                    $request->uang_bayar -
                    $request->total_harga,

                'metode_pembayaran' =>
                    $request->metode_pembayaran,

                'status' => 'selesai',

                'waktu' => now(),

            ]);


            // simpan detail transaksi
            foreach ($items as $item) {

                TransaksiDetail::create([

                    'transaksi_id' =>
                        $transaksi->id,

                    'menu_id' =>
                        $item['menu_id'],

                    'jumlah' =>
                        $item['jumlah'],

                    'harga' =>
                        $item['harga'],

                    'subtotal' =>
                        $item['jumlah'] *
                        $item['harga'],

                ]);

            }

            DB::commit();

            return redirect()
                ->route('transaksi.show', $transaksi->id)
                ->with('success', 'Transaksi berhasil');

        } catch (\Exception $e) {

            DB::rollback();

            return redirect()
                ->back()
                ->with('error', $e->getMessage());

        }
    }


    // =========================
    // DETAIL TRANSAKSI
    // =========================
    public function show(Transaksi $transaksi)
    {
        $transaksi->load(
            'detail.menu',
            'user',
            'customer'
        );

        return view(
            'transaksi.show',
            compact('transaksi')
        );
    }


    // =========================
    // HAPUS TRANSAKSI
    // =========================
    public function destroy(Transaksi $transaksi)
    {
        DB::beginTransaction();

        try {

            // hapus detail transaksi dulu
            $transaksi->detail()->delete();

            // hapus transaksi
            $transaksi->delete();

            DB::commit();

            return redirect()
                ->route('transaksi.index')
                ->with('success', 'Transaksi berhasil dihapus');

        } catch (\Exception $e) {

            DB::rollback();

            return redirect()
                ->back()
                ->with('error', $e->getMessage());

        }
    }
}
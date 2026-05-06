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
    // HALAMAN LIST TRANSAKSI
    // =========================
    public function index()
    {
        // kalau bukan admin → hanya lihat transaksi sendiri
        if (auth()->user()->role_id != 1) {
            $transaksis = Transaksi::where('user_id', auth()->id())
                ->with('user')
                ->latest()
                ->get();
        } else {
            // admin → lihat semua
            $transaksis = Transaksi::with('user')->latest()->get();
        }

        return view('transaksi.index', compact('transaksis'));
    }

    // =========================
    // HALAMAN KASIR
    // =========================
    public function create()
    {
        // ambil menu yang tersedia
        $menus = Menu::where('status', 'tersedia')->get();

        // ambil semua customer
        $customers = Customer::all();

        // ambil kategori untuk filter
        $kategoris = Kategori::all();

        return view('transaksi.create', compact('menus', 'customers', 'kategoris'));
    }

    // =========================
    // SIMPAN TRANSAKSI (AJAX)
    // =========================
    public function store(Request $request)
    {
        // validasi data dari JS
        $request->validate([
            'total_harga' => 'required|numeric',
            'uang_bayar' => 'required|numeric|min:' . $request->total_harga,
            'items' => 'required|array',
        ]);

        DB::beginTransaction();

        try {
            // simpan transaksi utama
            $transaksi = Transaksi::create([
                'user_id' => Auth::id(),
                'total_harga' => $request->total_harga,
                'uang_bayar' => $request->uang_bayar,
                'kembalian' => $request->uang_bayar - $request->total_harga,
                'status' => 'selesai',
                'customer_id' => $request->customer_id ?: null,
                'metode_pembayaran' => $request->metode_pembayaran ?? 'cash',
                'waktu' => now(),
            ]);

            // simpan detail item
            foreach ($request->items as $item) {
                TransaksiDetail::create([
                    'transaksi_id' => $transaksi->id,
                    'menu_id' => $item['menu_id'],
                    'jumlah' => $item['jumlah'],
                    'harga' => $item['harga'],
                    'subtotal' => $item['jumlah'] * $item['harga'],
                ]);
            }

            DB::commit();

            // return JSON → diproses JS
            return response()->json([
                'success' => true,
                'redirect' => route('transaksi.show', $transaksi)
            ]);

        } catch (\Exception $e) {
            DB::rollback();

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    // =========================
    // DETAIL TRANSAKSI
    // =========================
    public function show(Transaksi $transaksi)
    {
        $transaksi->load('detail.menu', 'user', 'customer');
        return view('transaksi.show', compact('transaksi'));
    }
}
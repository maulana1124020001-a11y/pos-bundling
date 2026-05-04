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
    public function index()
    {
        if (auth()->user()->role_id != 1) {
            $transaksis = Transaksi::where('user_id', auth()->id())
                ->with('user')
                ->latest()
                ->get();
        } else {
            $transaksis = Transaksi::with('user')->latest()->get();
        }

        return view('transaksi.index', compact('transaksis'));
    }

    public function create()
    {
        $menus = Menu::where('status', 'tersedia')->get();
        $customers = Customer::get();
        $kategoris = Kategori::all(); // ✅ FIX

        return view('transaksi.create', compact('menus', 'customers', 'kategoris'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'total_harga' => 'required|numeric',
            'uang_bayar' => 'required|numeric|min:'.$request->total_harga,
            'items' => 'required|array',
            'customer_id' => 'nullable|exists:customers,id',
        ]);

        DB::beginTransaction();

        try {
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

            // ✅ langsung ke detail
            return redirect()->route('transaksi.show', $transaksi);

        } catch (\Exception $e) {
            DB::rollback();

            return back()->with('error', $e->getMessage());
        }
    }

    public function show(Transaksi $transaksi)
    {
        $transaksi->load('detail.menu', 'user', 'customer');
        return view('transaksi.show', compact('transaksi'));
    }
}
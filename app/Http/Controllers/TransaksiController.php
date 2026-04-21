<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\TransaksiDetail;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransaksiController extends Controller
{
    // ========================
    // INDEX (list transaksi)
    // ========================
    public function index()
    {
        $transaksis = Transaksi::with('user')->latest()->get();

        return view('transaksi.index', compact('transaksis'));
    }

    // ========================
    // CREATE (form kasir)
    // ========================
    public function create()
    {
        $menus = Menu::where('status', 'tersedia')->get();

        return view('transaksi.create', compact('menus'));
    }

    // ========================
    // STORE (simpan transaksi)
    // ========================
    public function store(Request $request)
    {
        $request->validate([
            'menu_id' => 'required|array',
            'jumlah' => 'required|array',
            'uang_bayar' => 'required|numeric|min:0',
            'metode_pembayaran' => 'required|in:cash,qris,transfer'
        ]);

        $total = 0;

        // hitung total
        foreach ($request->menu_id as $index => $menuId) {
            $menu = Menu::findOrFail($menuId);
            $jumlah = $request->jumlah[$index];

            $subtotal = $menu->harga * $jumlah;
            $total += $subtotal;
        }

        // hitung kembalian
        $kembalian = $request->uang_bayar - $total;

        if ($kembalian < 0) {
            return back()->withErrors(['uang_bayar' => 'Uang kurang'])->withInput();
        }

        // simpan transaksi
        $transaksi = Transaksi::create([
            'user_id' => Auth::id() ?? 1, // sementara
            'total_harga' => $total,
            'uang_bayar' => $request->uang_bayar,
            'kembalian' => $kembalian,
            'status' => 'selesai',
            'metode_pembayaran' => $request->metode_pembayaran,
            'waktu' => now()
        ]);

        // simpan detail
        foreach ($request->menu_id as $index => $menuId) {
            $menu = Menu::findOrFail($menuId);
            $jumlah = $request->jumlah[$index];

            TransaksiDetail::create([
                'transaksi_id' => $transaksi->id,
                'menu_id' => $menuId,
                'jumlah' => $jumlah,
                'harga' => $menu->harga,
                'subtotal' => $menu->harga * $jumlah
            ]);
        }

        return redirect()->route('transaksi.index')
            ->with('success', 'Transaksi berhasil');
    }

    // ========================
    // SHOW (detail transaksi)
    // ========================
    public function show($id)
    {
        $transaksi = Transaksi::with(['detail.menu', 'user'])->findOrFail($id);

        return view('transaksi.show', compact('transaksi'));
    }

    // ========================
    // HAPUS (opsional)
    // ========================
    public function destroy($id)
    {
        $transaksi = Transaksi::findOrFail($id);
        $transaksi->delete();

        return redirect()->route('transaksi.index')
            ->with('success', 'Transaksi dihapus');
    }
}
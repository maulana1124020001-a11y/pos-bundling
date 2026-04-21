<?php

namespace App\Http\Controllers;

use App\Models\TransaksiDetail;
use App\Models\Transaksi;
use App\Models\Menu;
use Illuminate\Http\Request;

class TransaksiDetailController extends Controller
{
    // ========================
    // INDEX
    // ========================
    public function index()
    {
        $details = TransaksiDetail::with(['transaksi', 'menu'])->get();

        return view('transaksi_detail.index', compact('details'));
    }

    // ========================
    // CREATE
    // ========================
    public function create()
    {
        $transaksis = Transaksi::all();
        $menus = Menu::all();

        return view('transaksi_detail.create', compact('transaksis', 'menus'));
    }

    // ========================
    // STORE
    // ========================
    public function store(Request $request)
    {
        $request->validate([
            'transaksi_id' => 'required|exists:transaksis,id',
            'menu_id' => 'required|exists:menus,id',
            'jumlah' => 'required|numeric|min:1'
        ]);

        $menu = Menu::findOrFail($request->menu_id);

        $subtotal = $menu->harga * $request->jumlah;

        TransaksiDetail::create([
            'transaksi_id' => $request->transaksi_id,
            'menu_id' => $request->menu_id,
            'jumlah' => $request->jumlah,
            'harga' => $menu->harga,
            'subtotal' => $subtotal
        ]);

        return redirect()->route('transaksi_detail.index')
            ->with('success', 'Detail transaksi berhasil ditambahkan');
    }

    // ========================
    // SHOW
    // ========================
    public function show($id)
    {
        $detail = TransaksiDetail::with(['transaksi', 'menu'])->findOrFail($id);

        return view('transaksi_detail.show', compact('detail'));
    }

    // ========================
    // EDIT
    // ========================
    public function edit($id)
    {
        $detail = TransaksiDetail::findOrFail($id);
        $transaksis = Transaksi::all();
        $menus = Menu::all();

        return view('transaksi_detail.edit', compact('detail', 'transaksis', 'menus'));
    }

    // ========================
    // UPDATE
    // ========================
    public function update(Request $request, $id)
    {
        $detail = TransaksiDetail::findOrFail($id);

        $request->validate([
            'transaksi_id' => 'required|exists:transaksis,id',
            'menu_id' => 'required|exists:menus,id',
            'jumlah' => 'required|numeric|min:1'
        ]);

        $menu = Menu::findOrFail($request->menu_id);

        $detail->update([
            'transaksi_id' => $request->transaksi_id,
            'menu_id' => $request->menu_id,
            'jumlah' => $request->jumlah,
            'harga' => $menu->harga,
            'subtotal' => $menu->harga * $request->jumlah
        ]);

        return redirect()->route('transaksi_detail.index')
            ->with('success', 'Detail transaksi berhasil diupdate');
    }

    // ========================
    // DELETE
    // ========================
    public function destroy($id)
    {
        $detail = TransaksiDetail::findOrFail($id);
        $detail->delete();

        return redirect()->route('transaksi_detail.index')
            ->with('success', 'Detail transaksi berhasil dihapus');
    }
}
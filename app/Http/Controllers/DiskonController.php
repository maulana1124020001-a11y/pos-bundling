<?php

namespace App\Http\Controllers;

use App\Models\Diskon;
use App\Models\Menu;
use Illuminate\Http\Request;

class DiskonController extends Controller
{
    /**
     * Menampilkan daftar diskon yang ada.
     */
    public function index()
    {
        $diskons = Diskon::with('menu')->latest()->get();
        return view('diskon.index', compact('diskons'));
    }

    /**
     * Menampilkan form tambah diskon.
     */
    public function create()
    {
        $menus = Menu::all();
        return view('diskon.create', compact('menus'));
    }

    /**
     * Menyimpan data diskon baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'menu_id'       => 'required|exists:menus,id',
            'tipe_diskon'   => 'required|in:Persen,Nominal',
            'mulai_diskon'  => 'required|date',
            'akhir_diskon'  => 'required|date|after:mulai_diskon',
            'diskon_persen' => 'required_if:tipe_diskon,Persen|nullable|numeric|max:100',
            'diskon_nominal'=> 'required_if:tipe_diskon,Nominal|nullable|numeric',
        ]);

        Diskon::create($request->all());

        return redirect()->route('diskon.index')->with('success', 'Diskon berhasil dikonfigurasi.');
    }

    /**
     * Menampilkan form edit diskon.
     */
    public function edit(Diskon $diskon)
    {
        $menus = Menu::all();
        return view('diskon.edit', compact('diskon', 'menus'));
    }

    /**
     * Memperbarui data diskon.
     */
    public function update(Request $request, Diskon $diskon)
    {
        $request->validate([
            'menu_id'       => 'required|exists:menus,id',
            'tipe_diskon'   => 'required|in:Persen,Nominal',
            'mulai_diskon'  => 'required|date',
            'akhir_diskon'  => 'required|date|after:mulai_diskon',
            'diskon_persen' => 'required_if:tipe_diskon,Persen|nullable|numeric|max:100',
            'diskon_nominal'=> 'required_if:tipe_diskon,Nominal|nullable|numeric',
        ]);

        $diskon->update($request->all());

        return redirect()->route('diskon.index')->with('success', 'Diskon berhasil diperbarui.');
    }

    /**
     * Menghapus diskon.
     */
    public function destroy(Diskon $diskon)
    {
        $diskon->delete();
        return redirect()->route('diskon.index')->with('success', 'Diskon berhasil dihapus.');
    }
}
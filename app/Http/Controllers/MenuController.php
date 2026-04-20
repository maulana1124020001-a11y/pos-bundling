<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $menus = Menu::with('kategori')->get();
        return view('menu.index', compact('menus'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kategoris = Kategori::all();
        return view('menu.create', compact('kategoris'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'kategori_id' => 'required',
            'nama' => 'required',
            'modal' => 'required|numeric',
            'harga' => 'required|numeric',
            'gambar' => 'image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $data = $request->all();

        // upload gambar
        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $namaFile = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images'), $namaFile);

            $data['gambar'] = $namaFile;
        }

        Menu::create($data);

        return redirect()->route('menu.index')
            ->with('success', 'Menu berhasil ditambahkan');

    }

    /**
     * Display the specified resource.
     */
    public function show(Menu $menu)
    {
        return view('menu.show', compact('menu'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Menu $menu)
    {
        $kategoris = Kategori::all();
        return view('menu.edit', compact('menu', 'kategoris'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Menu $menu)
    {
     $request->validate([
        'kategori_id' => 'required',
        'nama' => 'required',
        'modal' => 'required|numeric',
        'harga' => 'required|numeric',
        'gambar' => 'image|mimes:jpg,jpeg,png|max:2048'
    ]);

    $data = $request->all();

    if ($request->hasFile('gambar')) {
        // Hapus gambar lama jika ada
        if ($menu->gambar && File::exists(public_path('images/' . $menu->gambar))) {
            File::delete(public_path('images/' . $menu->gambar));
        }

        // Upload gambar baru
        $file = $request->file('gambar');
        $namaFile = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('images'), $namaFile);

        $data['gambar'] = $namaFile;
    }

    $menu->update($data);

    return redirect()->route('menu.index')
        ->with('success', 'Menu berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Menu $menu)
    {
        // Cek apakah ada file gambar dan apakah file tersebut ada di folder
    if ($menu->gambar && File::exists(public_path('images/' . $menu->gambar))) {
        File::delete(public_path('images/' . $menu->gambar));
    }

    // Hapus data dari database
    $menu->delete();

    return redirect()->route('menu.index')
        ->with('success', 'Menu dan gambar berhasil dihapus');
    }
}

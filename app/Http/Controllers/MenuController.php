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
            'gambar' => 'required|image|mimes:jpg,jpeg,png|max:2048'
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

        // Ambil semua input kecuali gambar (gambar ditangani terpisah)
        $data = $request->except('gambar');

        if ($request->hasFile('gambar')) {
            // 1. Hapus gambar lama jika ada di folder
            if ($menu->gambar && File::exists(public_path('images/' . $menu->gambar))) {
                File::delete(public_path('images/' . $menu->gambar));
            }

            // 2. Upload gambar baru
            $namaFile = time() . '_' . $request->file('gambar')->getClientOriginalName();
            $request->file('gambar')->move(public_path('images'), $namaFile);

            // 3. Masukkan nama file baru ke array data
            $data['gambar'] = $namaFile;
        }

        $menu->update($data);

        return redirect()->route('menu.index')->with('success', 'Menu berhasil diupdate');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Menu $menu)
    {
        // 1. Hapus file fisik di public/images

        // 2. Hapus data di database
        $menu->delete();

        return redirect()->route('menu.index')->with('success', 'Menu dan gambar terhapus');
    }

//     public function trash()
// {
//     $menus = Menu::onlyTrashed()->get();

//     return view('menu.trash', compact('menus'));
// }

//     public function restore($id)
//     {
//         $menu = Menu::onlyTrashed()->findOrFail($id);
//         $menu->restore();

//         return redirect()->route('menu.trash')->with('success', 'Menu berhasil direstore');
//     }

//     public function forceDelete($id)
// {


//     // Cari data termasuk yang sudah di-soft delete
//     $menu = Menu::withTrashed()->findOrFail($id);
//       if ($menu->gambar) {
//             File::delete(public_path('images/' . $menu->gambar));
//         }
//     // Hapus permanen dari database
//     $menu->forceDelete();

//     return redirect()->back()->with('success', 'Data berhasil dimusnahkan!');
// }

}

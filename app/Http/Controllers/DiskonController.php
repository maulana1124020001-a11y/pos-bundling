<?php

namespace App\Http\Controllers;

use App\Models\Diskon;
use App\Models\Menu;
use Illuminate\Http\Request;

class DiskonController extends Controller
{
    public function index()
    {
        $diskons = Diskon::with('menu')->get();
        return view('diskon.index', compact('diskons'));
    }

    public function create()
    {
        $menus = Menu::all();
        return view('diskon.create', compact('menus'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'menu_id' => 'required|exists:menus,id',
            'tipe_diskon' => 'required|in:Persen,Nominal',
            'diskon_persen' => 'nullable|numeric|min:0|max:100',
            'diskon_nominal' => 'nullable|numeric|min:0',
            'mulai_diskon' => 'required|date',
            'akhir_diskon' => 'required|date|after:mulai_diskon'
        ]);

        // Validasi manual sesuai tipe
        if ($request->tipe_diskon == 'Persen' && !$request->diskon_persen) {
            return back()->withErrors(['diskon_persen' => 'Diskon persen wajib diisi'])->withInput();
        }

        if ($request->tipe_diskon == 'Nominal' && !$request->diskon_nominal) {
            return back()->withErrors(['diskon_nominal' => 'Diskon nominal wajib diisi'])->withInput();
        }

        Diskon::create([
            'menu_id' => $request->menu_id,
            'tipe_diskon' => $request->tipe_diskon,
            'diskon_persen' => $request->diskon_persen,
            'diskon_nominal' => $request->diskon_nominal,
            'mulai_diskon' => $request->mulai_diskon,
            'akhir_diskon' => $request->akhir_diskon,
        ]);

        return redirect()->route('diskon.index')
            ->with('success', 'Diskon berhasil ditambahkan');
    }

    public function edit($id)
    {
        $diskon = Diskon::findOrFail($id);
        $menus = Menu::all();

        return view('diskon.edit', compact('diskon', 'menus'));
    }

    public function update(Request $request, $id)
    {
        $diskon = Diskon::findOrFail($id);

        $request->validate([
            'menu_id' => 'required|exists:menus,id',
            'tipe_diskon' => 'required|in:Persen,Nominal',
            'diskon_persen' => 'nullable|numeric|min:0|max:100',
            'diskon_nominal' => 'nullable|numeric|min:0',
            'mulai_diskon' => 'required|date',
            'akhir_diskon' => 'required|date|after:mulai_diskon'
        ]);

        if ($request->tipe_diskon == 'Persen' && !$request->diskon_persen) {
            return back()->withErrors(['diskon_persen' => 'Diskon persen wajib diisi'])->withInput();
        }

        if ($request->tipe_diskon == 'Nominal' && !$request->diskon_nominal) {
            return back()->withErrors(['diskon_nominal' => 'Diskon nominal wajib diisi'])->withInput();
        }

        $diskon->update([
            'menu_id' => $request->menu_id,
            'tipe_diskon' => $request->tipe_diskon,
            'diskon_persen' => $request->diskon_persen,
            'diskon_nominal' => $request->diskon_nominal,
            'mulai_diskon' => $request->mulai_diskon,
            'akhir_diskon' => $request->akhir_diskon,
        ]);

        return redirect()->route('diskon.index')
            ->with('success', 'Diskon berhasil diupdate');
    }

    public function destroy($id)
    {
        $diskon = Diskon::findOrFail($id);
        $diskon->delete();

        return redirect()->route('diskon.index')
            ->with('success', 'Diskon berhasil dihapus');
    }
}
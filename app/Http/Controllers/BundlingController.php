<?php

namespace App\Http\Controllers;

use App\Models\Bundling;
use App\Models\Menu;
use Illuminate\Http\Request;

class BundlingController extends Controller
{
    public function index()
    {
        $bundlings = Bundling::with(['menu', 'menuNonBundling'])->get();

        return view('bundling.index', compact('bundlings'));
    }

    public function create()
    {
        $menus = Menu::all();

        return view('bundling.create', compact('menus'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'menu_id' => 'required|exists:menus,id',
            'menu_non_bundling_id' => 'required|exists:menus,id|different:menu_id',
            'harga' => 'required|numeric|min:0'
        ]);

        Bundling::create($request->all());

        return redirect()->route('bundling.index')
            ->with('success', 'Bundling berhasil ditambahkan');
    }

    public function show($id)
    {
        $bundling = Bundling::with(['menu', 'menuNonBundling'])->findOrFail($id);

        return view('bundling.show', compact('bundling'));
    }

    public function edit($id)
    {
        $bundling = Bundling::findOrFail($id);
        $menus = Menu::all();

        return view('bundling.edit', compact('bundling', 'menus'));
    }

    public function update(Request $request, $id)
    {
        $bundling = Bundling::findOrFail($id);

        $request->validate([
            'menu_id' => 'required|exists:menus,id',
            'menu_non_bundling_id' => 'required|exists:menus,id|different:menu_id',
            'harga' => 'required|numeric|min:0'
        ]);

        $bundling->update($request->all());

        return redirect()->route('bundling.index')
            ->with('success', 'Bundling berhasil diupdate');
    }

    public function destroy($id)
    {
        $bundling = Bundling::findOrFail($id);
        $bundling->delete();

        return redirect()->route('bundling.index')
            ->with('success', 'Bundling berhasil dihapus');
    }
}
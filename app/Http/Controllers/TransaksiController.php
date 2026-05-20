<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Transaksi;
use App\Models\TransaksiDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Customer;

class TransaksiController extends Controller
{

    public function index()
    {
        //ambil data transaksi dari model transaksi dengan relasi user, urutkan dari yang terbaru
        $transaksis = Transaksi::with('user')->latest();

        if (auth()->user()->role_id == 1) {
            // jika yang login adalah user dengan ID=1 atau admin, maka ambil semua data transaksi 
            $transaksis = $transaksis->get();

        } else {
            // Jika bukan admin, maka ambil transaksi yang user_id nya sama dengan ID user yang sedang login dan ambil datanya.
            $transaksis = $transaksis->where('user_id', auth()->id())->get();
        }
        // tampilkan ke view dengan membawa data transaksi
        return view('transaksi.index', compact('transaksis'));
    }


    public function create()
    {
        // ambil data menu beserta diskonnya yang statusnya tersedia dan urutkan dari yang terbaru
       $menus = Menu::with('diskon')->where('status', 'tersedia')
    ->latest()
    ->get();
    $customers = Customer:: latest()->get();

        // tampilkan ke view dengan membawa data menu
        return view('transaksi.create',compact('menus', 'customers')
        );
    }
    public function store(Request $request)
    {
        // validasi
        $request->validate([
            'customer_id' => 'nullable|exists:customers,id',
            'total_harga' => 'required|numeric',
            'uang_bayar' =>'required|numeric|min:' .$request->total_harga,
            'metode_pembayaran' => 'required',
            'menu' => 'required'
        ]);
        // menu yang dikirim dari form berupa string JSON maka harus di decode terlebih dahulu menjadi array
        $menu = json_decode($request->menu,true
        );


        // simpan transaksi
        $transaksi = Transaksi::create([
            'user_id' => Auth::id(),
            'customer_id' => $request->customer_id,
            'total_harga' => $request->total_harga,
            'uang_bayar' => $request->uang_bayar,
            'kembalian' => $request->uang_bayar - $request->total_harga,
            'metode_pembayaran' =>$request->metode_pembayaran,
            'status' => 'selesai',
            'waktu' => now()

        ]);     
        // simpan detail   
        foreach ($menu as $m) {

            TransaksiDetail::create([

                'transaksi_id' =>$transaksi->id,
                'menu_id' => $m ['id'],
                'jumlah' => $m ['jumlah'],
                'harga' => $m ['harga'],
                'subtotal' => $m ['jumlah'] * $m ['harga']

            ]);

        }

        return redirect()->route('transaksi.index')->with('success','Transaksi berhasil');
    }

    public function show(Transaksi $transaksi)
    {
        $transaksi->load('detail.menu');

        return view(
            'transaksi.show',
            compact('transaksi')
        );
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Transaksi;
use App\Models\TransaksiDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Customer;
use App\Models\Kategori;

class TransaksiController extends Controller
{

    public function index()
    {
        //ambil data transaksi dari model transaksi dengan relasi user, urutkan dari yang terbaru
        $transaksis = Transaksi::with('user','customer')->latest();

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
    $menus = Menu::with('diskon', 'kategori')->where('status', 'tersedia')->latest()->get();
    $customers = Customer:: latest()->get();
    $kategoris = Kategori::get();

        // tampilkan ke view dengan membawa data menu
        return view('transaksi.create',compact('menus', 'customers', 'kategoris'));
    }
   public function store(Request $request)
  
{
   
    // VALIDASI
    $request->validate([

        'nama_customer' => 'nullable|string|max:255',

        'total_harga' => 'required|numeric',

        'uang_bayar' =>
            'required|numeric|min:' . $request->total_harga,

        'metode_pembayaran' => 'required',

        'menu' => 'required'

    ]);


    // DECODE JSON MENU
    $menu = json_decode($request->menu, true);



    // =========================
    // CUSTOMER
    // =========================

   

    // jika nama customer diisi
    $customerId = null;



// =========================
// JIKA PILIH CUSTOMER LAMA
// =========================

if ($request->customer_id) {

    $customerId = $request->customer_id;

}



// =========================
// JIKA TAMBAH CUSTOMER BARU
// =========================

elseif ($request->nama_customer) {

    $customer = Customer::firstOrCreate(

        [
            'nama' => $request->nama_customer
        ],

        [
            'no_hp' => $request->no_hp
        ]

    );

    $customerId = $customer->id;

}


    // =========================
    // SIMPAN TRANSAKSI
    // =========================

    $transaksi = Transaksi::create([

        'user_id' => Auth::id(),

        'customer_id' => $customerId,

        'total_harga' => $request->total_harga,

        'uang_bayar' => $request->uang_bayar,

        'kembalian' =>
            $request->uang_bayar -
            $request->total_harga,

        'metode_pembayaran' =>
            $request->metode_pembayaran,

        'status' => 'selesai',

        'waktu' => now()

    ]);



    // =========================
    // SIMPAN DETAIL
    // =========================

    foreach ($menu as $m) {

        TransaksiDetail::create([

            'transaksi_id' => $transaksi->id,

            'menu_id' => $m['id'],

            'jumlah' => $m['jumlah'],

            'harga' => $m['harga'],

            'subtotal' =>
                $m['jumlah'] * $m['harga']

        ]);

    }


    return redirect()
        ->route('transaksi.index')
        ->with('success', 'Transaksi berhasil');
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
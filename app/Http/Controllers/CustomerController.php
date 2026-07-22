<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Transaksi;
use Illuminate\Http\Request;


class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::latest()->get();

        return view('customer.index', compact('customers'));
    }

    public function create()
    {
        return view('customer.create');
    }

    public function storeAjax(Request $request)
    {
        $customer = Customer::create([
            'nama' => $request->nama,
            'no_hp' => $request->no_hp,
        ]);

        return response()->json($customer);
    }

    public function show(Customer $customer)
{
    if (auth()->user()->role_id == 1) {
        // Admin melihat semua transaksi customer
        $transaksi = $customer->transaksis()
            ->with('user')
            ->latest()
            ->get();
    } else {
        // Kasir hanya melihat transaksi yang dia layani
        $transaksi = $customer->transaksis()
            ->with('user')
            ->where('user_id', auth()->id())
            ->latest()
            ->get();
    }

    return view('customer.show', compact('customer', 'transaksi'));
}

    public function edit(Customer $customer)
    {
        return view('customer.edit', compact('customer'));
    }

    public function update(Request $request, Customer $customer)
    {
        $request->validate([
            'nama' => 'required',
            'no_hp' => 'nullable|numeric',
        ]);

        $customer->update($request->all());

        return redirect()->route('customer.index')
            ->with('success', 'Customer berhasil diupdate');
    }
    
   


    public function destroy(Customer $customer)
    {
        $customer->delete();

        return redirect()->route('customer.index')
            ->with('success', 'Customer berhasil dihapus');
    }
}

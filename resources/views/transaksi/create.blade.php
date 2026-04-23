@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-5">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5><i class="fa fa-shopping-cart"></i> Keranjang Belanja</h5>
                </div>
                <div class="card-body" style="height: 400px; overflow-y: auto;">
                    <form action="{{ route('transaksi.store') }}" method="POST" id="form-transaksi">
                        @csrf
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Menu</th>
                                    <th>Qty</th>
                                    <th>Subtotal</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody id="cart-table">
                                </tbody>
                        </table>
                </div>
                <div class="card-footer">
                    <div class="form-group row">
                        <label class="col-sm-4">Total Harga</label>
                        <div class="col-sm-8">
                            <input type="number" name="total_harga" id="total_harga" class="form-control-plaintext font-weight-bold" readonly value="0">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4">Bayar</label>
                        <div class="col-sm-8">
                            <input type="number" name="uang_bayar" id="uang_bayar" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4">Kembalian</label>
                        <div class="col-sm-8">
                            <input type="number" id="kembalian" class="form-control-plaintext" readonly value="0">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success btn-block btn-lg">PROSES TRANSAKSI</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-7">
            <div class="card">
                <div class="card-header bg-light">
                    <input type="text" id="search-menu" class="form-control" placeholder="Cari menu...">
                </div>
                <div class="card-body" style="height: 600px; overflow-y: auto;">
                    <div class="row" id="menu-list">
                      @foreach($menus as $menu)
@php
    // Hitung harga akhir (setelah diskon jika ada)
    $hargaAkhir = $menu->harga_diskon; 
    $punyaDiskon = $hargaAkhir < $menu->harga;
@endphp

<div class="col-md-4 mb-3 menu-item" data-nama="{{ strtolower($menu->nama) }}">
    <div class="card h-100 shadow-sm btn-add-to-cart" 
         style="cursor:pointer;" 
         data-id="{{ $menu->id }}" 
         data-nama="{{ $menu->nama }}" 
         data-harga="{{ $hargaAkhir }}">
        
        <img src="{{ asset('images/'.$menu->gambar) }}" class="card-img-top" style="height: 120px; object-fit: cover;">
        
        <div class="card-body p-2 text-center">
            <h6 class="card-title mb-1">{{ $menu->nama }}</h6>
            
            @if($punyaDiskon)
                <small class="text-danger"><strike>Rp {{ number_format($menu->harga) }}</strike></small><br>
                <span class="badge badge-danger">Rp {{ number_format($hargaAkhir) }}</span>
            @else
                <span class="badge badge-success">Rp {{ number_format($menu->harga) }}</span>
            @endif
        </div>
    </div>
</div>
@endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    let cart = [];

    // Fungsi Tambah ke Keranjang
    document.querySelectorAll('.btn-add-to-cart').forEach(card => {
        card.addEventListener('click', function() {
            const id = this.dataset.id;
            const nama = this.dataset.nama;
            const harga = parseInt(this.dataset.harga);

            const existingItem = cart.find(item => item.menu_id === id);

            if (existingItem) {
                existingItem.jumlah++;
            } else {
                cart.push({ menu_id: id, nama: nama, harga: harga, jumlah: 1 });
            }
            renderCart();
        });
    });

    // Render Tabel Keranjang
    function renderCart() {
        const tbody = document.getElementById('cart-table');
        tbody.innerHTML = '';
        let total = 0;

        cart.forEach((item, index) => {
            const subtotal = item.harga * item.jumlah;
            total += subtotal;

            tbody.innerHTML += `
                <tr>
                    <td>${item.nama}</td>
                    <td>
                        <input type="hidden" name="items[${index}][menu_id]" value="${item.menu_id}">
                        <input type="hidden" name="items[${index}][harga]" value="${item.harga}">
                        <input type="number" name="items[${index}][jumlah]" value="${item.jumlah}" class="form-control form-control-sm" min="1" onchange="updateQty(${index}, this.value)">
                    </td>
                    <td>Rp ${subtotal.toLocaleString()}</td>
                    <td><button type="button" class="btn btn-danger btn-sm" onclick="removeItem(${index})">x</button></td>
                </tr>
            `;
        });

        document.getElementById('total_harga').value = total;
        hitungKembalian();
    }

    function updateQty(index, val) {
        cart[index].jumlah = parseInt(val);
        renderCart();
    }

    function removeItem(index) {
        cart.splice(index, 1);
        renderCart();
    }

    // Hitung Kembalian Otomatis
    document.getElementById('uang_bayar').addEventListener('input', hitungKembalian);

    function hitungKembalian() {
        const total = parseInt(document.getElementById('total_harga').value);
        const bayar = parseInt(document.getElementById('uang_bayar').value) || 0;
        document.getElementById('kembalian').value = bayar - total;
    }

    // Filter Pencarian Menu
    document.getElementById('search-menu').addEventListener('keyup', function() {
        const keyword = this.value.toLowerCase();
        document.querySelectorAll('.menu-item').forEach(item => {
            const nama = item.dataset.nama;
            item.style.display = nama.includes(keyword) ? 'block' : 'none';
        });
    });
</script>
@endsection
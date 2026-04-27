@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- KERANJANG BELANJA -->
        <div class="col-md-5">
            <div class="card shadow border-0">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fa fa-shopping-cart"></i> Keranjang</h5>
                </div>
                <div class="card-body" style="height: 400px; overflow-y: auto;">
                    <form action="{{ route('transaksi.store') }}" method="POST" id="form-transaksi">
                        @csrf
                        <table class="table table-sm">
                            <thead class="bg-light">
                                <tr>
                                    <th>Menu</th>
                                    <th width="80px">Qty</th>
                                    <th>Subtotal</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody id="cart-table">
                                <!-- Item masuk sini lewat JS -->
                            </tbody>
                        </table>
                </div>
                <div class="card-footer bg-white">
                    <div class="form-group row">
                        <label class="col-sm-5 col-form-label">Total Harus Bayar</label>
                        <div class="col-sm-7">
                            <input type="number" name="total_harga" id="total_harga" class="form-control-plaintext font-weight-bold text-danger h4" readonly value="0">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-5 col-form-label">Uang Bayar (Rp)</label>
                        <div class="col-sm-7">
                            <input type="number" name="uang_bayar" id="uang_bayar" class="form-control form-control-lg border-primary" required oninput="hitungKembalian()">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-5 col-form-label">Kembalian</label>
                        <div class="col-sm-7">
                            <input type="number" id="kembalian" class="form-control-plaintext font-weight-bold" readonly value="0">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success btn-block btn-lg shadow">PROSES TRANSAKSI</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- DAFTAR MENU -->
        <div class="col-md-7">
            <div class="card shadow border-0">
                <div class="card-header bg-light">
                    <input type="text" id="search-menu" class="form-control" placeholder="Cari nama menu..." onkeyup="filterMenu()">
                </div>
                <div class="card-body" style="height: 600px; overflow-y: auto;">
                    <div class="row" id="menu-list">
                        @foreach($menus as $menu)
                        <div class="col-md-4 mb-3 menu-item" data-nama="{{ strtolower($menu->nama) }}">
                            <!-- KUNCI PERBAIKAN: Atribut data-diskon harus ada -->
                            <div class="card h-100 shadow-sm btn-add-to-cart" 
                                 style="cursor:pointer; transition: 0.3s;" 
                                 data-id="{{ $menu->id }}" 
                                 data-nama="{{ $menu->nama }}" 
                                 data-harga="{{ $menu->harga }}"
                                 data-diskon="{{ $menu->diskon ?? 0 }}">
                                
                                <img src="{{ asset('images/'.$menu->gambar) }}" class="card-img-top" style="height: 120px; object-fit: cover;">
                                <div class="card-body p-2 text-center">
                                    <h6 class="card-title mb-1 text-truncate">{{ $menu->nama }}</h6>
                                    
                                    @if($menu->diskon > 0)
                                        <small class="text-muted" style="text-decoration: line-through;">Rp {{ number_format($menu->harga) }}</small><br>
                                        <span class="badge badge-danger">Disc Rp {{ number_format($menu->diskon) }}</span><br>
                                        <b class="text-success">Rp {{ number_format($menu->harga - $menu->diskon) }}</b>
                                    @else
                                        <b class="text-success">Rp {{ number_format($menu->harga) }}</b>
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

    // 1. Fungsi Klik Menu
    document.querySelectorAll('.btn-add-to-cart').forEach(card => {
        card.addEventListener('click', function() {
            const id = this.dataset.id;
            const nama = this.dataset.nama;
            const harga = parseInt(this.dataset.harga);
            const diskon = parseInt(this.dataset.diskon) || 0; // Pastikan angka

            const existingItem = cart.find(item => item.menu_id === id);

            if (existingItem) {
                existingItem.jumlah++;
            } else {
                cart.push({ 
                    menu_id: id, 
                    nama: nama, 
                    harga: harga, 
                    diskon: diskon, 
                    jumlah: 1 
                });
            }
            renderCart();
        });
    });

    // 2. Render Tabel Keranjang
    function renderCart() {
        const tbody = document.getElementById('cart-table');
        tbody.innerHTML = '';
        let totalKeseluruhan = 0;

        cart.forEach((item, index) => {
            // Logika Diskon: (Harga Asli - Potongan) * Qty
            const hargaNetto = item.harga - item.diskon;
            const subtotal = hargaNetto * item.jumlah;
            totalKeseluruhan += subtotal;

            tbody.innerHTML += `
                <tr>
                    <td>
                        <small class="font-weight-bold">${item.nama}</small>
                        ${item.diskon > 0 ? `<br><small class="badge badge-warning text-dark">Potongan: ${item.diskon.toLocaleString()}</small>` : ''}
                    </td>
                    <td>
                        <input type="hidden" name="items[${index}][menu_id]" value="${item.menu_id}">
                        <input type="hidden" name="items[${index}][harga]" value="${item.harga}">
                        <input type="hidden" name="items[${index}][diskon]" value="${item.diskon}">
                        <input type="number" name="items[${index}][jumlah]" value="${item.jumlah}" 
                               class="form-control form-control-sm" min="1" 
                               onchange="updateQty(${index}, this.value)">
                    </td>
                    <td class="text-right">${subtotal.toLocaleString()}</td>
                    <td>
                        <button type="button" class="btn btn-sm text-danger" onclick="hapusItem(${index})">
                            <i class="fa fa-trash"></i>
                        </button>
                    </td>
                </tr>`;
        });

        document.getElementById('total_harga').value = totalKeseluruhan;
        hitungKembalian();
    }

    // 3. Update Jumlah (Qty)
    function updateQty(index, qty) {
        if (qty < 1) qty = 1;
        cart[index].jumlah = parseInt(qty);
        renderCart();
    }

    // 4. Hapus Item dari Keranjang
    function hapusItem(index) {
        cart.splice(index, 1);
        renderCart();
    }

    // 5. Hitung Kembalian Otomatis
    function hitungKembalian() {
        const total = parseInt(document.getElementById('total_harga').value) || 0;
        const bayar = parseInt(document.getElementById('uang_bayar').value) || 0;
        const sisa = bayar - total;
        document.getElementById('kembalian').value = sisa;
    }

    // 6. Filter Pencarian Menu
    function filterMenu() {
        const keyword = document.getElementById('search-menu').value.toLowerCase();
        document.querySelectorAll('.menu-item').forEach(item => {
            const nama = item.dataset.nama;
            item.style.display = nama.includes(keyword) ? '' : 'none';
        });
    }
</script>
@endsection

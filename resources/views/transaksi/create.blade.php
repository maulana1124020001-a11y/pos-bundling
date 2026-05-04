@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">

            {{-- ================== KERANJANG ================== --}}
            <div class="col-md-5">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5><i class="fa fa-shopping-cart"></i> Keranjang Belanja</h5>
                    </div>

                    <div class="card-body" style="height: 400px; overflow-y: auto;">
                        <form action="{{ route('transaksi.store') }}" method="POST">
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
                                <tbody id="cart-table"></tbody>
                            </table>
                    </div>

                    <div class="card-footer">
                        <div class="form-group row">
                            <label class="col-sm-4">Total Harga</label>
                            <div class="col-sm-8">
                                <input type="number" name="total_harga" id="total_harga"
                                    class="form-control-plaintext font-weight-bold" readonly value="0">
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

                        <div class="form-group row">
                            <label class="col-sm-4">Metode Pembayaran</label>
                            <div class="col-sm-8">
                                <select name="metode_pembayaran" class="form-control">
                                    <option value="cash">Cash</option>
                                    <option value="qris">QRIS</option>
                                    <option value="transfer">Transfer</option>
                                </select>
                            </div>
                        </div>

                        {{-- CUSTOMER --}}
                        <div class="form-group row">
                            <label class="col-sm-4">Customer</label>
                            <div class="col-sm-6">
                                <select name="customer_id" id="customer_id" class="form-control">
                                    <option value=""></option>
                                    @foreach ($customers as $customer)
                                        <option value="{{ $customer->id }}">{{ $customer->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-2">
                                <button type="button" class="btn btn-primary" data-toggle="modal"
                                    data-target="#modalCustomer">+</button>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-success btn-block btn-lg">
                            PROSES TRANSAKSI
                        </button>
                        </form>
                    </div>
                </div>
            </div>

            {{-- ================== MENU ================== --}}
            <div class="col-md-7">
                <div class="card">

                    {{-- SEARCH + FILTER --}}
                    <div class="card-header bg-light">
                        <div class="row">
                            <div class="col-md-6">
                                <input type="text" id="search-menu" class="form-control" placeholder="Cari menu...">
                            </div>
                            <div class="col-md-6">
                                <select id="filter-kategori" class="form-control">
                                    <option value="">Semua Kategori</option>
                                    @foreach ($kategoris as $kategori)
                                        <option value="{{ $kategori->id }}">{{ $kategori->nama_kategori }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="card-body" style="height: 600px; overflow-y: auto;">
                        <div class="row" id="menu-list">

                            @foreach ($menus as $menu)
                                @php
                                    $hargaAkhir = $menu->harga_diskon;
                                    $punyaDiskon = $hargaAkhir < $menu->harga;
                                @endphp

                                <div class="col-md-4 mb-3 menu-item" data-nama="{{ strtolower($menu->nama) }}"
                                    data-kategori="{{ $menu->kategori_id }}">

                                    <div class="card h-100 shadow-sm btn-add-to-cart" style="cursor:pointer;"
                                        data-id="{{ $menu->id }}" data-nama="{{ $menu->nama }}"
                                        data-harga="{{ $hargaAkhir }}">

                                        <img src="{{ asset('images/' . $menu->gambar) }}" class="card-img-top"
                                            style="height:120px; object-fit:cover;">

                                        <div class="card-body p-2 text-center">
                                            <h6>{{ $menu->nama }}</h6>

                                            @if ($punyaDiskon)
                                                <small class="text-danger">
                                                    <strike>Rp {{ number_format($menu->harga) }}</strike>
                                                </small><br>
                                                <span class="badge badge-danger">
                                                    Rp {{ number_format($hargaAkhir) }}
                                                </span>
                                            @else
                                                <span class="badge badge-success">
                                                    Rp {{ number_format($menu->harga) }}
                                                </span>
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

    {{-- ================== MODAL CUSTOMER ================== --}}
    <div class="modal fade" id="modalCustomer">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h5>Tambah Customer</h5>
                    <button class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <input type="text" id="cust_nama" class="form-control mb-2" placeholder="Nama">
                    <input type="text" id="cust_hp" class="form-control" placeholder="No HP">
                </div>

                <div class="modal-footer">
                    <button class="btn btn-success" onclick="simpanCustomer()">Simpan</button>
                    <button class="btn btn-secondary" data-dismiss="modal">Batal</button>
                </div>

            </div>
        </div>
    </div>

    {{-- ================== SCRIPT ================== --}}
    <script>
        let cart = [];

        // tambah ke cart
        document.querySelectorAll('.btn-add-to-cart').forEach(card => {
            card.addEventListener('click', function() {
                let id = this.dataset.id;
                let nama = this.dataset.nama;
                let harga = parseInt(this.dataset.harga);

                let item = cart.find(i => i.menu_id == id);

                if (item) {
                    item.jumlah++;
                } else {
                    cart.push({
                        menu_id: id,
                        nama: nama,
                        harga: harga,
                        jumlah: 1
                    });
                }

                renderCart();
            });
        });

        // render cart
        function renderCart() {
            let tbody = document.getElementById('cart-table');
            tbody.innerHTML = '';
            let total = 0;

            cart.forEach((item, index) => {
                let subtotal = item.harga * item.jumlah;
                total += subtotal;

                tbody.innerHTML += `
        <tr>
            <td>${item.nama}</td>
            <td>
                <input type="hidden" name="items[${index}][menu_id]" value="${item.menu_id}">
                <input type="hidden" name="items[${index}][harga]" value="${item.harga}">
                <input type="number" name="items[${index}][jumlah]" value="${item.jumlah}"
                    class="form-control form-control-sm" min="1"
                    onchange="updateQty(${index},this.value)">
            </td>
            <td>Rp ${subtotal.toLocaleString()}</td>
            <td><button type="button" class="btn btn-danger btn-sm" onclick="removeItem(${index})">x</button></td>
        </tr>`;
            });

            document.getElementById('total_harga').value = total;
            hitungKembalian();
        }

        function updateQty(i, val) {
            cart[i].jumlah = parseInt(val);
            renderCart();
        }

        function removeItem(i) {
            cart.splice(i, 1);
            renderCart();
        }

        // kembalian
        document.getElementById('uang_bayar').addEventListener('input', hitungKembalian);

        function hitungKembalian() {
            let total = parseInt(document.getElementById('total_harga').value) || 0;
            let bayar = parseInt(document.getElementById('uang_bayar').value) || 0;
            document.getElementById('kembalian').value = bayar - total;
        }

        // filter menu
        document.getElementById('search-menu').addEventListener('keyup', filterMenu);
        document.getElementById('filter-kategori').addEventListener('change', filterMenu);

        function filterMenu() {
            let keyword = document.getElementById('search-menu').value.toLowerCase();
            let kategori = document.getElementById('filter-kategori').value;

            document.querySelectorAll('.menu-item').forEach(item => {
                let nama = item.dataset.nama;
                let kat = item.dataset.kategori;

                let cocokNama = nama.includes(keyword);
                let cocokKategori = kategori === '' || kat === kategori;

                item.style.display = (cocokNama && cocokKategori) ? 'block' : 'none';
            });
        }

        // tambah customer
        function simpanCustomer() {
            let nama = document.getElementById('cust_nama').value;
            let hp = document.getElementById('cust_hp').value;

            if (!nama) {
                alert('Nama wajib diisi');
                return;
            }

            let select = document.getElementById('customer_id');
            let option = new Option(nama + ' (' + hp + ')', '', true, true);
            select.append(option);

            $('#modalCustomer').modal('hide');
        }
    </script>
@endsection

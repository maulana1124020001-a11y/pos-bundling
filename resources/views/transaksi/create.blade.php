@extends('layouts.app')
@section('content')

<div class="container-fluid px-2 px-md-3">

    <div class="row">

        <!-- MENU -->
        <div class="col-12 col-lg-7 mb-3">

            <!-- SEARCH & FILTER -->
            <div class="row mb-3">
                <div class="col-12 col-sm-6 mb-2 mb-sm-0">
                    <input type="text" id="search" class="form-control form-control-sm" placeholder="Cari menu...">
                </div>

                <div class="col-12 col-sm-6">
                    <select id="filter-kategori" class="form-control form-control-sm">
                        <option value="">Semua Kategori</option>

                        @foreach($kategoris as $k)
                        <option value="{{ strtolower($k->nama_kategori) }}">
                            {{ $k->nama_kategori }}
                        </option>
                        @endforeach

                    </select>
                </div>

            </div>

            <!-- LIST MENU -->
            <div class="row row-cols-2 row-cols-sm-2 row-cols-md-3 row-cols-lg-3 row-cols-xl-4 g-2" id="menu-wrapper">

                @foreach($menus as $menu)

                <div class="col mb-2 menu-item-target">


                    <div class="card h-100 shadow-sm border-0 menu-card btn-add position-relative" style="cursor:pointer;" 
                        data-id="{{ $menu->id }}" 
                        data-nama="{{ $menu->nama }}"
                        data-kategori="{{ strtolower($menu->kategori->nama_kategori ?? '') }}"
                        data-harga="{{ $menu->harga_diskon }}">

                        @if($menu->ada_diskon)

                        <span class="badge badge-danger position-absolute"
                            style="top:6px; left:6px; z-index:5; font-size:70%;">

                            {{ $menu->diskon->tipe_diskon == 'Persen'
                    ? $menu->diskon->diskon_persen . '%'
                    : 'Rp ' . number_format($menu->diskon->diskon_nominal) }}

                        </span>

                        @endif

                        <img src="{{ $menu->gambar 
                    ? asset('images/' . $menu->gambar) 
                    : 'https://logodix.com/logo/1993885.png' }}" class="card-img-top"
                            style="height:140px; object-fit:cover;"
                            onerror="this.onerror=null;this.src='https://logodix.com/logo/1993885.png';">

                        <div class="card-body p-2 text-center" style="line-height:1.2;">

                            <span class="font-weight-bold d-block text-truncate small mb-1" title="{{ $menu->nama }}">

                                {{ $menu->nama }}

                            </span>

                            <div>

                                @if($menu->ada_diskon)

                                <div class="text-muted" style="font-size:70%;">

                                    <del>
                                        Rp {{ number_format($menu->harga) }}
                                    </del>

                                </div>

                                <span class="text-danger font-weight-bold small">

                                    Rp {{ number_format($menu->harga_diskon) }}

                                </span>

                                @else

                                <span class="text-success font-weight-bold small">

                                    Rp {{ number_format($menu->harga) }}

                                </span>

                                @endif

                            </div>

                        </div>

                    </div>

                </div>

                @endforeach

            </div>

        </div>

        <!-- TRANSAKSI -->
        <div class="col-12 col-lg-5 mb-4">

            <div class="card shadow-sm border-0">

                <div class="card-header bg-primary text-white p-2 p-md-3">

                    <h6 class="mb-0 font-weight-bold">
                        Keranjang
                    </h6>

                </div>

                <form action="{{ route('transaksi.store') }}" method="POST" id="form-transaksi">

                    @csrf

                    <input type="hidden" name="menu" id="menu">

                    <div class="card-body p-1 p-sm-2">

                        <div class="table-responsive" style="max-height:320px; overflow-y:auto; overflow-x:hidden;">

                            <table class="table table-bordered table-sm mb-0 text-center small">

                                <thead class="bg-light">

                                    <tr>
                                        <th class="text-left">Menu</th>
                                        <th style="width:25%">Qty</th>
                                        <th>Subtotal</th>
                                        <th>Hapus</th>
                                    </tr>

                                </thead>

                                <tbody id="cart-table"></tbody>

                            </table>

                        </div>

                    </div>

                    <!-- PEMBAYARAN -->
                    <div class="card-footer bg-white">

                        <!-- TOTAL -->
                        <div class="form-group mb-2">

                            <label class="small font-weight-bold mb-1">
                                Total Harga
                            </label>

                            <div class="input-group">

                                <div class="input-group-prepend">
                                    <span class="input-group-text">Rp</span>
                                </div>

                                <input type="text" name="total_harga" id="total_harga"
                                    class="form-control font-weight-bold text-danger" value="0" readonly>

                            </div>

                        </div>

                        <!-- BAYAR -->
                        <div class="row">

                            <div class="col-12 col-md-6 mb-2">

                                <div class="form-group mb-0">

                                    <label class="small font-weight-bold mb-1">
                                        Uang Bayar
                                    </label>

                                    <div class="input-group">

                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Rp</span>
                                        </div>



                                        <input type="text" name="uang_bayar" id="uang_bayar" class="form-control"
                                            autocomplete="off" required>

                                    </div>

                                </div>

                            </div>

                            <!-- KEMBALIAN -->
                            <div class="col-12 col-md-6">

                                <div class="form-group mb-0">

                                    <label class="small font-weight-bold mb-1">
                                        Kembalian
                                    </label>

                                    <div class="input-group">

                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Rp</span>
                                        </div>

                                        <input type="text" id="kembalian" class="form-control" value="0" readonly>

                                    </div>

                                </div>

                            </div>

                        </div>

                        <!-- METODE -->
                        <div class="row mt-2">

                            <div class="col-12 col-md-6 mb-2">

                                <div class="form-group mb-0">

                                    <label class="small font-weight-bold mb-1">
                                        Metode
                                    </label>

                                    <select name="metode_pembayaran" class="form-control">

                                        <option value="cash">Cash</option>
                                        <option value="qris">QRIS</option>
                                        <option value="transfer">Transfer</option>

                                    </select>

                                </div>

                            </div>

                            <!-- CUSTOMER -->
                            <div class="col-12 col-md-6">

                                <div class="form-group mb-0">

                                    <label class="small font-weight-bold mb-1">
                                        Customer
                                    </label>

                                    <div class="input-group">

                                        <select name="customer_id" id="customer_id" class="form-control">

                                            <option value="">-- Umum --</option>

                                            @foreach ($customers as $customer)

                                            <option value="{{ $customer->id }}">
                                                {{ $customer->nama }}
                                            </option>

                                            @endforeach

                                        </select>

                                        <div class="input-group-append">

                                            <button type="button" class="btn btn-primary" id="btnTambahCustomer">

                                                +

                                            </button>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                        <!-- BUTTON -->
                        <button type="submit" class="btn btn-success btn-block font-weight-bold shadow-sm py-2 mt-3">

                            PROSES TRANSAKSI

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

</div>

<!-- MODAL CUSTOMER -->
<div class="modal fade" id="modalCustomer" tabindex="-1">

    <div class="modal-dialog modal-dialog-centered modal-sm">

        <div class="modal-content border-0 shadow">

            <div class="modal-header bg-light p-2 px-3">

                <h6 class="modal-title font-weight-bold">
                    Tambah Customer
                </h6>

            </div>

            <div class="modal-body p-3">

                <div class="form-group mb-2">

                    <label class="small font-weight-bold mb-1">
                        Nama Customer
                    </label>

                    <input type="text" id="inputNamaCustomer" class="form-control form-control-sm" placeholder="Nama">

                    <small class="text-danger d-block mt-1" id="textErrorCustomer"></small>

                </div>

                <div class="form-group mb-0">

                    <label class="small font-weight-bold mb-1">
                        No HP
                    </label>

                    <input type="text" id="inputNoHpCustomer" class="form-control form-control-sm" placeholder="No HP">

                </div>

            </div>

            <div class="modal-footer bg-light p-2">

                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">

                    Batal

                </button>

                <button type="button" class="btn btn-sm btn-success" id="btnSimpanCustomer">

                    Simpan

                </button>

            </div>

        </div>

    </div>

</div>

<!-- AJAX CUSTOMER -->
<script>
document.addEventListener('DOMContentLoaded', function() {

    const ambilElemen = (id) => document.getElementById(id);

    ambilElemen('btnTambahCustomer').addEventListener('click', function() {

        ambilElemen('inputNamaCustomer').value = '';
        ambilElemen('inputNoHpCustomer').value = '';
        ambilElemen('textErrorCustomer').innerText = '';

        $('#modalCustomer').modal('show');

    });

    ambilElemen('btnSimpanCustomer').addEventListener('click', function() {

        let namaCustomer =
            ambilElemen('inputNamaCustomer').value.trim();

        let nomorHpCustomer =
            ambilElemen('inputNoHpCustomer').value.trim();

        if (!namaCustomer) {

            return ambilElemen('textErrorCustomer').innerText =
                'Nama customer wajib diisi';

        }

        fetch('/customer/store-ajax', {

                method: 'POST',

                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document
                        .querySelector('meta[name="csrf-token"]')
                        .content
                },

                body: JSON.stringify({
                    nama: namaCustomer,
                    no_hp: nomorHpCustomer
                })

            })

            .then(res => res.json())

            .then(dataCustomerBaru => {

                ambilElemen('customer_id')
                    .add(new Option(
                        dataCustomerBaru.nama,
                        dataCustomerBaru.id
                    ));

                ambilElemen('customer_id').value =
                    dataCustomerBaru.id;

                $('#modalCustomer').modal('hide');

            })

            .catch(errorSistem => {

                console.log(
                    "Terjadi kesalahan:",
                    errorSistem
                );

            });

    });

});
</script>

<script src="{{ asset('js/transaksi.js') }}"></script>
<script src="{{ asset('js/filter.js') }}"></script>

@endsection
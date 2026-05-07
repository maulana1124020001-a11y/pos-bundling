@extends('layouts.app')

@section('content')

    {{-- CSRF token dipakai oleh fetch/AJAX di transaksi.js --}}
    

    <div class="container-fluid">
        <div class="row">

            {{-- ===================================================== --}}
            {{-- KIRI = KERANJANG --}}
            {{-- ===================================================== --}}
            <div class="col-md-5">

                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">
                            <i class="fa fa-shopping-cart"></i>
                            Keranjang Belanja
                        </h5>
                    </div>

                    <div class="card-body" style="height:400px; overflow-y:auto;">

                        {{-- form ini akan di-submit via AJAX oleh transaksi.js --}}
                       {{-- form transaksi --}}
<form action="{{ route('transaksi.store') }}"
      method="POST"
      id="form-transaksi">

    @csrf

    {{-- cart json --}}
    <input type="hidden" name="items" id="items">

    <table class="table table-sm table-bordered">
        <thead class="thead-light">
            <tr>
                <th>Menu</th>
                <th width="100">Qty</th>
                <th>Subtotal</th>
                <th width="50">Aksi</th>
            </tr>
        </thead>

        <tbody id="cart-table">
            {{-- isi otomatis via javascript --}}
        </tbody>
    </table>

</div>

<div class="card-footer">

    {{-- TOTAL --}}
    <div class="form-group row">
        <label class="col-sm-4 col-form-label">
            Total Harga
        </label>

        <div class="col-sm-8">
            <input type="number"
                   name="total_harga"
                   id="total_harga"
                   class="form-control font-weight-bold"
                   value="0"
                   readonly>
        </div>
    </div>

    {{-- BAYAR --}}
    <div class="form-group row">
        <label class="col-sm-4 col-form-label">
            Bayar
        </label>

        <div class="col-sm-8">
            <input type="number"
                   name="uang_bayar"
                   id="uang_bayar"
                   class="form-control"
                   placeholder="Masukkan uang bayar"
                   required>
        </div>
    </div>

    {{-- KEMBALIAN --}}
    <div class="form-group row">
        <label class="col-sm-4 col-form-label">
            Kembalian
        </label>

        <div class="col-sm-8">
            <input type="number"
                   id="kembalian"
                   class="form-control"
                   value="0"
                   readonly>
        </div>
    </div>

    {{-- METODE PEMBAYARAN --}}
    <div class="form-group row">
        <label class="col-sm-4 col-form-label">
            Metode
        </label>

        <div class="col-sm-8">
            <select name="metode_pembayaran"
                    class="form-control">

                <option value="cash">Cash</option>
                <option value="qris">QRIS</option>
                <option value="transfer">Transfer</option>

            </select>
        </div>
    </div>

    {{-- CUSTOMER --}}
    <div class="form-group row">
        <label class="col-sm-4 col-form-label">
            Customer
        </label>

        <div class="col-sm-6">

            <select name="customer_id"
                    id="customer_id"
                    class="form-control">

                <option value="">
                    -- pilih customer --
                </option>

                @foreach ($customers as $customer)
                    <option value="{{ $customer->id }}">
                        {{ $customer->nama }}
                    </option>
                @endforeach

            </select>

        </div>

        <div class="col-sm-2">
            <button type="button"
                    class="btn btn-primary btn-block"
                    data-toggle="modal"
                    data-target="#modalCustomer">
                +
            </button>
        </div>
    </div>

    {{-- SUBMIT --}}
    <button type="submit"
            class="btn btn-success btn-block btn-lg">

        <i class="fa fa-check-circle"></i>
        PROSES TRANSAKSI

    </button>

</form>
                    </div>
                </div>

            </div>

            {{-- ===================================================== --}}
            {{-- KANAN = MENU --}}
            {{-- ===================================================== --}}
            <div class="col-md-7">

                <div class="card shadow">

                    {{-- SEARCH + FILTER --}}
                    <div class="card-header bg-light">

                        <div class="row">

                            {{-- search --}}
                            <div class="col-md-6 mb-2">
                                <input type="text" id="search-menu" class="form-control" placeholder="Cari menu...">
                            </div>

                            {{-- kategori --}}
                            <div class="col-md-6">
                                <select id="filter-kategori" class="form-control">

                                    <option value="">
                                        Semua Kategori
                                    </option>

                                    @foreach ($kategoris as $kategori)
                                        <option value="{{ $kategori->id }}">
                                            {{ $kategori->nama_kategori }}
                                        </option>
                                    @endforeach

                                </select>
                            </div>

                        </div>

                    </div>

                    {{-- LIST MENU --}}
                    <div class="card-body" style="height:600px; overflow-y:auto;">

                        <div class="row" id="menu-list">

                            @foreach ($menus as $menu)

                                @php
                                    $hargaAkhir = $menu->harga_diskon;
                                    $punyaDiskon = $hargaAkhir < $menu->harga;
                                @endphp

                                <div class="col-md-4 mb-3 menu-item" data-nama="{{ strtolower($menu->nama) }}"
                                    data-kategori="{{ $menu->kategori_id }}">

                                    <div class="card h-100 shadow-sm btn-add-to-cart" style="cursor:pointer"
                                        data-id="{{ $menu->id }}" data-nama="{{ $menu->nama }}" data-harga="{{ $hargaAkhir }}">

                                        {{-- gambar --}}
                                        <img src="{{ asset('images/' . $menu->gambar) }}" class="card-img-top"
                                            style="height:120px; object-fit:cover;">

                                        {{-- body --}}
                                        <div class="card-body text-center p-2">

                                            <h6 class="mb-2">
                                                {{ $menu->nama }}
                                            </h6>

                                            @if ($punyaDiskon)

                                                <small class="text-danger d-block">
                                                    <strike>
                                                        Rp {{ number_format($menu->harga) }}
                                                    </strike>
                                                </small>

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

    {{-- ===================================================== --}}
    {{-- MODAL TAMBAH CUSTOMER --}}
    {{-- ===================================================== --}}
    <div class="modal fade" id="modalCustomer">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="mb-0">Tambah Customer</h5>

                    <button class="close" data-dismiss="modal">
                        &times;
                    </button>
                </div>

                <div class="modal-body">

                    <input type="text" id="cust_nama" class="form-control mb-3" placeholder="Nama customer">

                    <input type="text" id="cust_no_hp" class="form-control" placeholder="Nomor HP">

                </div>

                <div class="modal-footer">

                    <button type="button" id="btn-simpan-customer" class="btn btn-success">
                        Simpan
                    </button>

                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        Batal
                    </button>

                </div>

            </div>
        </div>
    </div>

@endsection

{{-- load javascript transaksi --}}
<script src="{{ asset('js/transaksi.js') }}"></script>
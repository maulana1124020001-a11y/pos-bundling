@extends('layouts.app')

@section('content')

<div class="container-fluid px-2 px-md-4">

    <div class="row">

        <!-- ====================================================== -->
        <!-- KIRI : MENU -->
        <!-- ====================================================== -->
        <div class="col-12 col-lg-7 mb-4">

            <!-- SEARCH + FILTER -->
            <div class="row row-cols-1 row-cols-sm-2 g-2 mb-3">

                <!-- SEARCH -->
                <div class="col">

                    <input
                        type="text"
                        id="search"
                        class="form-control"
                        placeholder="Cari menu...">

                </div>


                <!-- FILTER -->
                <div class="col">

                    <select
                        id="filter-kategori"
                        class="form-control">

                        <option value="">
                            Semua Kategori
                        </option>

                        @foreach($kategoris as $k)

                        <option
                            value="{{ strtolower($k->nama_kategori) }}">

                            {{ $k->nama_kategori }}

                        </option>

                        @endforeach

                    </select>

                </div>

            </div>



            <!-- GRID MENU -->
            <div
                class="row row-cols-2 row-cols-sm-3 row-cols-md-3 row-cols-xl-4 g-2">

                @foreach($menus as $menu)

                <div class="col mb-3 menu-item-target">

                    <!-- CARD MENU -->
                    <div
                        class="card h-100 shadow-sm border-0 menu-card btn-add position-relative"
                        style="cursor:pointer"

                        data-id="{{ $menu->id }}"
                        data-nama="{{ strtolower($menu->nama) }}"
                        data-kategori="{{ strtolower($menu->kategori->nama_kategori ?? '') }}"
                        data-harga="{{ $menu->harga_diskon }}">

                        <!-- BADGE DISKON -->
                        @if($menu->ada_diskon)

                        <span
                            class="badge badge-danger position-absolute"
                            style="top:8px; left:8px; z-index:10;">

                            Diskon

                        </span>

                        @endif



                        <!-- GAMBAR -->
                        <img
                            src="{{ asset('images/' . $menu->gambar) }}"
                            class="card-img-top"
                            style="height:110px; object-fit:cover;">



                        <!-- BODY -->
                        <div
                            class="card-body p-2 text-center">

                            <!-- NAMA -->
                            <div
                                class="font-weight-bold small text-truncate mb-1">

                                {{ $menu->nama }}

                            </div>


                            <!-- HARGA -->
                            @if($menu->ada_diskon)

                            <div
                                class="text-muted"
                                style="font-size:12px;">

                                <del>
                                    Rp {{ number_format($menu->harga) }}
                                </del>

                            </div>

                            <div
                                class="text-danger font-weight-bold small">

                                Rp {{ number_format($menu->harga_diskon) }}

                            </div>

                            @else

                            <div
                                class="text-success font-weight-bold small">

                                Rp {{ number_format($menu->harga) }}

                            </div>

                            @endif

                        </div>

                    </div>

                </div>

                @endforeach

            </div>

        </div>



        <!-- ====================================================== -->
        <!-- KANAN : TRANSAKSI -->
        <!-- ====================================================== -->
        <div class="col-12 col-lg-5 mb-4">

            <div class="card shadow-sm border-0">

                <!-- HEADER -->
                <div class="card-header bg-primary text-white">

                    <h5 class="mb-0">
                        Keranjang
                    </h5>

                </div>



                <!-- FORM -->
                <form
                    action="{{ route('transaksi.store') }}"
                    method="POST"
                    id="form-transaksi">

                    @csrf

                    <!-- CART JSON -->
                    <input
                        type="hidden"
                        name="menu"
                        id="menu">



                    <!-- BODY -->
                    <div class="card-body p-2 p-md-3">

                        <!-- TABEL CART -->
                        <div
                            class="table-responsive"
                            style="max-height:250px; overflow-y:auto;">

                            <table
                                class="table table-bordered table-sm text-center mb-0">

                                <thead
                                    class="bg-light"
                                    style="position:sticky; top:0; z-index:1;">

                                    <tr>

                                        <th class="text-left">
                                            Menu
                                        </th>

                                        <th width="25%">
                                            Qty
                                        </th>

                                        <th>
                                            Subtotal
                                        </th>

                                        <th>
                                            Aksi
                                        </th>

                                    </tr>

                                </thead>

                                <!-- DIISI JS -->
                                <tbody id="cart-table">

                                </tbody>

                            </table>

                        </div>

                    </div>



                    <!-- FOOTER -->
                    <div class="card-footer bg-white">

                        <!-- TOTAL -->
                        <div class="form-group mb-2">

                            <label>Total Harga</label>

                            <input
                                type="number"
                                name="total_harga"
                                id="total_harga"
                                class="form-control"
                                value="0"
                                readonly>

                        </div>



                        <!-- BAYAR + KEMBALIAN -->
                        <div class="row">

                            <!-- BAYAR -->
                            <div class="col-md-6 form-group">

                                <label>Uang Bayar</label>

                                <input
                                    type="number"
                                    name="uang_bayar"
                                    id="uang_bayar"
                                    class="form-control"
                                    required>

                            </div>



                            <!-- KEMBALIAN -->
                            <div class="col-md-6 form-group">

                                <label>Kembalian</label>

                                <input
                                    type="number"
                                    id="kembalian"
                                    class="form-control"
                                    value="0"
                                    readonly>

                            </div>

                        </div>



                        <!-- METODE + CUSTOMER -->
                        <div class="row">

                            <!-- METODE -->
                            <div class="col-md-6 form-group">

                                <label>Metode</label>

                                <select
                                    name="metode_pembayaran"
                                    class="form-control">

                                    <option value="cash">
                                        Cash
                                    </option>

                                    <option value="qris">
                                        QRIS
                                    </option>

                                    <option value="transfer">
                                        Transfer
                                    </option>

                                </select>

                            </div>



                            <!-- CUSTOMER -->
                            <div class="col-md-6 form-group">

                                <label>Customer</label>



                                <!-- SELECT CUSTOMER -->
                                <div id="selectCustomerWrapper">

                                    <div class="d-flex">

                                        <!-- SELECT -->
                                        <select
                                            name="customer_id"
                                            id="customer_id"
                                            class="form-control">

                                            <option value="">
                                                -- Umum --
                                            </option>

                                            @foreach($customers as $customer)

                                            <option
                                                value="{{ $customer->id }}">

                                                {{ $customer->nama }}

                                            </option>

                                            @endforeach

                                        </select>



                                        <!-- BUTTON PLUS -->
                                        <button
                                            type="button"
                                            class="btn btn-primary ml-2"
                                            id="btnTambahCustomer">

                                            +

                                        </button>

                                    </div>

                                </div>



                                <!-- FORM CUSTOMER BARU -->
                                <div
                                    id="formCustomerBaru"
                                    style="display:none;">

                                    <!-- NAMA -->
                                    <div class="form-group mt-2">

                                        <label>Nama Customer</label>

                                        <input
                                            type="text"
                                            name="nama_customer"
                                            class="form-control">

                                    </div>



                                    <!-- NO HP -->
                                    <div class="form-group">

                                        <label>No HP</label>

                                        <input
                                            type="text"
                                            name="no_hp"
                                            class="form-control">

                                    </div>



                                    <!-- BATAL -->
                                    <button
                                        type="button"
                                        class="btn btn-secondary btn-sm"
                                        id="btnBatalCustomer">

                                        Batal

                                    </button>

                                </div>

                            </div>

                        </div>



                        <!-- BUTTON -->
                        <button
                            type="submit"
                            class="btn btn-success btn-block mt-3">

                            PROSES TRANSAKSI

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

</div>



<!-- ====================================================== -->
<!-- JS CUSTOMER -->
<!-- ====================================================== -->
<script>

document.addEventListener('DOMContentLoaded', function () {

    // tombol +
    const tombolTambah =
        document.getElementById('btnTambahCustomer');

    // tombol batal
    const tombolBatal =
        document.getElementById('btnBatalCustomer');

    // wrapper select
    const selectWrapper =
        document.getElementById('selectCustomerWrapper');

    // form customer baru
    const formCustomer =
        document.getElementById('formCustomerBaru');



    // =========================
    // SAAT TOMBOL + DIKLIK
    // =========================

    tombolTambah.addEventListener('click', function () {

        // sembunyikan select
        selectWrapper.style.display = 'none';

        // tampilkan form customer
        formCustomer.style.display = 'block';

    });



    // =========================
    // SAAT BATAL DIKLIK
    // =========================

    tombolBatal.addEventListener('click', function () {

        // tampilkan select lagi
        selectWrapper.style.display = 'block';

        // sembunyikan form
        formCustomer.style.display = 'none';



        // kosongkan input customer baru
        document.querySelector(
            'input[name="nama_customer"]'
        ).value = '';

        document.querySelector(
            'input[name="no_hp"]'
        ).value = '';

    });

});

</script>



<!-- JS -->
<script src="{{ asset('js/transaksi.js') }}"></script>
<script src="{{ asset('js/filter.js') }}"></script>

@endsection
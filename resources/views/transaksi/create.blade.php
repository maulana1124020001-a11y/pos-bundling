@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <div class="row">

        {{-- KIRI = KERANJANG --}}
        <div class="col-md-5">

            <div class="card shadow">

                <div class="card-header bg-primary text-white">

                    <h5 class="mb-0">
                        Keranjang
                    </h5>

                </div>

                {{-- FORM TRANSAKSI --}}
                <form action="{{ route('transaksi.store') }}" method="POST" id="form-transaksi">

                    @csrf

                    {{-- TEMPAT JSON CART --}}
                    <input type="hidden" name="menu" id="menu">

                    <div class="card-body">

                        <table class="table table-bordered">

                            <thead>

                                <tr>

                                    <th>Menu</th>
                                    <th>Jumlah</th>
                                    <th>Subtotal</th>
                                    <th>Hapus</th>

                                </tr>

                            </thead>

                            <tbody id="cart-table">

                            </tbody>

                        </table>

                    </div>

                    <div class="card-footer">

                        {{-- TOTAL --}}
                        <div class="form-group">

                            <label>Total Harga</label>

                            <input type="number" name="total_harga" id="total_harga" class="form-control" value="0"
                                readonly>

                        </div>


                        {{-- BAYAR --}}
                        <div class="form-group">

                            <label>Uang Bayar</label>

                            <input type="number" name="uang_bayar" id="uang_bayar" class="form-control" required>

                        </div>


                        {{-- KEMBALIAN --}}
                        <div class="form-group">

                            <label>Kembalian</label>

                            <input type="number" id="kembalian" class="form-control" value="0" readonly>

                        </div>


                        {{-- METODE PEMBAYARAN --}}
                        <div class="form-group">

                            <label>Metode Pembayaran</label>

                            <select name="metode_pembayaran" class="form-control">

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


                        <button type="submit" class="btn btn-success btn-block">

                            PROSES TRANSAKSI

                        </button>

                    </div>

                </form>

            </div>

        </div>


        {{-- KANAN = MENU --}}
        <div class="col-md-7">

            <div class="row">

                @foreach($menus as $menu)

                <div class="col-md-4 mb-3">

                    <div class="card shadow btn-add h-100" style="cursor:pointer" data-id="{{ $menu->id }}"
                        data-nama="{{ $menu->nama }}" data-harga="{{ $menu->harga_diskon }}">

                        {{-- GAMBAR --}}
                        <img src="{{ asset('images/' . $menu->gambar) }}" class="card-img-top"
                            style="height:150px; object-fit:cover;">

                        {{-- BODY --}}
                        <div class="card-body text-center" style="min-height:100px;">

                            <h6>
                                {{ $menu->nama }}
                            </h6>


                            {{-- HARGA --}}
                            @if($menu->ada_diskon)

                            <small class="badge badge-success">

                                <del>
                                    Rp {{ number_format($menu->harga) }}
                                </del>

                            </small>

                            <br>

                            <small class="text-danger">

                                Diskon
                                @if($menu->diskon->tipe_diskon == 'Persen')

                                {{ $menu->diskon->diskon_persen }}%

                                @else

                                Rp {{ number_format($menu->diskon->diskon_nominal) }}

                                @endif

                            </small>

                            <br>

                            <span class="badge badge-danger">

                                Rp {{ number_format($menu->harga_diskon) }}

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

@endsection

<script src="{{ asset('js/transaksi.js') }}"></script>
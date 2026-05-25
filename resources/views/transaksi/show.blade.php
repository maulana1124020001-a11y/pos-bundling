@extends('layouts.app')

@section('content')

<style>

    body{
        background:#eee;
        font-family:monospace;
    }

    .struk{

        width:58mm;

        margin:auto;

        background:#fff;

        padding:8px;

        font-size:11px;

        color:#000;

    }

    .center{
        text-align:center;
    }

    .right{
        text-align:right;
    }

    .small{
        font-size:10px;
    }

    .bold{
        font-weight:bold;
    }

    hr{

        border:none;

        border-top:1px dashed #000;

        margin:5px 0;

    }

    table{

        width:100%;

        border-collapse:collapse;

    }

    td{

        padding:1px 0;

        vertical-align:top;

    }

    .menu{
        margin-top:4px;
        font-weight:bold;
    }

    .coret{
        text-decoration:line-through;
        font-size:10px;
    }

    .btn-area{
        margin-top:20px;
        text-align:center;
    }

    /* PRINT */
    @media print {

        @page{
            size:58mm auto;
            margin:0;
        }

        html,
        body{

            width:58mm;

            margin:0;

            padding:0;

            background:#fff;

        }

        body *{
            visibility:hidden;
        }

        .struk,
        .struk *{
            visibility:visible;
        }

        .struk{

            position:absolute;

            left:0;

            top:0;

            width:58mm;

            margin:0;

            box-shadow:none;

        }

        .btn-area{
            display:none;
        }

    }

</style>

<div class="struk">

    {{-- HEADER --}}
    <div class="center">

        <div class="bold">
            TITIK TEMU
        </div>

        <div class="small">
            Jl. Contoh No.123
        </div>

        <div class="small">
            Telp 08123456789
        </div>

    </div>

    <hr>

    {{-- INFO --}}
    <table>

        <tr>
            <td>No</td>
            <td class="right">
                {{ $transaksi->kode_transaksi ?? $transaksi->id }}
            </td>
        </tr>

        <tr>
            <td>Kasir</td>
            <td class="right">
                {{ $transaksi->user->nama ?? '-' }}
            </td>
        </tr>

        <tr>
            <td>Customer</td>
            <td class="right">
                {{ $transaksi->customer->nama ?? 'Umum' }}
            </td>
        </tr>

        <tr>
            <td>Waktu</td>
            <td class="right">
                {{ $transaksi->waktu }}
            </td>
        </tr>

    </table>

    <hr>

    {{-- DETAIL --}}
    @foreach($transaksi->detail as $d)

        @php

            $hargaAsli = $d->menu->harga;

            $harga = $d->harga;

            $subtotal = $harga * $d->jumlah;

            $diskon = $d->menu->diskon ?? null;

        @endphp

        <div class="menu">

            {{ $d->menu->nama }}

        </div>

        {{-- harga asli --}}
        @if($hargaAsli != $harga)

            <div class="coret">

                Rp {{ number_format($hargaAsli) }}

            </div>

        @endif

        <table>

            <tr>

                <td width="20%">
                    {{ $d->jumlah }} x
                </td>

                <td class="right" width="30%">
                    {{ number_format($harga) }}
                </td>

                <td class="right" width="50%">
                    {{ number_format($subtotal) }}
                </td>

            </tr>

        </table>

        {{-- diskon --}}
        @if($diskon)

            <div class="small">

                Diskon :

                @if($diskon->tipe_diskon == 'Persen')

                    {{ $diskon->diskon_persen }}%

                @else

                    Rp {{ number_format($diskon->diskon_nominal) }}

                @endif

            </div>

        @endif

    @endforeach

    <hr>

    {{-- TOTAL --}}
    <table>

        <tr>

            <td class="bold">
                Total
            </td>

            <td class="right bold">
                Rp {{ number_format($transaksi->total_harga) }}
            </td>

        </tr>

        <tr>

            <td>
                Bayar
            </td>

            <td class="right">
                Rp {{ number_format($transaksi->uang_bayar) }}
            </td>

        </tr>

        <tr>

            <td>
                Kembali
            </td>

            <td class="right">
                Rp {{ number_format($transaksi->kembalian) }}
            </td>

        </tr>

    </table>

    <hr>

    {{-- FOOTER --}}
    <div class="center small">

        Terima Kasih 🙏

        <br>

        Selamat Menikmati

    </div>

</div>

<div class="btn-area">

    <button
        onclick="window.print()"
        class="btn btn-primary"
    >
        Print
    </button>

</div>

<script>

    window.onload = () => {

        window.print();

    }

</script>

@endsection
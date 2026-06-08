@extends('layouts.app')

@section('content')

<style>
    body {
        background-color: #f4f6f9;
        font-family: 'Courier New', Courier, monospace;
    }

    .struk-container {
        width: 58mm;
        max-width: 58mm;
        margin: 30px auto;
        background: #ffffff;
        padding: 12px 6px;
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
        box-sizing: border-box;
        color: #000000;
        font-size: 11px;
        line-height: 1.3;
    }

    .text-center {
        text-align: center;
    }

    .text-right {
        text-align: right;
    }

    .text-bold {
        font-weight: bold;
    }

    .text-small {
        font-size: 9px;
    }

    .harga-coret {
        text-decoration: line-through;
        font-size: 9px;
        color: #555;
    }

    .pembatas {
        border: none;
        border-top: 1px dashed #000000;
        margin: 6px 0;
    }

    .tabel-struk {
        width: 100%;
        border-collapse: collapse;
    }

    .tabel-struk td {
        padding: 2px 0;
        vertical-align: top;
    }

    .nama-item {
        font-weight: bold;
        margin-top: 4px;
        word-break: break-all;
    }

    .aksi-area {
        margin-top: 25px;
        text-align: center;
    }

    @media print {

        @page {
            size: 58mm auto;
            margin: 0mm;
        }

        html,
        body,
        .wrapper,
        .main-panel,
        nav,
        footer,
        .aksi-area {
            visibility: hidden !important;
            background: #ffffff !important;
            margin: 0 !important;
            padding: 0 !important;
        }

        .struk-container,
        .struk-container * {
            visibility: visible !important;
        }

        .struk-container {
            position: absolute;
            left: 0;
            top: 0;
            width: 58mm !important;
            margin: 0 !important;
            padding: 0 2mm 5mm 2mm !important;
            box-shadow: none !important;
            float: left;
        }
    }
</style>

<div class="struk-container">

```
{{-- HEADER TOKO --}}
<div class="text-center">

    <div class="text-bold" style="font-size: 14px;">
        TITIK TEMU
    </div>

    <div class="text-small">
        Terima Kasih Atas Kunjungan Anda
    </div>

</div>

<div class="pembatas"></div>

{{-- DATA TRANSAKSI --}}
<table class="tabel-struk">

    <tr>
        <td width="35%">No. Nota</td>

        <td class="text-right" width="65%">
            {{ $transaksi->kode_transaksi ?? $transaksi->id }}
        </td>
    </tr>

    <tr>
        <td>Kasir</td>

        <td class="text-right">
            {{ $transaksi->user->nama ?? '-' }}
        </td>
    </tr>

    <tr>
        <td>Pelanggan</td>

        <td class="text-right">
            {{ $transaksi->customer->nama ?? 'Umum' }}
        </td>
    </tr>

    <tr>
        <td>Waktu</td>

        <td class="text-right">
            {{ $transaksi->waktu }}
        </td>
    </tr>

</table>

<div class="pembatas"></div>

{{-- DETAIL BELANJA --}}
@foreach($transaksi->detail as $detail)

    @php
        $hargaAsli = $detail->menu->harga;
        $hargaJual = $detail->harga;
        $subtotal  = $hargaJual * $detail->jumlah;
    @endphp

    <div class="nama-item">

        {{ $detail->menu->nama }}

    </div>

    @if($hargaAsli != $hargaJual)

        <div class="harga-coret">

            Normal :
            Rp {{ number_format($hargaAsli) }}

        </div>

    @endif

    <table class="tabel-struk">

        <tr>

            <td width="30%">

                {{ $detail->jumlah }} x

            </td>

            <td class="text-right" width="30%">

                {{ number_format($hargaJual) }}

            </td>

            <td class="text-right" width="40%">

                {{ number_format($subtotal) }}

            </td>

        </tr>

    </table>

@endforeach

<div class="pembatas"></div>

{{-- TOTAL --}}
@php

    $totalBelanja = $transaksi->detail->sum(function($item) {

        return $item->harga * $item->jumlah;

    });

    $uangBayar = $transaksi->uang_bayar ?? 0;

    $kembalian = $uangBayar - $totalBelanja;

@endphp

<table class="tabel-struk">

    <tr class="text-bold">

        <td>TOTAL</td>

        <td class="text-right">

            Rp {{ number_format($totalBelanja) }}

        </td>

    </tr>

    <tr>

        <td>Bayar</td>

        <td class="text-right">

            Rp {{ number_format($uangBayar) }}

        </td>

    </tr>

    <tr class="text-bold">

        <td>Kembali</td>

        <td class="text-right">

            Rp {{ number_format($kembalian) }}

        </td>

    </tr>

</table>

<div class="pembatas"></div>

{{-- FOOTER --}}
<div class="text-center text-small" style="margin-top: 10px;">

    * BARANG YANG SUDAH DIBELI * <br>

    TIDAK DAPAT DITUKAR KEMBALI <br>

    Selamat Menikmati!

</div>
```

</div>

{{-- TOMBOL --}}

<div class="aksi-area container text-center my-4">

```
{{-- PRINT BROWSER --}}
<button
    onclick="window.print()"
    class="btn btn-success mx-1">

    Cetak Browser

</button>

{{-- PRINT THERMAL --}}
<a href="{{ route('transaksi.thermal', $transaksi->id) }}"
   class="btn btn-dark mx-1">

    Print Thermal

</a>

{{-- KEMBALI --}}
<a href="{{ route('transaksi.index') }}"
   class="btn btn-secondary mx-1">

    Kembali

</a>

{{-- TRANSAKSI BARU --}}
<a href="{{ route('transaksi.create') }}"
   class="btn btn-primary mx-1">

    Transaksi Baru

</a>
```

</div>

@endsection

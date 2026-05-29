@extends('layouts.app')

@section('content')

<style>
    body {
        background: #eee;
        font-family: 'Courier New', Courier, monospace; /* Memaksa font monospace standar printer */
    }

    .struk {
        width: 58mm;
        margin: auto;
        background: #fff;
        padding: 5px; /* Mengurangi padding agar area cetak maksimal */
        font-size: 12px; /* Ukuran ideal untuk printer thermal 58mm */
        color: #000;
        line-height: 1.2;
    }

    .center {
        text-align: center;
    }

    .right {
        text-align: right;
    }

    .small {
        font-size: 10px;
    }

    .bold {
        font-weight: bold;
    }

    hr {
        border: none;
        border-top: 1px dashed #000;
        margin: 6px 0;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    td {
        padding: 2px 0;
        vertical-align: top;
    }

    .menu {
        margin-top: 6px;
        font-weight: bold;
    }

    .coret {
        text-decoration: line-through;
        font-size: 10px;
    }

    .btn-area {
        margin-top: 20px;
        text-align: center;
    }

    /* PENGATURAN CETAK KHUSUS PRINTER THERMAL AQUOS 58 */
    @media print {
        @page {
            size: 58mm auto; /* Memaksa ukuran kertas thermal 58mm */
            margin: 0; /* Menghilangkan margin bawaan driver printer/browser */
        }

        html, body {
            width: 58mm;
            margin: 0;
            padding: 0;
            background: #fff;
            -webkit-print-color-adjust: exact; /* Memastikan warna hitam pekat */
            print-color-adjust: exact;
        }

        /* Sembunyikan semua elemen layout Laravel/Bootstrap bawaan */
        body * {
            visibility: hidden;
        }

        /* Tampilkan hanya area struk */
        .struk, .struk * {
            visibility: visible;
        }

        .struk {
            position: absolute;
            left: 0;
            top: 0;
            width: 58mm;
            padding: 0 2mm; /* Menghindari teks terpotong di pinggir kertas */
            box-shadow: none;
        }

        /* Sembunyikan tombol navigasi saat cetak */
        .btn-area {
            display: none !important;
        }
    }
</style>

<div class="struk">

    {{-- 1. HEADER TOKO --}}
    <div class="center">
        <div class="bold" style="font-size: 14px;">TITIK TEMU</div>
        <div class="small"></div>
        <div class="small"></div>
    </div>

    <hr>

    {{-- 2. METADATA TRANSAKSI --}}
    <table>
        <tr>
            <td>No</td>
            <td class="right">{{ $transaksi->kode_transaksi ?? $transaksi->id }}</td>
        </tr>
        <tr>
            <td>Kasir</td>
            <td class="right">{{ $transaksi->user->nama ?? '-' }}</td>
        </tr>
        <tr>
            <td>Pelanggan</td>
            <td class="right">{{ $transaksi->customer->nama ?? 'Umum' }}</td>
        </tr>
        <tr>
            <td>Waktu</td>
            <td class="right">{{ $transaksi->waktu }}</td>
        </tr>
    </table>

    <hr>

    {{-- 3. DAFTAR ITEM --}}
    @foreach($transaksi->detail as $d)
        @php
            $hargaAsli = $d->menu->harga;
            $harga     = $d->harga;
            $subtotal  = $harga * $d->jumlah;
        @endphp

        <div class="menu">
            {{ $d->menu->nama }}
        </div>

        @if($hargaAsli != $harga)
            <div class="coret">
                Rp {{ number_format($hargaAsli) }}
            </div>
        @endif

        <table>
            <tr>
                <td width="25%">{{ $d->jumlah }} x</td>
                <td class="right" width="35%">{{ number_format($harga) }}</td>
                <td class="right" width="40%">{{ number_format($subtotal) }}</td>
            </tr>
        </table>
    @endforeach

    <hr>

    {{-- 4. TOTAL & PEMBAYARAN --}}
    <table>
        @php
            $totalKeseluruhan = $transaksi->detail->sum(function($t) { return $t->harga * $t->jumlah; });
        @endphp
        <tr class="bold">
            <td>TOTAL</td>
            <td class="right">Rp {{ number_format($totalKeseluruhan) }}</td>
        </tr>
        <tr>
            <td>Bayar</td>
            <td class="right">Rp {{ number_format($transaksi->uang_bayar ?? 0) }}</td>
        </tr>
        <tr>
            <td>Kembali</td>
            <td class="right">Rp {{ number_format(($transaksi->uang_bayar ?? 0) - $totalKeseluruhan) }}</td>
        </tr>
    </table>

    <hr>

    {{-- 5. FOOTER --}}
    <div class="center small" style="margin-top: 10px; padding-bottom: 15px;">
        Terima Kasih<br>
        Selamat Menikmati
    </div>

</div>

{{-- 6. TOMBOL AKSI --}}
<div class="btn-area container text-center my-4">
    <button onclick="window.print()" class="btn btn-success m-1">
        Cetak Struk
    </button>
    <a href="{{ route('transaksi.index') }}" class="btn btn-secondary m-1">
        Kembali ke Index
    </a>
    <a href="{{ route('transaksi.create') }}" class="btn btn-primary m-1">
        Transaksi Baru
    </a>
</div>

@endsection

@extends('layouts.app')

@section('content')

<style>
    body{
        background:#eee;
        font-family:monospace; /* Menggunakan font monospace agar jarak antar karakter konsisten seperti struk kasir asli */
    }

    .struk{
        width:58mm; /* Standar ukuran lebar kertas printer thermal mini */
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
        border-top:1px dashed #000; /* Membuat garis putus-putus hitam pembatas struk */
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
        text-decoration:line-through; /* Memberikan efek garis coret untuk harga asli sebelum diskon */
        font-size:10px;
    }

    .btn-area{
        margin-top:20px;
        text-align:center;
    }

    /* PENGATURAN KETIKA STRUK DICETAK (PRINT PHYSICALLY) */
    @media print {
        @page{
            size:58mm auto; /* Mengatur ukuran kertas cetak otomatis memanjang mengikuti jumlah item */
            margin:0;
        }

        html,
        body{
            width:58mm;
            margin:0;
            padding:0;
            background:#fff;
        }

        /* Menyembunyikan seluruh elemen halaman web terlebih dahulu */
        body *{
            visibility:hidden;
        }

        /* Hanya memunculkan elemen struk beserta isinya saat dicetak */
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

        /* Menyembunyikan seluruh tombol aksi agar tidak ikut terpotret di kertas struk */
        .btn-area{
            display:none !important; /* Force sembunyikan dengan Bootstrap/CSS print */
        }
    }
</style>

<div class="struk">

    {{-- 1. BAGIAN HEADER STRUK (NAMA TOKO & ALAMAT) --}}
    <div class="center">
        <div class="bold">TITIK TEMU</div>
        <div class="small">Jl. Contoh No.123</div>
        <div class="small">Telp 08123456789</div>
    </div>

    <hr>

    {{-- 2. BAGIAN METADATA TRANSAKSI (NOMOR, KASIR, CUSTOMER, WAKTU) --}}
    <table>
        <tr>
            <td>No</td>
            {{-- Mengambil kode transaksi, jika kosong/null akan otomatis memakai ID --}}
            <td class="right">{{ $transaksi->kode_transaksi ?? $transaksi->id }}</td>
        </tr>
        <tr>
            <td>Kasir</td>
            {{-- Menampilkan nama kasir yang login, jika kosong diganti tanda minus --}}
            <td class="right">{{ $transaksi->user->nama ?? '-' }}</td>
        </tr>
        <tr>
            <td>Customer</td>
            {{-- Menampilkan nama pelanggan, jika kosong dianggap pembeli umum --}}
            <td class="right">{{ $transaksi->customer->nama ?? 'Umum' }}</td>
        </tr>
        <tr>
            <td>Waktu</td>
            <td class="right">{{ $transaksi->waktu }}</td>
        </tr>
    </table>

    <hr>

    {{-- 3. BAGIAN DAFTAR BELANJA (LOOPING PRODUK) --}}
    @foreach($transaksi->detail as $d)
        @php
            // Menyimpan variabel harga dan subtotal untuk memudahkan perhitungan teks
            $hargaAsli = $d->menu->harga;
            $harga     = $d->harga;
            $subtotal  = $harga * $d->jumlah;
            $diskon    = $d->menu->diskon ?? null;
        @endphp

        {{-- Menampilkan nama menu produk --}}
        <div class="menu">
            {{ $d->menu->nama }}
        </div>

        {{-- VALIDASI DISKON: Jika harga beli berbeda dengan harga asli, tampilkan harga asli tercoret --}}
        @if($hargaAsli != $harga)
            <div class="coret">
                Rp {{ number_format($hargaAsli) }}
            </div>
        @endif

        {{-- Menampilkan rincian perkalian jumlah, harga satuan, dan total subtotal per item --}}
        <table>
            <tr>
                <td width="20%">{{ $d->jumlah }} x</td>
                <td class="right" width="30%">{{ number_format($harga) }}</td>
                <td class="right" width="50%">{{ number_format($subtotal) }}</td>
            </tr>
        </table>
    @endforeach

    <hr>

    {{-- 4. BAGIAN TOTAL AKHIR (RINGKASAN PEMBAYARAN) --}}
    <table>
        <tr class="bold">
            <td>TOTAL</td>
            {{-- Menghitung total keseluruhan dengan menjumlahkan seluruh subtotal di dalam detail transaksi --}}
            <td class="right">Rp {{ number_format($transaksi->detail->sum(function($t) { return $t->harga * $t->jumlah; })) }}</td>
        </tr>
        <tr>
            <td>Bayar</td>
            <td class="right">Rp {{ number_format($transaksi->uang_bayar ?? 0) }}</td>
        </tr>
        <tr>
            <td>Kembali</td>
            <td class="right">Rp {{ number_format(($transaksi->uang_bayar ?? 0) - $transaksi->detail->sum(function($t) { return $t->harga * $t->jumlah; })) }}</td>
        </tr>
    </table>

    <hr>

    {{-- 5. BAGIAN FOOTER (TERIMA KASIH) --}}
    <div class="center small" style="margin-top: 8px;">
        Terima Kasih<br>
        Selamat Menikmati
    </div>

</div>

{{-- 6. AREA TOMBOL AKSI BOOTSTRAP 4 (HANYA MUNCUL DI LAYAR MONITOR) --}}
<div class="btn-area container text-center my-4">
    <!-- Tombol Cetak (Hijau Sukses Bootstrap 4) -->
    <button onclick="window.print()" class="btn btn-success m-1">
        Cetak Struk
    </button>

    <!-- Tombol Kembali ke Index (Abu-abu Sekunder Bootstrap 4) -->
    <a href="{{ route('transaksi.index') }}" class="btn btn-secondary m-1">
        Kembali ke Index
    </a>

    <!-- Tombol Transaksi Baru (Biru Primer Bootstrap 4) -->
    <a href="{{ route('transaksi.create') }}" class="btn btn-primary m-1">
        Transaksi Baru
    </a>
</div>

@endsection

@extends('layouts.app')

@section('content')

<style>
    .struk {
        width: 80mm; /* bisa ubah ke 58mm kalau printer kecil */
        margin: auto;
        font-size: 12px;
        font-family: monospace;
    }

    .struk hr {
        border: none;
        border-top: 1px dashed #000;
        margin: 5px 0;
    }

    .text-right {
        text-align: right;
    }

    .text-center {
        text-align: center;
    }

    .line {
        display: flex;
        justify-content: space-between;
    }

    @media print {
        body * {
            visibility: hidden;
        }

        .struk, .struk * {
            visibility: visible;
        }

        .struk {
            position: absolute;
            left: 0;
            top: 0;
        }
    }
</style>

<div class="container mt-4">
    <div class="struk card p-3 shadow-sm">

        {{-- HEADER --}}
        <div class="text-center mb-2">
            <h5 class="mb-0">Titik Temu</h5>
            <small>Jl. Contoh No.123</small><br>
            <small>Telp: 08123456789</small>
        </div>

        <hr>

        {{-- INFO --}}
        <table width="100%">
            <tr>
                <td>Kasir</td>
                <td>: {{ $transaksi->user->nama ?? '-' }}</td>
            </tr>
            <tr>
                <td>Customer</td>
                <td>: {{ $transaksi->customer->nama ?? '' }}</td>
            </tr>
            <tr>
                <td>Waktu</td>
                <td>: {{ $transaksi->waktu }}</td>
            </tr>
        </table>

        <hr>

        {{-- DETAIL --}}
        <table width="100%">
            @foreach($transaksi->detail as $d)
            @php
                $diskon = $d->menu->diskon ?? null;
                $harga = $d->harga;
                $diskonText = '-';

                if($diskon){
                    if($diskon->tipe_diskon == 'Persen'){
                        $diskonText = $diskon->diskon_persen . '%';
                    } else {
                        $diskonText = 'Rp ' . number_format($diskon->diskon_nominal);
                    }
                }
            @endphp

            <tr>
                <td colspan="2">{{ $d->menu->nama }}</td>
            </tr>
            <tr>
                <td>
                    {{ $d->jumlah }} x Rp {{ number_format($harga) }}
                    <br><small>Diskon: {{ $diskonText }}</small>
                </td>
                <td class="text-right">
                    Rp {{ number_format($d->subtotal) }}
                </td>
            </tr>
            @endforeach
        </table>

        <hr>

        {{-- TOTAL --}}
        <table width="100%">
            <tr>
                <td>Total</td>
                <td class="text-right">Rp {{ number_format($transaksi->total_harga) }}</td>
            </tr>
            <tr>
                <td>Bayar</td>
                <td class="text-right">Rp {{ number_format($transaksi->uang_bayar) }}</td>
            </tr>
            <tr>
                <td>Kembalian</td>
                <td class="text-right">Rp {{ number_format($transaksi->kembalian) }}</td>
            </tr>
        </table>

        <hr>

        {{-- FOOTER --}}
        <div class="text-center mt-2">
            <small>Terima Kasih 🙏</small><br>
            <small>Selamat Menikmati</small>
        </div>

    </div>

    {{-- BUTTON --}}
    <div class="text-center mt-3">
        <a href="{{ route('transaksi.index') }}" class="btn btn-secondary">
            Kembali
        </a>
        
        <button onclick="window.print()" class="btn btn-primary">
            Print
        </button>

        <a href="{{ route('transaksi.create') }}" class="btn btn-secondary">
            Tambah Transaksi baru
        </a>
    </div>

</div>

@endsection
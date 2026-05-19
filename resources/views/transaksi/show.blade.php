@extends('layouts.app')

@section('content')

<style>

    *{
        box-sizing: border-box;
    }

    body{
        background:#eee;
    }

    /* STRUK */
    .struk{
        width:80mm;
        margin:auto;
        background:#fff;
        padding:10px;
        font-family:monospace;
        font-size:12px;
        color:#000;
    }

    /* jika printer 58mm tinggal ganti */
    /*
    .struk{
        width:58mm;
    }
    */

    .struk h4,
    .struk h5,
    .struk p{
        margin:0;
    }

    .text-center{
        text-align:center;
    }

    .text-right{
        text-align:right;
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
        vertical-align:top;
        padding:2px 0;
        word-break:break-word;
    }

    .menu-name{
        font-weight:bold;
    }

    .small{
        font-size:11px;
    }

    .btn-area{
        margin-top:20px;
        text-align:center;
    }

    /* PRINT */
    @media print {

        @page{
            size:80mm auto;
            margin:0;
        }

        html,
        body{
            width:80mm;
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
            width:80mm;
            margin:0;
            padding:5px;
            box-shadow:none !important;
            border:none !important;
        }

        .btn-area{
            display:none;
        }
    }

</style>

<div class="container mt-3">

    <div class="struk">

        {{-- HEADER --}}
        <div class="text-center">

            <h4>TITIK TEMU</h4>

            <div class="small">
                Jl. Contoh No.123
            </div>

            <div class="small">
                Telp: 08123456789
            </div>

        </div>

        <hr>

        {{-- INFO TRANSAKSI --}}
        <table>

            <tr>
                <td>No</td>
                <td>: {{ $transaksi->kode_transaksi ?? $transaksi->id }}</td>
            </tr>

            <tr>
                <td>Kasir</td>
                <td>: {{ $transaksi->user->nama ?? '-' }}</td>
            </tr>

            <tr>
                <td>Customer</td>
                <td>: {{ $transaksi->customer->nama ?? '-' }}</td>
            </tr>

            <tr>
                <td>Waktu</td>
                <td>: {{ $transaksi->waktu }}</td>
            </tr>

            <tr>
                <td>Metode</td>
                <td>: {{ ucfirst($transaksi->metode_pembayaran) }}</td>
            </tr>

        </table>

        <hr>

        {{-- DETAIL MENU --}}
        <table>

            @foreach($transaksi->detail as $d)

                @php

                    $diskon =
                        $d->menu->diskon ?? null;

                    $harga =
                        $d->harga;

                    $diskonText = '-';

                    if($diskon){

                        if($diskon->tipe_diskon == 'Persen'){

                            $diskonText =
                                $diskon->diskon_persen . '%';

                        }else{

                            $diskonText =
                                'Rp ' .
                                number_format($diskon->diskon_nominal);

                        }
                    }

                @endphp

                {{-- NAMA MENU --}}
                <tr>
                    <td colspan="2" class="menu-name">
                        {{ $d->menu->nama }}
                    </td>
                </tr>

                {{-- DETAIL --}}
                <tr>

                   <td class="small">

    Harga:
    Rp {{ number_format($d->menu->harga) }}

    <br>

    Diskon:
    {{ $diskonText }}

    <br>

    {{ $d->jumlah }}
    x
    Rp {{ number_format($d->harga) }}

</td>

                </tr>

            @endforeach

        </table>

        <hr>

        {{-- TOTAL --}}
        <table>

            <tr>
                <td>Total</td>

                <td class="text-right">
                    Rp {{ number_format($transaksi->total_harga) }}
                </td>
            </tr>

            <tr>
                <td>Bayar</td>

                <td class="text-right">
                    Rp {{ number_format($transaksi->uang_bayar) }}
                </td>
            </tr>

            <tr>
                <td>Kembalian</td>

                <td class="text-right">
                    Rp {{ number_format($transaksi->kembalian) }}
                </td>
            </tr>

        </table>

        <hr>

        {{-- FOOTER --}}
        <div class="text-center">

            <div>
                Terima Kasih 🙏
            </div>

            <div>
                Selamat Menikmati
            </div>

        </div>

    </div>

    {{-- BUTTON --}}
    <div class="btn-area">

        <a href="{{ route('transaksi.index') }}"
           class="btn btn-secondary">
            Kembali
        </a>

        <button onclick="window.print()"
                class="btn btn-primary">
            Print
        </button>

        <a href="{{ route('transaksi.create') }}"
           class="btn btn-success">
            Tambah Transaksi Baru
        </a>

    </div>

</div>

{{-- AUTO PRINT --}}
<script>

    window.onload = function () {

        window.print();

    };

</script>

@endsection
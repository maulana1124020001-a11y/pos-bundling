@extends('layouts.app')

@section('content')

<div class="container py-3">

    {{-- 🔝 TOMBOL AKSI --}}
    <div class="text-center mb-3 aksi-area">
        <button onclick="window.print()" class="btn btn-success">
            Cetak Struk
        </button>

        <a href="{{ route('transaksi.index') }}" class="btn btn-secondary">
            Kembali
        </a>

        <a href="{{ route('transaksi.create') }}" class="btn btn-primary">
            Transaksi Baru
        </a>
    </div>

    {{-- STRUK --}}
    <div class="card shadow-sm border-0 mx-auto struk-container">

        <div class="card-body p-3">

            {{-- HEADER --}}
            <div class="text-center">
                <h5 class="font-weight-bold mb-1">
                    TITIK TEMU
                </h5>

                <small class="text-muted d-block">
                    COFFEE & EATERY
                </small>

                <small class="text-muted d-block">
                    Jl. Kom. Yos Sudarso No.33, Pacitan
                </small>
            </div>

            <hr class="border-dark border-dashed">

            {{-- INFO TRANSAKSI --}}
            <table class="table table-borderless table-sm mb-1">
                <tr>
                    <td class="p-0 small">
                        #{{ $transaksi->kode_transaksi ?? $transaksi->id }}
                    </td>

                    <td class="p-0 text-right small">
                        {{ date('d/m/y H:i', strtotime($transaksi->waktu)) }}
                    </td>
                </tr>

                <tr>
                    <td class="p-0 small">
                        KSR: {{ $transaksi->user->nama ?? '-' }}
                    </td>

                    <td class="p-0 text-right small">
                        PLG: {{ $transaksi->customer->nama ?? '-' }}
                    </td>
                </tr>
            </table>

            <hr class="border-dark border-dashed">

            {{-- DETAIL MENU --}}
            @foreach($transaksi->detail as $detail)

            @php
                $hargaAsli = $detail->menu->harga;
                $hargaJual = $detail->harga;
                $subtotal = $detail->subtotal;
            @endphp

            <div class="font-weight-bold">
                {{ $detail->menu->nama }}
            </div>

           @if($detail->menu->ada_diskon)
<small class="d-block mb-1">

    <span class="text-danger font-weight-bold">
        Diskon
        @if($detail->menu->diskon->tipe_diskon == 'Persen')
            {{ $detail->menu->diskon->diskon_persen }}%
        @else
            Rp{{ number_format($detail->menu->diskon->diskon_nominal) }}
        @endif
    </span>

    <br>

    <del class="text-muted">
        Rp{{ number_format($hargaAsli) }}
    </del>

    <span class="font-weight-bold">
        → Rp{{ number_format($hargaJual) }}
    </span>

</small>
@endif

            <table class="table table-borderless table-sm mb-2">
                <tr>
                    <td class="p-0 small">
                        {{ $detail->jumlah }} x {{ number_format($hargaJual) }}
                    </td>

                    <td class="p-0 text-right">
                        {{ number_format($subtotal) }}
                    </td>
                </tr>
            </table>

            @endforeach

            <hr class="border-dark border-dashed">

            {{-- TOTAL --}}
            <table class="table table-borderless table-sm mb-0">

                <tr class="font-weight-bold">
                    <td class="p-0">
                        TOTAL
                    </td>

                    <td class="p-0 text-right">
                        Rp {{ number_format($transaksi->total_harga) }}
                    </td>
                </tr>

                <tr>
                    <td class="p-0 small">
                        METODE
                    </td>

                    <td class="p-0 text-right small">
                        {{ strtoupper($transaksi->metode_pembayaran) }}
                    </td>
                </tr>

                <tr>
                    <td class="p-0">
                        BAYAR
                    </td>

                    <td class="p-0 text-right">
                        Rp {{ number_format($transaksi->uang_bayar ?? 0) }}
                    </td>
                </tr>

                <tr class="font-weight-bold">
                    <td class="p-0">
                        KEMBALI
                    </td>

                    <td class="p-0 text-right">
                        Rp {{ number_format($transaksi->kembalian ?? 0) }}
                    </td>
                </tr>

            </table>

            <hr class="border-dark border-dashed">

            {{-- FOOTER --}}
            <div class="text-center small text-muted mt-2">
                TERIMA KASIH ATAS KUNJUNGAN ANDA
            </div>

        </div>

    </div>

</div>

{{-- KHUSUS PRINT --}}
<style>
.struk-container{
    max-width: 380px;
}

.border-dashed{
    border-top: 1px dashed #000 !important;
}

@media print {

    @page{
        size: 58mm auto;
        margin: 0;
    }

    body *{
        visibility: hidden;
    }

    .struk-container,
    .struk-container *{
        visibility: visible;
    }

    .struk-container{
        position: absolute;
        left: 0;
        top: 0;
        width: 58mm !important;
        max-width: 58mm !important;
        margin: 0;
        box-shadow: none !important;
        border: none !important;
    }

    .aksi-area{
        display: none !important;
    }

    .card-body{
        padding: 4px !important;
    }

    table{
        margin-bottom: 2px !important;
    }

    td{
        font-size: 11px !important;
    }

    small{
        font-size: 9px !important;
    }

    h5{
        font-size: 14px !important;
    }
}
</style>

@endsection
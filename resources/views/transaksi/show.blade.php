@extends('layouts.app')

@section('content')

<div class="container py-4">

    {{-- 🔝 TOMBOL AKSI (Disembunyikan otomatis saat cetak/save PDF) --}}
    <div class="row justify-content-center mb-4 d-print-none aksi-area">
        <div class="col-md-6 text-center">
            <div class="d-flex flex-wrap gap-2 justify-content-center">
                <a href="{{ route('transaksi.print', $transaksi->id) }}" target="_blank" class="btn btn-success">
                    Cetak / Simpan PDF
                </a>

                <a href="{{ route('transaksi.rawbt',$transaksi->id) }}"
                    class="btn btn-dark px-4 py-2 shadow-sm flex-fill flex-md-grow-0">
                    <i class="fab fa-bluetooth me-1"></i> Cetak Bluetooth
                </a>

                <a href="{{ route('transaksi.index') }}"
                    class="btn btn-secondary px-4 py-2 shadow-sm flex-fill flex-md-grow-0">
                    <i class="fas fa-arrow-left me-1"></i> Kembali
                </a>

                <a href="{{ route('transaksi.create') }}"
                    class="btn btn-primary px-4 py-2 shadow-sm flex-fill flex-md-grow-0">
                    <i class="fas fa-plus me-1"></i> Transaksi Baru
                </a>
            </div>
        </div>
    </div>

    {{-- STRUK DOKUMEN --}}
    <div class="card shadow-sm border-0 mx-auto struk-container">

        <div class="card-body p-4">

            {{-- HEADER --}}

            <div class="text-center">
                <h4 class="mb-0 font-weight-bold">TITIK TEMU</h4>
                <div>Coffee & Eatery</div>
            </div>
            <hr class="border-dark border-dashed my-3">

            <div class="small">
                <div class="d-flex justify-content-between">
                    <span>No</span>
                    <span>#{{ $transaksi->kode_transaksi ?? $transaksi->id }}</span>
                </div>

                <div class="d-flex justify-content-between">
                    <span>Tanggal</span>
                    <span>{{ date('d/m/Y H:i', strtotime($transaksi->waktu)) }}</span>
                </div>

                <div class="d-flex justify-content-between">
                    <span>Kasir</span>
                    <span>{{ $transaksi->user->nama ?? '-' }}</span>
                </div>

                <div class="d-flex justify-content-between">
                    <span>Pelanggan</span>
                    <span>{{ $transaksi->customer->nama ?? '-' }}</span>
                </div>
            </div>

            <hr class="border-dark border-dashed my-3">

            {{-- DETAIL MENU --}}
            <div class="menu-items-area">
                @foreach($transaksi->detail as $detail)

                @php
                $hargaAsli = $detail->harga_asli;
                $hargaJual = $detail->harga;
                $subtotal = $detail->subtotal;
                @endphp

                <div class="mb-3 item-row text-dark">
                    <div class="font-weight-bold mb-1">
                        {{ $detail->menu->nama }}
                    </div>



                    @if(!is_null($detail->diskon))
                    <div class="small text-muted">
                        Rp{{ number_format($hargaAsli) }}
                        →
                        <strong>Rp{{ number_format($hargaJual) }}</strong>

                        (
                        @if($detail->tipe_diskon=='Persen')
                        -{{ $detail->diskon }}%
                        @else
                        -Rp{{ number_format($detail->diskon) }}
                        @endif
                        )
                    </div>
                    @endif

                    <div class="d-flex justify-content-between small">
                        <span class="text-muted">
                            {{ $detail->jumlah }} x Rp{{ number_format($hargaJual) }}
                        </span>
                        <strong class="text-dark">
                            Rp{{ number_format($subtotal) }}
                        </strong>
                    </div>
                </div>

                @endforeach
            </div>

            <hr class="border-dark border-dashed my-3">

            {{-- TOTAL --}}
            <div class="d-flex justify-content-between">
                <strong>TOTAL</strong>
                <strong>Rp{{ number_format($transaksi->total_harga) }}</strong>
            </div>

            <div class="d-flex justify-content-between">
                <span>BAYAR</span>
                <span>Rp{{ number_format($transaksi->uang_bayar) }}</span>
            </div>

            <div class="d-flex justify-content-between">
                <span>METODE</span>
                <span>{{ $transaksi->metode_pembayaran }}</span>
            </div>

            <div class="d-flex justify-content-between">
                <strong>KEMBALI</strong>
                <strong>Rp{{ number_format($transaksi->kembalian) }}</strong>
            </div>

            <hr class="border-dark border-dashed my-3">

            {{-- FOOTER --}}
            <div class="text-center mt-3">
    Terima Kasih Atas Kunjungan Anda
</div>

        </div>

    </div>

</div>

{{-- CONFIGURASI STYLE & CETAK PDF/BIASA --}}
<style>
/* Style Tampilan Layar (Web Browser) */
.struk-container {
    max-width: 480px;
    /* Diperlebar sedikit agar proposional untuk cetak PDF/Kertas Biasa */
    background: #ffffff;
    border-radius: 8px;
}

.border-dashed {
    border-top: 1px dashed #495057 !important;
}

.tracking-wider {
    letter-spacing: 0.1em;
}

/* Flex gap fallback untuk bootstrap versi lama */
.gap-2 {
    gap: 0.5rem !important;
}

/* Style Khusus saat dicetak ke PDF / Printer Biasa */
@media print {
    @page {
        size: A4 portrait;
        /* Set ke kertas standar (Bisa diganti 'letter' atau 'auto') */
        margin: 20mm 15mm;
        /* Memberikan margin dokumen yang bersih */
    }

    /* Sembunyikan semua elemen default aplikasi seperti navbar, sidebar, tombol */
    body {
        background-color: #ffffff !important;
        color: #000000 !important;
        font-family: Arial, sans-serif;
    }

    header,
    footer,
    .navbar,
    .main-sidebar,
    .d-print-none,
    .aksi-area {
        display: none !important;
    }

    /* Penyesuaian container agar pas di kertas */
    .container {
        width: 100% !important;
        max-width: 100% !important;
        padding: 0 !important;
        margin: 0 !important;
    }

    .struk-container {
        max-width: 100% !important;
        width: 100% !important;
        box-shadow: none !important;
        border: none !important;
        margin: 0 auto !important;
        padding: 0 !important;
    }

    .card-body {
        padding: 0 !important;
    }

    /* Pastikan warna teks tajam saat dicetak */
    .text-muted {
        color: #555555 !important;
    }

    .text-danger {
        color: #000000 !important;
        /* Ubah ke hitam jika printer hitam putih */
    }
}
</style>

@endsection
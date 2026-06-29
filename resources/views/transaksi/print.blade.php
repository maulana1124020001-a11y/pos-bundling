<!DOCTYPE html>
<html lang='id'>

<head>
    <meta charset='UTF-8'>
    <title>Cetak Struk</title>
    <style>
    body {
        font-family: Arial;
        background: #eee;
        margin: 0
    }

    .struk {
        width: 80mm;
        background: #fff;
        margin: 20px auto;
        padding: 10px
    }

    hr {
        border: none;
        border-top: 1px dashed #000
    }

    .row {
        display: flex;
        justify-content: space-between;
        font-size: 12px
    }

    .nama {
        font-weight: bold
    }

    .kecil {
        font-size: 11px;
        color: #555
    }

    @media print {
        @page {
            size: 80mm auto;
            margin: 0
        }

        body {
            background: #fff
        }

        .struk {
            margin: 0;
            width: 80mm;
            box-shadow: none
        }
    }
    </style>
</head>

<body onload='window.print()'>
    <div class='struk'>
        <div style='text-align:center'>
            <h3 style='margin:0'>TITIK TEMU</h3>
            <div>Coffee & Eatery</div>

        </div>
        <hr>
        <div class='row'><span>No</span><span>#{{ $transaksi->kode_transaksi ?? $transaksi->id }}</span></div>
        <div class='row'><span>Tanggal</span><span>{{ date('d/m/Y H:i', strtotime($transaksi->waktu)) }}</span></div>
        <div class='row'><span>Kasir</span><span>{{ $transaksi->user->nama ?? '-' }}</span></div>
        <div class='row'><span>Pelanggan</span><span>{{ $transaksi->customer->nama ?? '-' }}</span></div>
        <hr>@foreach($transaksi->detail as $detail)<div class='nama'>{{ $detail->menu->nama }}</div>
        @if(!is_null($detail->diskon))<div class='kecil'>Rp{{ number_format($detail->harga_asli) }} →
            <b>Rp{{ number_format($detail->harga) }}</b>
            (@if($detail->tipe_diskon==='Persen')-{{ $detail->diskon }}%@else-Rp{{ number_format($detail->diskon) }}@endif)
        </div>@endif<div class='row'><span>{{ $detail->jumlah }} x
                Rp{{ number_format($detail->harga) }}</span><b>Rp{{ number_format($detail->subtotal) }}</b></div>
        <br>@endforeach
        <hr>
        <div class='row'><b>TOTAL</b><b>Rp{{ number_format($transaksi->total_harga) }}</b></div>
        <div class='row'><span>BAYAR</span><span>Rp{{ number_format($transaksi->uang_bayar) }}</span></div>
        

                <div class='row'><b>METODE</b> {{ $transaksi->metode_pembayaran }}</div>
        <div class='row'><b>KEMBALI</b><b>Rp{{ number_format($transaksi->kembalian) }}</b></div>
        <hr>
        <div style='text-align:center'>Terima Kasih Atas Kunjungan Anda</div>
    </div>
</body>

</html>
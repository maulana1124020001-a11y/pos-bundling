<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>RawBT</title>
</head>

<body>

    @php

    $struk = "";

    // Inisialisasi printer
    $struk .= "\x1B\x40";

    // Rata tengah
    $struk .= "\x1B\x61\x01";

    $struk .= "TITIK TEMU\n";
    $struk .= "Coffee & Eatery\n";
    $struk .= "Jl. Kom. Yos Sudarso No.33\n";
    $struk .= "Pacitan\n";

    // Kembali rata kiri
    $struk .= "\x1B\x61\x00";

    $struk .= "--------------------------------\n";

    $struk .= "No : ".($transaksi->kode_transaksi ?? $transaksi->id)."\n";
    $struk .= "Tanggal : ".date('d/m/Y H:i', strtotime($transaksi->waktu))."\n";
    $struk .= "Kasir : ".($transaksi->user->nama ?? '-')."\n";
    $struk .= "Pelanggan : ".($transaksi->customer->nama ?? '-')."\n";

    $struk .= "--------------------------------\n";

    foreach($transaksi->detail as $item){

    $struk .= strtoupper($item->menu->nama)."\n";

    if(!is_null($item->diskon)){

    if($item->tipe_diskon == 'Persen'){
    $diskonText = "-".$item->diskon."%";
    }else{
    $diskonText = "-Rp".number_format($item->diskon,0,',','.');
    }

    $struk .=
    "Rp".number_format($item->harga_asli,0,',','.')
    ." -> Rp"
    .number_format($item->harga,0,',','.')
    ." (".$diskonText.")\n";
    }

    $struk .=
    $item->jumlah
    ." x Rp"
    .number_format($item->harga,0,',','.')
    ." = Rp"
    .number_format($item->subtotal,0,',','.')
    ."\n\n";
    }

    $struk .= "--------------------------------\n";

    $struk .= "TOTAL : Rp".number_format($transaksi->total_harga,0,',','.')."\n";
    $struk .= "BAYAR : Rp".number_format($transaksi->uang_bayar,0,',','.')."\n";
    $struk .= "METODE : ".strtoupper($transaksi->metode_pembayaran)."\n";
    $struk .= "KEMBALI : Rp".number_format($transaksi->kembalian,0,',','.')."\n";

    $struk .= "--------------------------------\n";

    // Footer rata tengah
    $struk .= "\x1B\x61\x01";

    $struk .= "Terima Kasih\n";
    $struk .= "Atas Kunjungan Anda\n";

    // Kembali rata kiri
    $struk .= "\x1B\x61\x00";

    // Feed kertas
    $struk .= "\n\n\n";

    @endphp

    <a id="print"></a>

    <script>
    let text = @json($struk);

    let url =
        'rawbt:base64,' +
        btoa(unescape(encodeURIComponent(text)));

    window.location.href = url;
    </script>

</body>

</html>
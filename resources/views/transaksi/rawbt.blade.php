<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>RawBT</title>
</head>
<body>

@php

$struk = "";

$struk .= "TITIK TEMU\n";
$struk .= "COFFEE & EATERY\n";
$struk .= "------------------------------\n";

$struk .= "No : ".$transaksi->id."\n";
$struk .= "Kasir : ".($transaksi->user->nama ?? '-')."\n";
$struk .= "Tanggal : ".date('d/m/Y H:i')."\n";

$struk .= "------------------------------\n";

foreach($transaksi->detail as $item){

    $struk .= $item->menu->nama."\n";

    $struk .=
        $item->jumlah .
        " x " .
        number_format($item->harga) .
        "\n";

    $struk .=
        "Rp " .
        number_format($item->subtotal) .
        "\n\n";
}

$struk .= "------------------------------\n";

$struk .=
    "TOTAL : Rp ".
    number_format($transaksi->total_harga)
    ."\n";

$struk .=
    "BAYAR : Rp ".
    number_format($transaksi->uang_bayar)
    ."\n";

$struk .=
    "KEMBALI : Rp ".
    number_format($transaksi->kembalian)
    ."\n";

$struk .= "------------------------------\n";

$struk .= "TERIMA KASIH\n";

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
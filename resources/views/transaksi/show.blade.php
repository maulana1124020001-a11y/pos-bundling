@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <h1 class="h3 mb-3 text-gray-800">Detail Transaksi</h1>

    <div class="card shadow">
        <div class="card-body">

            <p><b>Kasir:</b> {{ $transaksi->user->nama ?? '-' }}</p>
            <p><b>Waktu:</b> {{ $transaksi->waktu }}</p>

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Menu</th>
                        <th>Harga</th>
                        <th>Jumlah</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($transaksi->detail as $d)
                    <tr>
                        <td>{{ $d->menu->nama }}</td>
                        <td>Rp {{ number_format($d->harga) }}</td>
                        <td>{{ $d->jumlah }}</td>
                        <td>Rp {{ number_format($d->subtotal) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <hr>

            <h5>Total: Rp {{ number_format($transaksi->total_harga) }}</h5>
            <h5>Bayar: Rp {{ number_format($transaksi->uang_bayar) }}</h5>
            <h5>Kembalian: Rp {{ number_format($transaksi->kembalian) }}</h5>

            <!-- Tombol -->
            <div class="mt-3">
                <a href="{{ route('transaksi.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>

                <button onclick="window.print()" class="btn btn-primary">
                    <i class="fas fa-print"></i> Print
                </button>
            </div>

        </div>
    </div>

</div>

@endsection
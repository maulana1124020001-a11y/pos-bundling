@extends('layouts.app')

@section('content')
<div class="container-fluid px-2 px-md-4">

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-history text-primary"></i> Daftar Transaksi
        </h1>
    </div>

    <div class="card shadow mb-4 w-100">

        <div class="card-header py-3 d-flex flex-column flex-md-row align-items-md-center justify-content-between">
            
            <h6 class="m-0 font-weight-bold text-primary mb-2 mb-md-0">
                Tabel Transaksi
            </h6>

           

        </div>

        <div class="card-body p-2 p-md-3">

            <div class="table-responsive w-100">

                <table class="table table-bordered table-hover mb-0" id="dataTable">

                    <thead class="thead-light">
                        <tr>
                            <th>No</th>
                            <th>Kasir</th>
                            <th>Total</th>
                            <th>Bayar</th>
                            <th>Kembalian</th>
                            <th>Metode</th>
                            <th>Customer</th>
                            <th>Waktu</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($transaksis as $t)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $t->user->nama ?? '-' }}</td>
                            <td>Rp {{ number_format($t->total_harga,0,',','.') }}</td>
                            <td>Rp {{ number_format($t->uang_bayar,0,',','.') }}</td>
                            <td>Rp {{ number_format($t->kembalian,0,',','.') }}</td>
                            <td>{{ $t->metode_pembayaran }}</td>
                            <td>{{ $t?->customer->nama ?? '-' }}</td>
                            <td>{{ $t->waktu }}</td>
                            <td class="text-center">
                                <a href="{{ route('transaksi.show', $t->id) }}" class="btn btn-info btn-sm">
                                    <i class="fas fa-receipt"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center">
                                Belum ada transaksi
                            </td>
                        </tr>
                        @endforelse
                    </tbody>

                </table>

            </div>

        </div>
    </div>

</div>
@endsection
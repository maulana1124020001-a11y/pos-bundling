@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <!-- Judul -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-receipt text-primary"></i> Riwayat Transaksi Customer
        </h1>
    </div>

    <!-- Card -->
    <div class="card shadow mb-4">

        <!-- Header -->
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                Customer :
                <strong>{{ $customer->nama }}</strong>
            </h6>
        </div>

        <!-- Body -->
        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-bordered table-hover" id="dataTable" width="100%">

                    <thead class="thead-light">
                        <tr>
                            <th width="50">No</th>
                            <th>Tanggal</th>
                            <th>Kasir</th>
                            <th>Total</th>
                            <th width="80">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($transaksi as $transaksi)

                        <tr>

                            <td class="text-center">
                                {{ $loop->iteration }}
                            </td>

                            <td>
                                {{ $transaksi->created_at->format('d-m-Y H:i') }}
                            </td>

                            <td>
                                {{ $transaksi->user->nama ?? '-' }}
                            </td>

                            <td>
                                Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}
                            </td>

                            <td class="text-center">

                                <a href="{{ route('transaksi.show', $transaksi->id) }}" class="btn btn-info btn-sm"
                                    title="Lihat Detail Transaksi">

                                    <i class="fas fa-receipt"></i>

                                </a>

                            </td>

                        </tr>

                        @empty

                        <tr>
                            <td colspan="5" class="text-center">
                                Belum ada riwayat transaksi.
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
@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <h1 class="h3 mb-4 text-gray-800">
        Dashboard
    </h1>

    <!-- CARD -->
    <div class="row">

        <!-- TOTAL TRANSAKSI -->
        <div class="col-md-4 mb-4">
            <div class="card border-left-primary shadow h-100 py-3">

                <div class="card-body d-flex justify-content-between align-items-center">

                    <div>
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Total Transaksi
                        </div>

                        <div class="h4 font-weight-bold text-gray-800">
                            {{ $totalTransaksi }}
                        </div>
                    </div>

                    <i class="fas fa-shopping-cart fa-2x text-gray-300"></i>

                </div>

            </div>
        </div>

        <!-- KEUNTUNGAN -->
        <div class="col-md-4 mb-4">
            <div class="card border-left-success shadow h-100 py-3">

                <div class="card-body d-flex justify-content-between align-items-center">

                    <div>
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Keuntungan
                        </div>

                        <div class="h4 font-weight-bold text-gray-800">
                            Rp {{ number_format($keuntungan,0,',','.') }}
                        </div>
                    </div>

                    <i class="fas fa-coins fa-2x text-gray-300"></i>

                </div>

            </div>
        </div>

        <!-- MODAL -->
        <div class="col-md-4 mb-4">
            <div class="card border-left-danger shadow h-100 py-3">

                <div class="card-body d-flex justify-content-between align-items-center">

                    <div>
                        <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                            Modal
                        </div>

                        <div class="h4 font-weight-bold text-gray-800">
                            Rp {{ number_format($totalModal,0,',','.') }}
                        </div>
                    </div>

                    <i class="fas fa-money-bill-wave fa-2x text-gray-300"></i>

                </div>

            </div>
        </div>

    </div>

    <!-- GRAFIK + TABEL -->
    <div class="row">

        <!-- GRAFIK -->
        <div class="col-md-6 mb-4">

            <div class="card shadow h-100">

                <div class="card-header">
                    Grafik Pendapatan Bulanan
                </div>

                <div class="card-body">

                    <div style="height:300px;">
                        <canvas id="chartBulanan"></canvas>
                    </div>

                </div>

            </div>

        </div>

        <!-- TABEL -->
        <div class="col-md-6 mb-4">

            <div class="card shadow h-100">

                <div class="card-header">
                    Transaksi Terbaru
                </div>

                <div class="card-body table-responsive">

                    <table class="table table-bordered">

                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kasir</th>
                                <th>Customer</th>
                                <th>Total</th>
                                <th>Bayar</th>
                                <th>Waktu</th>
                            </tr>
                        </thead>

                        <tbody>

                            @forelse($transaksiTerbaru as $t)

                            <tr>

                                <td>{{ $loop->iteration }}</td>

                                <td>{{ $t->user->nama ?? '-' }}</td>

                                <td>{{ $t->customer->nama ?? 'Umum' }}</td>

                                <td>
                                    Rp {{ number_format($t->total_harga,0,',','.') }}
                                </td>

                                <td>
                                    {{ ucfirst($t->metode_pembayaran) }}
                                </td>

                                <td>
                                    {{ $t->waktu }}
                                </td>

                            </tr>

                            @empty

                            <tr>
                                <td colspan="6" class="text-center">
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

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

new Chart(document.getElementById('chartBulanan'), {

    type: 'bar',

    data: {
        labels: @json($labels),

        datasets: [{
            label: 'Pendapatan',
            data: @json($data),
            borderWidth: 1
        }]
    },

    options: {
        responsive: true,
        maintainAspectRatio: false
    }

});

</script>

@endsection
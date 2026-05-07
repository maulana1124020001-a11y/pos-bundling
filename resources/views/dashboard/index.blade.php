@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <!-- TITLE -->
    <h1 class="h3 mb-4 text-gray-800">
        Dashboard
    </h1>

    <!-- CARD -->
    <div class="row">

        <!-- TOTAL TRANSAKSI -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">

                <div class="card-body">
                    <div class="row no-gutters align-items-center">

                        <div class="col mr-2">

                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Transaksi
                            </div>

                            <div class="h4 mb-0 font-weight-bold text-gray-800">
                                {{ $totalTransaksi }}
                            </div>

                        </div>

                        <div class="col-auto">
                            <i class="fas fa-shopping-cart fa-2x text-gray-300"></i>
                        </div>

                    </div>
                </div>

            </div>
        </div>

        <!-- KEUNTUNGAN -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">

                <div class="card-body">
                    <div class="row no-gutters align-items-center">

                        <div class="col mr-2">

                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Keuntungan
                            </div>

                            <div class="h4 mb-0 font-weight-bold text-gray-800">
                                Rp {{ number_format($keuntungan,0,',','.') }}
                            </div>

                        </div>

                        <div class="col-auto">
                            <i class="fas fa-coins fa-2x text-gray-300"></i>
                        </div>

                    </div>
                </div>

            </div>
        </div>

        <!-- MODAL -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2">

                <div class="card-body">
                    <div class="row no-gutters align-items-center">

                        <div class="col mr-2">

                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                Modal / Kerugian
                            </div>

                            <div class="h4 mb-0 font-weight-bold text-gray-800">
                                Rp {{ number_format($totalModal,0,',','.') }}
                            </div>

                        </div>

                        <div class="col-auto">
                            <i class="fas fa-money-bill-wave fa-2x text-gray-300"></i>
                        </div>

                    </div>
                </div>

            </div>
        </div>

    </div>

    <!-- GRAFIK -->
    <div class="card shadow mb-4">

        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                Grafik Transaksi Perbulan
            </h6>
        </div>

        <div class="card-body">
            <canvas id="chartBulanan"></canvas>
        </div>

    </div>

    <!-- TRANSAKSI TERBARU -->
    <div class="card shadow">

        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                Transaksi Terbaru
            </h6>
        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-bordered">

                    <thead class="thead-light">
                        <tr>
                            <th>No</th>
                            <th>Kasir</th>
                            <th>Customer</th>
                            <th>Total</th>
                            <th>Pembayaran</th>
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

<!-- CHART JS -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const ctx = document.getElementById('chartBulanan');

    new Chart(ctx, {
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
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>

@endsection
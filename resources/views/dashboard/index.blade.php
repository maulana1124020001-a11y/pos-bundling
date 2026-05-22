@extends('layouts.app')

@section('content')

<div class="container-fluid">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h3 class="font-weight-bold text-gray-800 mb-1">
                Dashboard
            </h3>

            <small class="text-muted">
                {{ \Carbon\Carbon::now()->locale('id')->translatedFormat('l, d F Y') }}
            </small>
        </div>

    </div>


    {{-- CARD STATISTIK --}}
    <div class="row">

        {{-- JUMLAH MENU --}}
        <div class="col-xl col-md-6 mb-4">

            <div class="card shadow border-0 h-100">

                <div class="card-body">

                    <div class="d-flex justify-content-between">

                        <div>

                            <div class="text-xs text-muted mb-2">
                                Jumlah Menu
                            </div>

                            <div class="h4 font-weight-bold">
                                {{ $jumlahMenu }}
                            </div>

                        </div>

                        <div>
                            <i class="fas fa-utensils fa-2x text-info"></i>
                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- MODAL --}}
        <div class="col-xl col-md-6 mb-4">

            <div class="card shadow border-0 h-100">

                <div class="card-body">

                    <div class="d-flex justify-content-between">

                        <div>

                            <div class="text-xs text-muted mb-2">
                                Modal
                            </div>

                            <div class="h4 font-weight-bold">
                                Rp {{ number_format($totalModal,0,',','.') }}
                            </div>

                        </div>

                        <div>
                            <i class="fas fa-wallet fa-2x text-primary"></i>
                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- KEUNTUNGAN --}}
        <div class="col-xl col-md-6 mb-4">

            <div class="card shadow border-0 h-100">

                <div class="card-body">

                    <div class="d-flex justify-content-between">

                        <div>

                            <div class="text-xs text-muted mb-2">
                                Keuntungan
                            </div>

                            <div class="h4 font-weight-bold text-success">
                                Rp {{ number_format($keuntunganBersih,0,',','.') }}
                            </div>

                        </div>

                        <div>
                            <i class="fas fa-chart-line fa-2x text-success"></i>
                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- PENJUALAN --}}
        <div class="col-xl col-md-6 mb-4">

            <div class="card shadow border-0 h-100">

                <div class="card-body">

                    <div class="d-flex justify-content-between">

                        <div>

                            <div class="text-xs text-muted mb-2">
                                Total Penjualan
                            </div>

                            <div class="h4 font-weight-bold">
                                Rp {{ number_format($totalPendapatan,0,',','.') }}
                            </div>

                        </div>

                        <div>
                            <i class="fas fa-dollar-sign fa-2x text-primary"></i>
                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- TRANSAKSI --}}
        <div class="col-xl col-md-6 mb-4">

            <div class="card shadow border-0 h-100">

                <div class="card-body">

                    <div class="d-flex justify-content-between">

                        <div>

                            <div class="text-xs text-muted mb-2">
                                Jumlah Transaksi
                            </div>

                            <div class="h4 font-weight-bold">
                                {{ $jumlahTransaksi }}
                            </div>

                        </div>

                        <div>
                            <i class="fas fa-shopping-cart fa-2x text-secondary"></i>
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>



    {{-- ROW BAWAH --}}
    <div class="row">

        {{-- TABEL MENU --}}
        <div class="col-lg-6 mb-4">

            <div class="card shadow border-0">

                <div class="card-header bg-white">

                    <h6 class="font-weight-bold mb-0">
                        Tabel Menu Terlaris
                    </h6>

                </div>

                <div class="card-body p-0">

                    <div class="table-responsive">

                        <table class="table table-hover mb-0">

                            <thead class="bg-light">

                                <tr>

                                    <th>No</th>
                                    <th>Menu</th>
                                    <th>Terjual</th>

                                </tr>

                            </thead>

                            <tbody>

                                @foreach($menuTerlaris as $index => $item)

                                <tr>

                                    <td>
                                        {{ $index + 1 }}
                                    </td>

                                    <td>

                                        <div class="font-weight-bold">
                                            {{ $item->menu->nama ?? '-' }}
                                        </div>

                                    </td>

                                    <td>

                                        <span class="badge badge-success px-3 py-2">

                                            {{ $item->total_terjual }}

                                        </span>

                                    </td>

                                </tr>

                                @endforeach

                            </tbody>

                        </table>

                    </div>

                </div>

            </div>

        </div>



        {{-- GRAFIK --}}
        <div class="col-lg-6 mb-4">

            <div class="card shadow border-0">

                <div class="card-header bg-white">

                    <h6 class="font-weight-bold mb-0">
                        Grafik Penjualan
                    </h6>

                </div>

                <div class="card-body">

                    <canvas id="chartPenjualan" height="120"></canvas>

                </div>

            </div>

        </div>

    </div>

</div>



{{-- CHART JS --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

const ctx = document.getElementById('chartPenjualan');

new Chart(ctx, {

    type: 'line',

    data: {

        labels: ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'],

        datasets: [{

            label: 'Penjualan',

            data: [12, 19, 8, 15, 20, 30, 25],

            borderWidth: 2,

            fill: true

        }]

    }

});

</script>

@endsection
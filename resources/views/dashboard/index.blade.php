@extends('layouts.app')

@section('content')
<div class="container-fluid">

    {{-- 1. HEADER HALAMAN --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="font-weight-bold mb-1">Dashboard</h3>
            <small class="text-muted">{{ \Carbon\Carbon::now()->locale('id')->translatedFormat('l, d F Y') }}</small>
        </div>
    </div>

   
   {{-- 2. KARTU STATISTIK RINGKASAN (SATU BARIS & MANUALLY WRITTEN) --}}
    <div class="row mb-4 flex-nowrap overflow-auto pb-2">

        <div class="col mb-2">
            <div class="card card-body d-flex justify-content-between align-items-center flex-row shadow-sm py-3" style="min-width: 180px;">
                <div>
                    <small class="text-muted text-uppercase font-weight-bold">Jumlah Menu</small>
                    <div class="h5 font-weight-bold mb-0">{{ $jumlahMenu }} Menu</div>
                </div>
                <i class="fas fa-utensils fa-2x text-info ml-2"></i>
            </div>
        </div>

        <div class="col mb-2">
            <div class="card card-body d-flex justify-content-between align-items-center flex-row shadow-sm py-3" style="min-width: 180px;">
                <div>
                    <small class="text-muted text-uppercase font-weight-bold">Modal</small>
                    <div class="h5 font-weight-bold mb-0">Rp {{ number_format($totalModal, 0, ',', '.') }}</div>
                </div>
                <i class="fas fa-wallet fa-2x text-primary ml-2"></i>
            </div>
        </div>

        <div class="col mb-2">
            <div class="card card-body d-flex justify-content-between align-items-center flex-row shadow-sm py-3" style="min-width: 180px;">
                <div>
                    <small class="text-muted text-uppercase font-weight-bold">Keuntungan</small>
                    <div class="h5 font-weight-bold mb-0 text-success">Rp {{ number_format($keuntunganBersih, 0, ',', '.') }}</div>
                </div>
                <i class="fas fa-chart-line fa-2x text-success ml-2"></i>
            </div>
        </div>

        <div class="col mb-2">
            <div class="card card-body d-flex justify-content-between align-items-center flex-row shadow-sm py-3" style="min-width: 180px;">
                <div>
                    <small class="text-muted text-uppercase font-weight-bold">Total Penjualan</small>
                    <div class="h5 font-weight-bold mb-0">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</div>
                </div>
                <i class="fas fa-dollar-sign fa-2x text-primary ml-2"></i>
            </div>
        </div>

        <div class="col mb-2">
            <div class="card card-body d-flex justify-content-between align-items-center flex-row shadow-sm py-3" style="min-width: 180px;">
                <div>
                    <small class="text-muted text-uppercase font-weight-bold">Transaksi</small>
                    <div class="h5 font-weight-bold mb-0">{{ $jumlahTransaksi }} Transaksi</div>
                </div>
                <i class="fas fa-shopping-cart fa-2x text-secondary ml-2"></i>
            </div>
        </div>

    </div>

    {{-- 3. DETAIL UTAMA (TABEL & GRAFIK) --}}
    <div class="row">
        
        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h6 class="font-weight-bold mb-0">Data Penjualan Menu</h6>
                    <form method="GET" action="{{ route('dashboard') }}">
                        <select name="filter" class="form-control form-control-sm" onchange="this.form.submit()">
                            <option value="desc" {{ $filter == 'desc' ? 'selected' : '' }}>Paling Laris</option>
                            <option value="asc" {{ $filter == 'asc' ? 'selected' : '' }}>Paling Tidak Laris</option>
                        </select>
                    </form>
                </div>
                <div class="card-body p-0" style="max-height: 350px; overflow-y: auto;">
                    <table class="table table-hover table-striped mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th width="10%">No</th>
                                <th>Menu</th>
                                <th width="25%" class="text-center">Terjual</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($semuaMenu as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td><strong>{{ $item->menu->nama ?? '-' }}</strong></td>
                                    <td class="text-center">{{ $item->total_terjual }} Pcs</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center py-4 text-muted">Tidak ada data penjualan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-white py-3">
                    <h6 class="font-weight-bold mb-0 text-dark">Grafik Penjualan</h6>
                </div>
                <div class="card-body d-flex align-items-center">
                    <canvas id="chart"></canvas>
                </div>
            </div>
        </div>

    </div>
</div>

{{-- 4. SCRIPT GRAFIK (CHART.JS) --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    new Chart(document.getElementById('chart'), {
        type: 'line',
        data: {
            labels: @json($penjualanHarian->pluck('tanggal')),
            datasets: [{
                label: 'Penjualan (Rp)',
                data: @json($penjualanHarian->pluck('total')),
                borderColor: '#28a745',
                backgroundColor: 'rgba(40, 167, 69, 0.1)',
                fill: true,
                tension: 0.2
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } }
        }
    });
</script>
@endsection
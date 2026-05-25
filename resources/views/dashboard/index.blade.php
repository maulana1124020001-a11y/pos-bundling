@extends('layouts.app')

@section('content')
<div class="container-fluid">

    {{-- HEADER: Menampilkan judul halaman dan tanggal hari ini dari library Carbon Laravel --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="font-weight-bold text-gray-800 mb-1">Dashboard</h3>
            <small class="text-muted">{{ \Carbon\Carbon::now()->locale('id')->translatedFormat('l, d F Y') }}</small>
        </div>
    </div>

    {{-- BARIS UTAMA CARD STATISTIK --}}
    <div class="row">

        {{-- CARD STATISTIK 1: Menampilkan kuantitas atau jumlah jenis menu yang terdaftar --}}
        <div class="col-xl col-md-6 mb-4">
            <div class="card shadow border-0 card-body d-flex justify-content-between align-items-center flex-row">
                <div>
                    <div class="text-xs text-muted mb-2">Jumlah Menu</div>
                    <div class="h4 font-weight-bold mb-0">{{ $jumlahMenu }}</div>
                </div>
                <i class="fas fa-utensils fa-2x text-info"></i>
            </div>
        </div>

        {{-- CARD STATISTIK 2: Menampilkan akumulasi nominal uang modal awal usaha --}}
        <div class="col-xl col-md-6 mb-4">
            <div class="card shadow border-0 card-body d-flex justify-content-between align-items-center flex-row">
                <div>
                    <div class="text-xs text-muted mb-2">Modal</div>
                    <div class="h4 font-weight-bold mb-0">Rp {{ number_format($totalModal, 0, ',', '.') }}</div>
                </div>
                <i class="fas fa-wallet fa-2x text-primary"></i>
            </div>
        </div>

        {{-- CARD STATISTIK 3: Menampilkan total keuntungan bersih dengan indikator teks warna hijau --}}
        <div class="col-xl col-md-6 mb-4">
            <div class="card shadow border-0 card-body d-flex justify-content-between align-items-center flex-row">
                <div>
                    <div class="text-xs text-muted mb-2">Keuntungan</div>
                    <div class="h4 font-weight-bold text-success mb-0">Rp {{ number_format($keuntunganBersih, 0, ',', '.') }}</div>
                </div>
                <i class="fas fa-chart-line fa-2x text-success"></i>
            </div>
        </div>

        {{-- CARD STATISTIK 4: Menampilkan total omzet kotor penjualan produk --}}
        <div class="col-xl col-md-6 mb-4">
            <div class="card shadow border-0 card-body d-flex justify-content-between align-items-center flex-row">
                <div>
                    <div class="text-xs text-muted mb-2">Total Penjualan</div>
                    <div class="h4 font-weight-bold mb-0">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</div>
                </div>
                <i class="fas fa-dollar-sign fa-2x text-primary"></i>
            </div>
        </div>

        {{-- CARD STATISTIK 5: Menampilkan total seluruh transaksi/nota belanja yang masuk --}}
        <div class="col-xl col-md-6 mb-4">
            <div class="card shadow border-0 card-body d-flex justify-content-between align-items-center flex-row">
                <div>
                    <div class="text-xs text-muted mb-2">Jumlah Transaksi</div>
                    <div class="h4 font-weight-bold mb-0">{{ $jumlahTransaksi }}</div>
                </div>
                <i class="fas fa-shopping-cart fa-2x text-secondary"></i>
            </div>
        </div>

    </div>

    {{-- BARIS DETAIL: TABEL DAN GRAFIK --}}
    <div class="row">

        {{-- BLOCK TABEL: Menampilkan data peringkat penjualan menu terlaris / kurang laris --}}
        <div class="col-lg-6 mb-4">
            <div class="card shadow border-0">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h6 class="font-weight-bold mb-0">Data Penjualan Menu</h6>
                    <form method="GET" action="{{ route('dashboard') }}">
                        <select name="filter" class="form-control form-control-sm" onchange="this.form.submit()">
                            <option value="desc" {{ $filter == 'desc' ? 'selected' : '' }}>Paling Laris</option>
                            <option value="asc" {{ $filter == 'asc' ? 'selected' : '' }}>Paling Tidak Laris</option>
                        </select>
                    </form>
                </div>
                <div class="card-body p-0 table-responsive" style="max-height: 350px; overflow-y: auto;">
                    <table class="table table-hover mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th width="10%">No</th>
                                <th>Menu</th>
                                <th width="25%">Terjual</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($semuaMenu as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $item->menu->nama ?? '-' }}</td>
                                    <td>{{ $item->total_terjual }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="3" class="text-center py-4">Tidak ada data</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- BLOCK GRAFIK: Menyediakan elemen canvas tempat render grafik performa penjualan harian --}}
        <div class="col-lg-6 mb-4">
            <div class="card shadow border-0">
                <div class="card-header bg-success text-white"><h6 class="font-weight-bold mb-0">Grafik Penjualan</h6></div>
                <div class="card-body"><canvas id="chart"></canvas></div>
            </div>
        </div>

    </div>
</div>

{{-- SCRIPT: Memuat Chart.js untuk merender visualisasi grafik garis data harian --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('chart');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: @json($penjualanHarian->pluck('tanggal')),
            datasets: [{
                label: 'Penjualan',
                data: @json($penjualanHarian->pluck('total')),
                borderWidth: 2,
                tension: 0.3,
                fill: false
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: true } }
        }
    });
</script>
@endsection
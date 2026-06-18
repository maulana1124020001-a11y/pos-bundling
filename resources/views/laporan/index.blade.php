@extends('layouts.app')

@section('content')
<div class="container-fluid">

    {{-- 1. HEADER & FILTER PERIODE --}}
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
        <div class="mb-2">
            <h3 class="font-weight-bold mb-1">Laporan Keuangan</h3>
            <small class="text-muted">Periode: {{ $bulanSelected == 'semua' ? 'Tahun Penuh' : $listBulan[$bulanSelected] }} {{ $tahunSelected }}</small>
        </div>
        
        <form method="GET" action="{{ route('laporan.index') }}" class="form-inline">
            <input type="hidden" name="filter_menu" value="{{ $filterMenu }}">

            <select name="bulan" class="form-control form-control-sm mr-2 mb-2" onchange="this.form.submit()">
                @foreach($listBulan as $value => $nama)
                    <option value="{{ $value }}" {{ $bulanSelected == $value ? 'selected' : '' }}>{{ $nama }}</option>
                @endforeach
            </select>
            
            <select name="tahun" class="form-control form-control-sm mr-2 mb-2" onchange="this.form.submit()">
                @foreach($listTahun as $thn)
                    <option value="{{ $thn }}" {{ $tahunSelected == $thn ? 'selected' : '' }}>{{ $thn }}</option>
                @endforeach
            </select>
            
            <!-- <button type="button" class="btn btn-sm btn-outline-secondary mb-2" onclick="window.print()">
                <i class="fas fa-print"></i> Cetak
            </button> -->
        </form>
    </div>

    {{-- 2. KARTU STATISTIK RINGKASAN (MANUAL & SATU BARIS) --}}
    <div class="row mb-4 flex-nowrap overflow-auto pb-2">
        
        <div class="col mb-2">
            <div class="card card-body d-flex justify-content-between align-items-center flex-row shadow-sm py-3" style="min-width: 200px;">
                <div>
                    <small class="text-muted text-uppercase font-weight-bold">Total Omzet</small>
                    <div class="h5 font-weight-bold mb-0">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</div>
                </div>
                <i class="fas fa-dollar-sign fa-2x text-primary ml-2"></i>
            </div>
        </div>

        <div class="col mb-2">
            <div class="card card-body d-flex justify-content-between align-items-center flex-row shadow-sm py-3" style="min-width: 200px;">
                <div>
                    <small class="text-muted text-uppercase font-weight-bold">Total Modal</small>
                    <div class="h5 font-weight-bold mb-0">Rp {{ number_format($totalModal, 0, ',', '.') }}</div>
                </div>
                <i class="fas fa-wallet fa-2x text-warning ml-2"></i>
            </div>
        </div>

        <div class="col mb-2">
            <div class="card card-body d-flex justify-content-between align-items-center flex-row shadow-sm py-3" style="min-width: 200px;">
                <div>
                    <small class="text-muted text-uppercase font-weight-bold">Keuntungan Bersih</small>
                    <div class="h5 font-weight-bold mb-0 text-success">Rp {{ number_format($keuntunganBersih, 0, ',', '.') }}</div>
                </div>
                <i class="fas fa-chart-line fa-2x text-success ml-2"></i>
            </div>
        </div>

        <div class="col mb-2">
            <div class="card card-body d-flex justify-content-between align-items-center flex-row shadow-sm py-3" style="min-width: 200px;">
                <div>
                    <small class="text-muted text-uppercase font-weight-bold">Total Transaksi</small>
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
                    <h6 class="font-weight-bold mb-0">Rincian Penjualan Produk</h6>
                    
                    <form method="GET" action="{{ route('laporan.index') }}">
                        <input type="hidden" name="bulan" value="{{ $bulanSelected }}">
                        <input type="hidden" name="tahun" value="{{ $tahunSelected }}">
                        
                        <select name="filter_menu" class="form-control form-control-sm" onchange="this.form.submit()">
                            <option value="desc" {{ $filterMenu == 'desc' ? 'selected' : '' }}>Paling Laris</option>
                            <option value="asc" {{ $filterMenu == 'asc' ? 'selected' : '' }}>Paling Tidak Laris</option>
                        </select>
                    </form>
                </div>
                <div class="card-body p-0" style="max-height: 350px; overflow-y: auto;">
                    <table class="table table-hover table-striped mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th width="15%">No</th>
                                <th>Nama Menu</th>
                                <th width="30%" class="text-center">Kuantitas</th>
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
                                    <td colspan="3" class="text-center py-4 text-muted">Tidak ada data transaksi.</td>
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
                    <h6 class="font-weight-bold mb-0 text-dark">Tren Omzet</h6>
                </div>
                <div class="card-body d-flex align-items-center">
                    <canvas id="chartLaporan"></canvas>
                </div>
            </div>
        </div>

    </div>
</div>

{{-- 4. SCRIPT GRAFIK --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    new Chart(document.getElementById('chartLaporan'), {
        type: 'line',
        data: {
            labels: @json($labels),
            datasets: [{
                label: 'Omzet (Rp)',
                data: @json($penjualanGrafik->pluck('total')),
                borderColor: '#28a745',
                backgroundColor: 'rgba(40, 167, 69, 0.1)',
                fill: true,
                tension: 0.1
            }]
        },
        options: { 
            responsive: true, 
            plugins: { legend: { display: false } } 
        }
    });
</script>
@endsection
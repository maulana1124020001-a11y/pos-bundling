@extends('layouts.app')

@section('content')
<div class="container-fluid">

    {{-- HEADER: Menampilkan judul dan sub-judul dinamis tergantung apakah memilih satu bulan atau semua bulan --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="font-weight-bold mb-1">Laporan Keuangan</h3>
            <small>Periode Terpilih: {{ $bulanSelected == 'semua' ? 'Tahun Penuh' : $listBulan[$bulanSelected] }} {{ $tahunSelected }}</small>
        </div>
    </div>

    {{-- FORM FILTER: Dropdown filter dengan tambahan opsi 'Semua Bulan' --}}
    <form method="GET" action="{{ route('laporan.index') }}" class="form-row mb-4">
        <div class="col-md-3 mb-2">
            <select name="bulan" class="form-control form-control-sm" onchange="this.form.submit()">
                @foreach($listBulan as $value => $nama)
                    <option value="{{ $value }}" {{ $bulanSelected == $value ? 'selected' : '' }}>{{ $nama }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2 mb-2">
            <select name="tahun" class="form-control form-control-sm" onchange="this.form.submit()">
                @foreach($listTahun as $thn)
                    <option value="{{ $thn }}" {{ $tahunSelected == $thn ? 'selected' : '' }}>{{ $thn }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2 mb-2">
            <button type="button" class="btn btn-sm btn-outline-secondary w-100" onclick="window.print()"><i class="fas fa-print"></i> Cetak Laporan</button>
        </div>
    </form>

    {{-- BARIS CARD STATISTIK --}}
    <div class="row">
        <div class="col-xl col-md-6 mb-4">
            <div class="card card-body d-flex justify-content-between align-items-center flex-row shadow-sm">
                <div><div>Total Omzet</div><div class="h4 font-weight-bold mb-0">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</div></div>
                <i class="fas fa-dollar-sign fa-2x text-primary"></i>
            </div>
        </div>
        <div class="col-xl col-md-6 mb-4">
            <div class="card card-body d-flex justify-content-between align-items-center flex-row shadow-sm">
                <div><div>Total Modal</div><div class="h4 font-weight-bold mb-0">Rp {{ number_format($totalModal, 0, ',', '.') }}</div></div>
                <i class="fas fa-wallet fa-2x text-warning"></i>
            </div>
        </div>
        <div class="col-xl col-md-6 mb-4">
            <div class="card card-body d-flex justify-content-between align-items-center flex-row shadow-sm">
                <div><div>Keuntungan Bersih</div><div class="h4 font-weight-bold text-success mb-0">Rp {{ number_format($keuntunganBersih, 0, ',', '.') }}</div></div>
                <i class="fas fa-chart-line fa-2x text-success"></i>
            </div>
        </div>
        <div class="col-xl col-md-6 mb-4">
            <div class="card card-body d-flex justify-content-between align-items-center flex-row shadow-sm">
                <div><div>Total Transaksi</div><div class="h4 font-weight-bold mb-0">{{ $jumlahTransaksi }} Transaksi</div></div>
                <i class="fas fa-shopping-cart fa-2x text-secondary"></i>
            </div>
        </div>
    </div>

    {{-- BARIS DETAIL UTAMA LAPORAN --}}
    <div class="row">
        {{-- TABEL LAPORAN PRODUK --}}
        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-white"><h6 class="font-weight-bold mb-0">Rincian Penjualan Produk</h6></div>
                <div class="card-body p-0" style="max-height: 400px; overflow-y: auto;">
                    <table class="table table-hover mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th width="10%">No</th>
                                <th>Nama Menu</th>
                                <th width="20%">Kuantitas</th>
                                <th width="30%">Subtotal Modal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($semuaMenu as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $item->menu->nama ?? '-' }}</td>
                                    <td>{{ $item->total_terjual }} Pcs</td>
                                    <td>Rp {{ number_format(($item->menu->modal ?? 0) * $item->total_terjual, 0, ',', '.') }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="4" class="text-center py-4">Tidak ada data transaksi pada periode ini</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- GRAFIK TREN PENJUALAN --}}
        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white"><h6 class="font-weight-bold mb-0">Tren Omzet Periode Ini</h6></div>
                <div class="card-body"><canvas id="chartLaporan"></canvas></div>
            </div>
        </div>
    </div>
</div>

{{-- LIBRARY CHART JS & CONFIGURATION --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('chartLaporan');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: @json($labels),
            datasets: [{
                label: 'Omzet Penjualan (Rp)',
                data: @json($penjualanGrafik->pluck('total')),
                borderColor: '#28a745',
                borderWidth: 2,
                tension: 0.2,
                fill: false
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } }
        }
    });
</script>
@endsection
@extends('layouts.app')

@section('content')

<div class="container-fluid">

    {{-- JUDUL --}}
    <div class="d-sm-flex align-items-center justify-content-between mb-4">

        <div>
            <h1 class="h3 mb-0 text-gray-800">
                Dashboard
            </h1>

           <small class="text-muted">

    {{ \Carbon\Carbon::parse('2026-06-01')->locale('id')->translatedFormat('l, d F Y') }}

</small>
        </div>

    </div>

    <!-- CARD -->
    <div class="row">

        <!-- JUMLAH MENU -->
        <div class="col-md-4 mb-4">

            <div class="card border-left-info shadow h-100 py-3">

                <div class="card-body d-flex justify-content-between align-items-center">

                    <div>

                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            Jumlah Menu
                        </div>

                        <div class="h4 font-weight-bold text-gray-800">
                            {{ $jumlahMenu }}
                        </div>

                    </div>

                    <i class="fas fa-utensils fa-2x text-gray-300"></i>

                </div>

            </div>

        </div>

        <!-- JUMLAH TRANSAKSI -->
        <div class="col-md-4 mb-4">

            <div class="card border-left-primary shadow h-100 py-3">

                <div class="card-body d-flex justify-content-between align-items-center">

                    <div>

                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Transaksi Bulan Ini
                        </div>

                        <div class="h4 font-weight-bold text-gray-800">
                            {{ $jumlahTransaksi }}
                        </div>

                    </div>

                    <i class="fas fa-shopping-cart fa-2x text-gray-300"></i>

                </div>

            </div>

        </div>

        <!-- PENDAPATAN -->
        <div class="col-md-4 mb-4">

            <div class="card border-left-success shadow h-100 py-3">

                <div class="card-body d-flex justify-content-between align-items-center">

                    <div>

                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Pendapatan Keseluruhan
                        </div>

                        <div class="h4 font-weight-bold text-gray-800">
                            Rp {{ number_format($totalPendapatan,0,',','.') }}
                        </div>

                    </div>

                    <i class="fas fa-wallet fa-2x text-gray-300"></i>

                </div>

            </div>

        </div>

        <!-- MODAL -->
        <div class="col-md-6 mb-4">

            <div class="card border-left-danger shadow h-100 py-3">

                <div class="card-body d-flex justify-content-between align-items-center">

                    <div>

                        <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                            Modal Bulan Ini
                        </div>

                        <div class="h4 font-weight-bold text-gray-800">
                            Rp {{ number_format($totalModal,0,',','.') }}
                        </div>

                    </div>

                    <i class="fas fa-money-bill-wave fa-2x text-gray-300"></i>

                </div>

            </div>

        </div>

        <!-- KEUNTUNGAN -->
        <div class="col-md-6 mb-4">

            <div class="card border-left-warning shadow h-100 py-3">

                <div class="card-body d-flex justify-content-between align-items-center">

                    <div>

                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Keuntungan Bersih Bulan Ini
                        </div>

                        <div class="h4 font-weight-bold text-gray-800">
                            Rp {{ number_format($keuntunganBersih,0,',','.') }}
                        </div>

                    </div>

                    <i class="fas fa-coins fa-2x text-gray-300"></i>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection
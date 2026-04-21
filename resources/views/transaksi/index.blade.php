@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <h1 class="h3 mb-3 text-gray-800">Data Transaksi</h1>

    <div class="card shadow mb-4">

        <div class="card-header py-3 d-flex justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Tabel Transaksi</h6>

            <a href="{{ route('transaksi.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Transaksi Baru
            </a>
        </div>

        <div class="card-body">

            @if(session('success'))
                <div id="alert-success" class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="dataTable">

                    <thead class="thead-light">
                        <tr>
                            <th>No</th>
                            <th>Kasir</th>
                            <th>Total</th>
                            <th>Bayar</th>
                            <th>Kembalian</th>
                            <th>Metode</th>
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
                            <td>{{ $t->waktu }}</td>
                            <td>
                                <a href="{{ route('transaksi.show',$t->id) }}" class="btn btn-info btn-sm">
                                    Detail
                                </a>
                                <form action="{{ route('transaksi.destroy', $t->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center">Belum ada transaksi</td>
                        </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>

        </div>
    </div>

</div>

@endsection
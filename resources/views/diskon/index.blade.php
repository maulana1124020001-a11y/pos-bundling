@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <!-- Judul -->
    <h1 class="h3 mb-3 text-gray-800">Data Diskon</h1>

    <!-- Card -->
    <div class="card shadow mb-4">

        <!-- Header -->
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Tabel Diskon</h6>

            <a href="{{ route('diskon.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Tambah Diskon
            </a>
        </div>

        <!-- Body -->
        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-bordered table-hover" id="dataTable" width="100%">
                    
                    <thead class="thead-light">
                        <tr>
                            <th>No</th>
                            <th>Menu</th>
                            <th>Tipe</th>
                            <th>Nilai Diskon</th>
                            <th>Periode</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($diskons as $d)
                        <tr>
                            <td>{{ $loop->iteration }}</td>

                            <td>{{ $d->menu->nama ?? '-' }}</td>

                            <td>
                                @if($d->tipe_diskon == 'Persen')
                                    <span class="badge bg-info text-white">Persen</span>
                                @else
                                    <span class="badge bg-secondary text-white">Nominal</span>
                                @endif
                            </td>

                            <td>
                                @if($d->tipe_diskon == 'Persen')
                                    {{ $d->diskon_persen }}%
                                @else
                                    Rp {{ number_format($d->diskon_nominal) }}
                                @endif
                            </td>

                            <td>
                                {{ $d->mulai_diskon }} <br>
                                s/d <br>
                                {{ $d->akhir_diskon }}
                            </td>

                            <td>
                              

                                <a href="{{ route('diskon.edit', $d->id) }}" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <form action="{{ route('diskon.destroy', $d->id) }}" method="POST" class="d-inline">
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
                            <td colspan="6" class="text-center">
                                Data diskon belum tersedia
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
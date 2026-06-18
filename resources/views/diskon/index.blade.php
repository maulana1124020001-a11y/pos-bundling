@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <!-- Judul -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-percent text-primary"></i> Data Diskon Menu
        </h1>
    </div>

    <!-- Card -->
    <div class="card shadow mb-4">

        <!-- Header -->
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Diskon</h6>

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
                            <th width="50" class="text-center">No</th>
                            <th>Menu</th>
                            <th>Tipe</th>
                            <th>Potongan</th>
                            <th>Periode</th>
                            <th>Status</th>
                            <th width="170" class="text-center">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($diskons as $d)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>

                            <td>{{ $d->menu?->nama }}</td>

                            <td>
                                <span class="badge bg-info text-white">
                                    {{ $d->tipe_diskon }}
                                </span>
                            </td>

                            <td>
                                {{ $d->tipe_diskon == 'Persen' 
                                    ? $d->diskon_persen . '%' 
                                    : 'Rp ' . number_format($d->diskon_nominal) }}
                            </td>

                            <td>
                                <small>
                                    {{ date('d M Y', strtotime($d->mulai_diskon)) }} s/d 
                                    {{ date('d M Y', strtotime($d->akhir_diskon)) }}
                                </small>
                            </td>

                            <td>
                                @if(now()->between($d->mulai_diskon, $d->akhir_diskon))
                                    <span class="badge bg-success text-white">Aktif</span>
                                @elseif(now()->lt($d->mulai_diskon))
                                    <span class="badge bg-warning text-white">Mendatang</span>
                                @else
                                    <span class="badge bg-danger text-white">Berakhir</span>
                                @endif
                            </td>

                            <td class="text-center">

                                <a href="{{ route('diskon.edit', $d->id) }}" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <form action="{{ route('diskon.destroy', $d->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')

                                    <button class="btn btn-danger btn-sm" onclick="return confirm('Hapus diskon ini?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>

                            </td>
                        </tr>

                        @empty
                        <tr>
                            <td colspan="7" class="text-center">
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
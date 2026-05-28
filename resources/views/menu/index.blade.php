@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <!-- Judul -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-utensils text-primary"></i> Data Menu
        </h1>
    </div>

    <!-- Card -->
    <div class="card shadow mb-4">

        <!-- Header -->

        
       <div class="card-header py-3 d-flex justify-content-between align-items-center">

    <h6 class="m-0 font-weight-bold text-primary">
        Daftar Menu
    </h6>

    <div>

        {{-- {{-- <a href="{{ route('menu.trash') }}" 
           class="btn btn-danger btn-sm">

            <i class="fas fa-trash-restore"></i> Sampah
        </a> --}}

        <a href="{{ route('menu.create') }}" 
           class="btn btn-primary btn-sm">

            <i class="fas fa-plus"></i> Tambah Menu
        </a>

    </div>

</div>

        <!-- Body -->
        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-bordered table-hover" id="dataTable" width="100%">
                    
                    <thead class="thead-light">
                        <tr>
                            <th width="50" class="text-center">No</th>
                            <th>Nama</th>
                            <th>Kategori</th>
                            <th>Harga</th>
                            <th>Gambar</th>
                            <th>Status</th>
                            <th width="170" class="text-center">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($menus as $m)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>{{ $m->nama }}</td>
                            <td>{{ $m?->kategori->nama_kategori ?? '-' }}</td>
                            <td>Rp {{ number_format($m->harga) }}</td>
                            <td>
                                @if($m->gambar)
                                    <img src="{{ asset('images/'.$m->gambar) }}" width="70">
                                @else
                                    -
                                @endif
                            </td>

                            <td>
                                @if($m->status == 'tersedia')
                                    <span class="badge bg-success text-white">Tersedia</span>
                                @else
                                    <span class="badge bg-danger text-white">Tidak Tersedia</span>
                                @endif
                            </td>

                            <td class="text-center">
                                <a href="{{ route('menu.show', $m->id) }}" class="btn btn-info btn-sm">
                                    <i class="fas fa-eye"></i>
                                </a>

                                <a href="{{ route('menu.edit', $m->id) }}" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <form action="{{ route('menu.destroy', $m->id) }}" method="POST" class="d-inline">
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
                            <td colspan="7" class="text-center">
                                Data menu belum tersedia
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
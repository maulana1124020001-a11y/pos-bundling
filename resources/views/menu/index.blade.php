@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <!-- Judul -->
    <h1 class="h3 mb-3 text-gray-800">Data Menu</h1>

    <!-- Card -->
    <div class="card shadow mb-4">

        <!-- Header -->
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Tabel Menu</h6>

            <a href="{{ route('menu.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Tambah Menu
            </a>
        </div>

        <!-- Body -->
        <div class="card-body">
            <div class="table-responsive">

                <table class="table table-bordered table-hover" id="dataTable" width="100%">
                    
                    <thead class="thead-light">
                        <tr>
                            <th>No</th>
                            
                            <th>Nama</th>
                            <th>Kategori</th>
                            <th>Harga</th>
                            <th>Gambar</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($menus as $m)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $m->nama }}</td>
                            <td>{{ $m->kategori->nama_kategori }}</td>
                            
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

                            <td>
                                <a href="{{ route('menu.show', $m->id) }}" class="btn btn-primary btn-sm">
                                    <i class="fas fa-info"></i>
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
                        @endforeach
                    </tbody>

                </table>

            </div>
        </div>
    </div>

</div>

@endsection
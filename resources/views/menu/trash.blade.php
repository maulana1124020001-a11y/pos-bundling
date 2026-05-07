@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <!-- Judul -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">

        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-trash text-danger"></i> Data Sampah Menu
        </h1>

    </div>

    <!-- Card -->
    <div class="card shadow mb-4">

        <!-- Header -->
        <div class="card-header py-3 d-flex justify-content-between align-items-center">

            <h6 class="m-0 font-weight-bold text-danger">
                Daftar Menu Terhapus
            </h6>
            

            <div>

                <a href="{{ route('menu.index') }}" 
                   class="btn btn-secondary btn-sm">

                    <i class="fas fa-arrow-left"></i> Kembali
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
                            <th>Deleted At</th>
                            <th width="170" class="text-center">Aksi</th>
                        </tr>

                    </thead>

                    <tbody>

                        @forelse($menus as $m)

                        <tr>

                            <td class="text-center">
                                {{ $loop->iteration }}
                            </td>

                            <td>
                                {{ $m->nama }}
                            </td>

                            <td>
                                {{ $m?->kategori->nama_kategori ?? '-' }}
                            </td>

                            <td>
                                Rp {{ number_format($m->harga,0,',','.') }}
                            </td>

                            <td>

                                @if($m->gambar)

                                    <img src="{{ asset('images/'.$m->gambar) }}" 
                                         width="70">

                                @else
                                    -
                                @endif

                            </td>

                            <td>
                                {{ $m->deleted_at }}
                            </td>

                            <td class="text-center">

                                <a href="{{ route('menu.restore', $m->id) }}"
                                   class="btn btn-success btn-sm">

                                    <i class="fas fa-undo"></i>

                                </a>

                            </td>

                        </tr>

                        @empty

                        <tr>

                            <td colspan="7" class="text-center">

                                Data sampah kosong

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
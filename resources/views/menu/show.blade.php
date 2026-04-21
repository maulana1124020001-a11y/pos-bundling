@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <!-- Judul -->
    <h1 class="h3 mb-3 text-gray-800">Detail Menu</h1>

    <!-- Card -->
    <div class="card shadow mb-4">

        <!-- Header -->
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                {{ $menu->nama }}
            </h6>
        </div>

        <!-- Body -->
        <div class="card-body">

            <div class="row">

                <!-- Gambar -->
                <div class="col-md-4 text-center">
                    @if($menu->gambar)
                        <img src="{{ asset('images/'.$menu->gambar) }}" 
                             class="img-fluid rounded mb-3"
                             style="max-height:250px;">
                    @else
                        <p class="text-muted">Tidak ada gambar</p>
                    @endif
                </div>

                <!-- Detail -->
                <div class="col-md-8">

                    <table class="table table-bordered">
                        <tr>
                            <th width="30%">Kategori</th>
                            <td>{{ $menu->kategori->nama_kategori ?? '-' }}</td>
                        </tr>

                        <tr>
                            <th>Nama Menu</th>
                            <td>{{ $menu->nama }}</td>
                        </tr>

                        <tr>
                            <th>Modal</th>
                            <td>Rp {{ number_format($menu->modal,0,',','.') }}</td>
                        </tr>

                        <tr>
                            <th>Harga</th>
                            <td>Rp {{ number_format($menu->harga,0,',','.') }}</td>
                        </tr>

                        <tr>
                            <th>Status</th>
                            <td>
                                @if($menu->status == 'tersedia')
                                    <span class="badge bg-success">Tersedia</span>
                                @else
                                    <span class="badge bg-danger">Tidak Tersedia</span>
                                @endif
                            </td>
                        </tr>
                    </table>

                    <a href="{{ route('menu.index') }}" class="btn btn-secondary">
                        Kembali
                    </a>

                    <a href="{{ route('menu.edit', $menu->id) }}" class="btn btn-warning">
                        Edit
                    </a>

                </div>

            </div>

        </div>
    </div>

</div>

@endsection
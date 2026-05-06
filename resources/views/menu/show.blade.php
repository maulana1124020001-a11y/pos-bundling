@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <!-- Judul -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-eye text-info"></i> Detail Menu
        </h1>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">

            <div class="card shadow mb-4 border-left-info">

                <!-- Header -->
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-info">
                        Informasi Menu
                    </h6>

                    <span class="badge {{ $menu->status == 'tersedia' ? 'badge-success' : 'badge-danger' }}">
                        {{ ucfirst($menu->status) }}
                    </span>
                </div>

                <div class="card-body">

                    <div class="row">
                        <!-- GAMBAR -->
                        <div class="col-md-5 text-center mb-4">
                            @if($menu->gambar)
                                <img src="{{ asset('images/'.$menu->gambar) }}" 
                                     class="img-fluid rounded shadow"
                                     style="max-height:300px;object-fit:cover;">
                            @else
                                <div class="text-muted">
                                    <i class="fas fa-image fa-3x"></i>
                                    <p>Tidak ada gambar</p>
                                </div>
                            @endif
                        </div>

                        <!-- DETAIL -->
                        <div class="col-md-7">

                            <table class="table table-borderless">
                                <tr>
                                    <th>Nama Menu</th>
                                    <td class="font-weight-bold">{{ $menu->nama }}</td>
                                </tr>

                                <tr>
                                    <th>Kategori</th>
                                    <td>
                                        <span class="badge badge-info">
                                            {{ $menu->kategori->nama_kategori }}
                                        </span>
                                    </td>
                                </tr>

                                <tr>
                                    <th>Modal</th>
                                    <td>Rp {{ number_format($menu->modal,0,',','.') }}</td>
                                </tr>

                                <tr>
                                    <th>Harga</th>
                                    <td class="text-success font-weight-bold">
                                        Rp {{ number_format($menu->harga,0,',','.') }}
                                    </td>
                                </tr>

                                <tr>
                                    <th>Profit</th>
                                    <td class="text-primary font-weight-bold">
                                        Rp {{ number_format($menu->harga - $menu->modal,0,',','.') }}
                                    </td>
                                </tr>

                                <tr>
                                    <th>Update</th>
                                    <td class="text-muted">
                                        {{ $menu->updated_at->format('d M Y H:i') }}
                                    </td>
                                </tr>
                            </table>

                        </div>
                    </div>

                    <hr>

                    <!-- Tombol -->
                    <div class="text-right">
                        <a href="{{ route('menu.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>

                        <a href="{{ route('menu.edit', $menu->id) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                    </div>

                </div>

            </div>

        </div>
    </div>

</div>

@endsection
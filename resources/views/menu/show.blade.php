@extends('layouts.app')

@section('content')
<<<<<<< HEAD
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-9 col-lg-8">
            
            <div class="card shadow-sm border-0">
                {{-- Card Header --}}
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center border-bottom">
                    <h5 class="mb-0 fw-bold text-dark">
                        <i class="fas fa-info-circle me-2 text-success"></i>Detail Menu
                    </h5>
                    <span class="badge {{ $menu->status == 'tersedia' ? 'bg-success' : 'bg-danger' }} text-white px-3 py-2 shadow-sm">
                        {{ ucfirst($menu->status) }}
                    </span>
                </div>

                <div class="card-body p-4">
                    <div class="row">
                        {{-- Bagian Gambar --}}
                        <div class="col-md-5 mb-4 mb-md-0">
                            <div class="sticky-top" style="top: 20px;">
                                @if($menu->gambar)
                                    <img src="{{ asset('images/'.$menu->gambar) }}" 
                                         class="rounded shadow-sm img-fluid border w-100" 
                                         style="max-height: 350px; object-fit: cover;">
                                @else
                                    <div class="bg-light rounded d-flex align-items-center justify-content-center border text-muted" style="height: 250px;">
                                        <div class="text-center">
                                            <i class="fas fa-image fa-3x mb-2"></i>
                                            <p class="small mb-0">Tidak ada gambar</p>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>

                        {{-- Bagian Informasi --}}
                        <div class="col-md-7">
                            <div class="table-responsive">
                                <table class="table table-borderless align-middle">
                                    <tr>
                                        <th class="text-muted fw-medium pb-3" style="width: 40%;">Nama Menu</th>
                                        <td class="fw-bold pb-3 text-dark">{{ $menu->nama }}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-muted fw-medium pb-3">Kategori</th>
                                        <td class="pb-3">
                                            <span class="badge bg-light text-secondary border px-3">
                                                {{ $menu->kategori->nama_kategori }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="text-muted fw-medium pb-3">Modal</th>
                                        <td class="pb-3 text-dark fw-semibold">Rp {{ number_format($menu->modal, 0, ',', '.') }}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-muted fw-medium pb-3">Harga Jual</th>
                                        <td class="pb-3 text-success fw-bold">Rp {{ number_format($menu->harga, 0, ',', '.') }}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-muted fw-medium pb-3">Profit</th>
                                        <td class="pb-3">
                                            <span class="text-primary fw-bold">
                                                Rp {{ number_format($menu->harga - $menu->modal, 0, ',', '.') }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="text-muted fw-medium pb-3">Terakhir Update</th>
                                        <td class="pb-3 text-muted small">
                                            <i class="far fa-clock me-1"></i>{{ $menu->updated_at->format('d M Y, H:i') }}
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>

                    <hr class="my-4 opacity-25">

                    {{-- Tombol Aksi --}}
                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('menu.index') }}" class="btn btn-outline-secondary px-4">
                            <i class="fas fa-arrow-left me-2"></i>Kembali
                        </a>
                        <a href="{{ route('menu.edit', $menu->id) }}" class="btn btn-warning px-4 text-white shadow-sm">
                            <i class="fas fa-edit me-2"></i>Edit Data
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
=======

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

>>>>>>> 4c0d07987c93858ba5f1c0c31c7592cc5a38e5a9
@endsection
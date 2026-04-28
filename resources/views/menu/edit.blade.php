@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            
            <div class="card shadow-sm border-0">
                {{-- Card Header --}}
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 font-weight-bold text-warning">
                        <i class="fas fa-edit me-1"></i> Edit Menu
                    </h5>
                </div>

                <div class="card-body p-4">
                    {{-- Validasi Error --}}
                    @if ($errors->any())
                        <div class="alert alert-danger border-0 shadow-sm">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('menu.update', $menu->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        {{-- Kategori --}}
                        <div class="mb-3">
                            <label class="form-label fw-bold">Kategori</label>
                            <select name="kategori_id" class="form-select @error('kategori_id') is-invalid @enderror form-control">
                                @foreach($kategoris as $k)
                                    <option value="{{ $k->id }}" {{ $menu->kategori_id == $k->id ? 'selected' : '' }}>
                                        {{ $k->nama_kategori }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Nama Menu --}}
                        <div class="mb-3">
                            <label class="form-label fw-bold">Nama Menu</label>
                            <input type="text" name="nama" value="{{ old('nama', $menu->nama) }}" 
                                   class="form-control @error('nama') is-invalid @enderror"
                                   placeholder="Masukkan nama menu">
                        </div>

                        {{-- Row untuk Modal & Harga --}}
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Modal</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" name="modal" value="{{ old('modal', $menu->modal) }}" 
                                           class="form-control @error('modal') is-invalid @enderror">
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Harga</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" name="harga" value="{{ old('harga', $menu->harga) }}" 
                                           class="form-control @error('harga') is-invalid @enderror">
                                </div>
                            </div>
                        </div>

                        {{-- Status --}}
                        <div class="mb-3">
                            <label class="form-label fw-bold">Status</label>
                            <select name="status" class="form-control">
                                <option value="tersedia" {{ $menu->status == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                                <option value="tidak tersedia" {{ $menu->status == 'tidak tersedia' ? 'selected' : '' }}>Tidak Tersedia</option>
                            </select>
                        </div

                        {{-- Gambar & Preview --}}
                        <div class="mb-4">
                            <label class="form-label fw-bold">Gambar</label>
                            @if($menu->gambar)
                                <div class="mb-3">
                                    <img src="{{ asset('images/'.$menu->gambar) }}" 
                                         class="rounded img-thumbnail shadow-sm" 
                                         style="width: 120px; height: 120px; object-fit: cover;">
                                </div>
                            @endif
                            <input type="file" name="gambar" class="form-control @error('gambar') is-invalid @enderror">
                            <div class="form-text mt-2 text-muted small">
                                * Kosongkan jika tidak ingin mengganti gambar.
                            </div>
                        </div>

                        <hr class="text-muted mb-4">

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('menu.index') }}" class="btn btn-light border px-4">Kembali</a>
                            <button type="submit" class="btn btn-warning px-4">
                                <i class="fas fa-save me-1"></i> Update Data
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
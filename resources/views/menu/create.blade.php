@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            
            <div class="card shadow-sm border-0">
                {{-- Card Header --}}
                <div class="card-header bg-white py-3 border-bottom">
                    <h5 class="mb-0 fw-bold text-dark">
                        <i class="fas fa-utensils me-2 text-info"></i>Tambah Menu Baru
                    </h5>
                </div>

                <div class="card-body p-4">
                    {{-- Alert Error Validation --}}
                    @if ($errors->any())
                        <div class="alert alert-danger border-0 shadow-sm">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('menu.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        {{-- Kategori --}}
                        <div class="mb-3">
                            <label class="form-label fw-bold">Kategori</label>
                            <select name="kategori_id" class="form-select @error('kategori_id') is-invalid @enderror">
                                <option value="" selected disabled>Pilih Kategori...</option>
                                @foreach($kategoris as $k)
                                    <option value="{{ $k->id }}" {{ old('kategori_id') == $k->id ? 'selected' : '' }}>
                                        {{ $k->nama_kategori }}
                                    </option>
                                @endforeach
                            </select>
                            @error('kategori_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                            {{-- Nama Menu --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold text-muted small text-uppercase">Nama Menu</label>
                                <input type="text" name="nama" value="{{ old('nama') }}" 
                                       class="form-control @error('nama') is-invalid @enderror shadow-sm" 
                                       placeholder="Misal: Nasi Goreng, Matcha Latte dll">
                                @error('nama')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            {{-- Modal --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Harga Modal</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" name="modal" value="{{ old('modal') }}" 
                                           class="form-control @error('modal') is-invalid @enderror">
                                </div>
                                @error('modal')
                                    <small class="text-danger" style="font-size: 12px;">{{ $message }}</small>
                                @enderror
                            </div>

                            {{-- Harga Jual --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Harga Jual</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" name="harga" value="{{ old('harga') }}" 
                                           class="form-control @error('harga') is-invalid @enderror">
                                </div>
                                @error('harga')
                                    <small class="text-danger" style="font-size: 12px;">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        {{-- Unggah Gambar --}}
                        <div class="mb-4">
                            <label class="form-label fw-bold">Gambar Menu</label>
                            <input type="file" name="gambar" class="form-control @error('gambar') is-invalid @enderror">
                            <div class="form-text">Format: JPG, PNG, atau WEBP. Maks 2MB.</div>
                            @error('gambar')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <hr class="text-muted">

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('menu.index') }}" class="btn btn-outline-secondary px-4">
                                Batal
                            </a>
                            <button type="submit" class="btn btn-info px-4 shadow-sm">
                                <i class="fas fa-save me-2"></i>Simpan Menu
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
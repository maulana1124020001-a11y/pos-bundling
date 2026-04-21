@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-7 col-lg-6">
            
            <div class="card shadow-sm border-0">
                {{-- Card Header --}}
                <div class="card-header bg-white py-3 border-bottom">
                    <h5 class="mb-0 fw-bold text-dark">
                        <i class="fas fa-edit me-2 text-warning"></i>Edit Kategori
                    </h5>
                </div>

                <div class="card-body p-4">
                    {{-- Alert Error Validation --}}
                    @if ($errors->any())
                        <div class="alert alert-danger border-0 shadow-sm mb-4">
                            <div class="d-flex">
                                <i class="fas fa-exclamation-circle me-2 mt-1"></i>
                                <ul class="mb-0 ps-3">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif

                    <form action="{{ route('kategori.update', $kategori->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="nama_kategori" class="form-label fw-bold text-muted small text-uppercase">NAMA KATEGORI</label>
                            <input type="text" 
                                   name="nama_kategori" 
                                   id="nama_kategori"
                                   value="{{ old('nama_kategori', $kategori->nama_kategori) }}" 
                                   class="form-control @error('nama_kategori') is-invalid @enderror shadow-sm"
                                   placeholder="Masukkan nama kategori"
                                   required>
                            @error('nama_kategori')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <hr class="my-4 opacity-25">

                        {{-- Tombol Aksi --}}
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('kategori.index') }}" class="btn btn-outline-secondary px-4">
                                Batal
                            </a>
                            <button type="submit" class="btn btn-warning px-4 text-white shadow-sm">
                                <i class="fas fa-save me-2"></i>Update Kategori
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
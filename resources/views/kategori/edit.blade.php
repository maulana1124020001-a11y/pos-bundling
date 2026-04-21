@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            
            <div class="card shadow-sm border-0">
                {{-- Card Header --}}
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 font-weight-bold text-warning">
                        <i class="fas fa-edit me-1"></i> Edit Kategori
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

                    <form action="{{ route('kategori.update', $kategori->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="nama_kategori" class="form-label fw-bold">Nama Kategori</label>
                            <input type="text" 
                                   name="nama_kategori" 
                                   id="nama_kategori"
                                   value="{{ old('nama_kategori', $kategori->nama_kategori) }}" 
                                   class="form-control @error('nama_kategori') is-invalid @enderror"
                                   placeholder="Masukkan nama kategori"
                                   required>
                            
                            @error('nama_kategori')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <hr class="text-muted">

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('kategori.index') }}" class="btn btn-light border">
                                Kembali
                            </a>
                            <button type="submit" class="btn btn-warning px-4">
                                <i class="fas fa-check-circle me-1"></i> Update Data
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <small class="text-muted mt-3 d-block text-center">
                ID Kategori: #{{ $kategori->id }}
            </small>
        </div>
    </div>
</div>
@endsection
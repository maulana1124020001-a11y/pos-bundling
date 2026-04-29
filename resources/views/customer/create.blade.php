@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-7 col-lg-6">
            
            <div class="card shadow-sm border-0">
                {{-- Card Header --}}
                <div class="card-header bg-white py-3 border-bottom">
                    <h5 class="mb-0 fw-bold text-dark">
                        <i class="fas fa-user-plus me-2 text-primary"></i>Tambah Customer
                    </h5>
                </div>

                <div class="card-body p-4">

                    {{-- Alert Error --}}
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

                    <form action="{{ route('customer.store') }}" method="POST">
                        @csrf

                        {{-- Nama --}}
                        <div class="mb-3">
                            <label class="form-label fw-bold text-muted small">NAMA CUSTOMER</label>
                            <input type="text" 
                                   name="nama" 
                                   value="{{ old('nama') }}" 
                                   class="form-control @error('nama') is-invalid @enderror shadow-sm"
                                   placeholder="Masukkan nama customer"
                                   required>
                            @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- No HP --}}
                        <div class="mb-3">
                            <label class="form-label fw-bold text-muted small">NO HP</label>
                            <input type="text" 
                                   name="no_hp" 
                                   value="{{ old('no_hp') }}" 
                                   class="form-control @error('no_hp') is-invalid @enderror shadow-sm"
                                   placeholder="Contoh: 08123456789"
                                   required>
                            @error('no_hp')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <hr class="my-4 opacity-25">

                        {{-- Tombol --}}
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('customer.index') }}" class="btn btn-outline-secondary px-4">
                                Batal
                            </a>
                            <button type="submit" class="btn btn-primary px-4 shadow-sm">
                                <i class="fas fa-save me-2"></i>Simpan Customer
                            </button>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
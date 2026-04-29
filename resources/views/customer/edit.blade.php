@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            
            <div class="card shadow-sm border-0">
                {{-- Card Header --}}
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 font-weight-bold text-warning">
                        <i class="fas fa-edit me-1"></i> Edit Customer
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

                    <form action="{{ route('customer.update', $customer->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        {{-- Nama --}}
                        <div class="mb-3">
                            <label for="nama" class="form-label fw-bold">Nama Customer</label>
                            <input type="text" 
                                   name="nama" 
                                   id="nama"
                                   value="{{ old('nama', $customer->nama) }}" 
                                   class="form-control @error('nama') is-invalid @enderror"
                                   placeholder="Masukkan nama customer"
                                   required>
                            
                            @error('nama')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- No HP --}}
                        <div class="mb-4">
                            <label for="no_hp" class="form-label fw-bold">No HP</label>
                            <input type="text" 
                                   name="no_hp" 
                                   id="no_hp"
                                   value="{{ old('no_hp', $customer->no_hp) }}" 
                                   class="form-control @error('no_hp') is-invalid @enderror"
                                   placeholder="Contoh: 08123456789"
                                   required>

                            @error('no_hp')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <hr class="text-muted">

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('customer.index') }}" class="btn btn-light border">
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
                ID CUSTOMER: #{{ $customer->id }}
            </small>
        </div>
    </div>
</div>
@endsection
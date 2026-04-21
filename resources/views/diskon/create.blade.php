@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-9 col-lg-8">
            
            <div class="card shadow-sm border-0">
                {{-- Card Header --}}
                <div class="card-header bg-white py-3 border-bottom">
                    <h5 class="mb-0 fw-bold text-dark">
                        <i class="fas fa-percentage me-2 text-danger"></i>Tambah Diskon Baru
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

                    <form action="{{ route('diskon.store') }}" method="POST">
                        @csrf

                        {{-- Menu yang Didiskon --}}
                        <div class="mb-4">
                            <label class="form-label fw-bold text-muted small text-uppercase">Pilih Menu</label>
                            <select name="menu_id" class="form-select @error('menu_id') is-invalid @enderror shadow-sm">
                                <option value="" selected disabled>Pilih Menu yang akan didiskon...</option>
                                @foreach($menus as $m)
                                    <option value="{{ $m->id }}" {{ old('menu_id') == $m->id ? 'selected' : '' }}>
                                        {{ $m->nama }} - (Rp {{ number_format($m->harga, 0, ',', '.') }})
                                    </option>
                                @endforeach
                            </select>
                            @error('menu_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            {{-- Tipe Diskon --}}
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-bold text-muted small text-uppercase">Tipe Diskon</label>
                                <select name="tipe_diskon" class="form-select shadow-sm @error('tipe_diskon') is-invalid @enderror">
                                    <option value="Persen" {{ old('tipe_diskon') == 'Persen' ? 'selected' : '' }}>Persen (%)</option>
                                    <option value="Nominal" {{ old('tipe_diskon') == 'Nominal' ? 'selected' : '' }}>Nominal (Rp)</option>
                                </select>
                            </div>

                            {{-- Diskon Persen --}}
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-bold text-muted small text-uppercase">Diskon (%)</label>
                                <div class="input-group shadow-sm">
                                    <input type="number" name="diskon_persen" value="{{ old('diskon_persen') }}" 
                                           class="form-control @error('diskon_persen') is-invalid @enderror" placeholder="0">
                                    <span class="input-group-text bg-light">%</span>
                                </div>
                            </div>

                            {{-- Diskon Nominal --}}
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-bold text-muted small text-uppercase">Diskon (Rp)</label>
                                <div class="input-group shadow-sm">
                                    <span class="input-group-text bg-light border-end-0">Rp</span>
                                    <input type="number" name="diskon_nominal" value="{{ old('diskon_nominal') }}" 
                                           class="form-control border-start-0 @error('diskon_nominal') is-invalid @enderror" placeholder="0">
                                </div>
                            </div>
                        </div>

                        <div class="row mt-2">
                            {{-- Mulai --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold text-muted small text-uppercase">Mulai Diskon</label>
                                <input type="datetime-local" name="mulai_diskon" value="{{ old('mulai_diskon') }}" 
                                       class="form-control shadow-sm @error('mulai_diskon') is-invalid @enderror">
                                @error('mulai_diskon')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Akhir --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold text-muted small text-uppercase">Akhir Diskon</label>
                                <input type="datetime-local" name="akhir_diskon" value="{{ old('akhir_diskon') }}" 
                                       class="form-control shadow-sm @error('akhir_diskon') is-invalid @enderror">
                                @error('akhir_diskon')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <hr class="my-4 opacity-25">

                        {{-- Tombol Aksi --}}
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('diskon.index') }}" class="btn btn-outline-secondary px-4">
                                Batal
                            </a>
                            <button type="submit" class="btn btn-primary px-4 shadow-sm">
                                <i class="fas fa-save me-2"></i>Simpan Diskon
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-9 col-lg-8">
            
            <div class="card shadow-sm border-0">

                <!-- Header -->
                <div class="card-header bg-white py-3 border-bottom">
                    <h5 class="mb-0 fw-bold text-dark">
                        <i class="fas fa-tags me-2 text-info"></i>Tambah Diskon
                    </h5>
                </div>

                <div class="card-body p-4">

                    <!-- Error -->
                    @if ($errors->any())
                        <div class="alert alert-danger border-0 shadow-sm mb-4">
                            <ul class="mb-0 ps-3">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('diskon.store') }}" method="POST">
                        @csrf

                        <!-- Menu -->
                        <div class="mb-3">
                            <label class="form-label fw-bold text-muted small text-uppercase">Menu</label>
                            <select name="menu_id" class="form-select shadow-sm @error('menu_id') is-invalid @enderror">
                                <option value="" disabled selected>Pilih Menu...</option>
                                @foreach($menus as $m)
                                    <option value="{{ $m->id }}" {{ old('menu_id') == $m->id ? 'selected' : '' }}>
                                        {{ $m->nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('menu_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Tipe Diskon -->
                        <div class="mb-3">
                            <label class="form-label fw-bold text-muted small text-uppercase">Tipe Diskon</label>
                            <select name="tipe_diskon" id="tipe_diskon"
                                    class="form-select shadow-sm @error('tipe_diskon') is-invalid @enderror">
                                <option value="Persen">Persen (%)</option>
                                <option value="Nominal">Nominal (Rp)</option>
                            </select>
                        </div>

                        <div class="row">
                            <!-- Persen -->
                            <div class="col-md-6 mb-3" id="field_persen">
                                <label class="form-label fw-bold text-muted small text-uppercase">Diskon Persen</label>
                                <div class="input-group shadow-sm">
                                    <input type="number" name="diskon_persen" value="{{ old('diskon_persen') }}"
                                           class="form-control">
                                    <span class="input-group-text">%</span>
                                </div>
                            </div>

                            <!-- Nominal -->
                            <div class="col-md-6 mb-3" id="field_nominal">
                                <label class="form-label fw-bold text-muted small text-uppercase">Diskon Nominal</label>
                                <div class="input-group shadow-sm">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" name="diskon_nominal" value="{{ old('diskon_nominal') }}"
                                           class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Mulai -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold text-muted small text-uppercase">Mulai Diskon</label>
                                <input type="datetime-local" name="mulai_diskon"
                                       value="{{ old('mulai_diskon') }}"
                                       class="form-control shadow-sm">
                            </div>

                            <!-- Akhir -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold text-muted small text-uppercase">Akhir Diskon</label>
                                <input type="datetime-local" name="akhir_diskon"
                                       value="{{ old('akhir_diskon') }}"
                                       class="form-control shadow-sm">
                            </div>
                        </div>

                        <hr class="my-4 opacity-25">

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('diskon.index') }}" class="btn btn-outline-secondary px-4">
                                Batal
                            </a>
                            <button type="submit" class="btn btn-info px-4 shadow-sm">
                                <i class="fas fa-save me-2"></i>Simpan Diskon
                            </button>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>
</div>

<!-- JS Toggle -->
<script>
document.getElementById('tipe_diskon').addEventListener('change', function () {
    let tipe = this.value;

    document.getElementById('field_persen').style.display = (tipe === 'Persen') ? 'block' : 'none';
    document.getElementById('field_nominal').style.display = (tipe === 'Nominal') ? 'block' : 'none';
});
</script>

@endsection
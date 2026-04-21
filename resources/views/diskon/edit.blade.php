@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-9 col-lg-8">
            
            <div class="card shadow-sm border-0">

                <!-- Header -->
                <div class="card-header bg-white py-3 border-bottom">
                    <h5 class="mb-0 fw-bold text-dark">
                        <i class="fas fa-edit me-2 text-warning"></i>Edit Diskon
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

                    <form action="{{ route('diskon.update', $diskon->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Menu -->
                        <div class="mb-3">
                            <label class="form-label fw-bold text-muted small text-uppercase">Menu</label>
                            <select name="menu_id" class="form-select shadow-sm">
                                @foreach($menus as $m)
                                    <option value="{{ $m->id }}" 
                                        {{ $m->id == $diskon->menu_id ? 'selected' : '' }}>
                                        {{ $m->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Tipe Diskon -->
                        <div class="mb-3">
                            <label class="form-label fw-bold text-muted small text-uppercase">Tipe Diskon</label>
                            <select name="tipe_diskon" id="tipe_diskon" class="form-select shadow-sm">
                                <option value="Persen" {{ $diskon->tipe_diskon=='Persen'?'selected':'' }}>
                                    Persen (%)
                                </option>
                                <option value="Nominal" {{ $diskon->tipe_diskon=='Nominal'?'selected':'' }}>
                                    Nominal (Rp)
                                </option>
                            </select>
                        </div>

                        <div class="row">
                            <!-- Persen -->
                            <div class="col-md-6 mb-3" id="field_persen">
                                <label class="form-label fw-bold text-muted small text-uppercase">Diskon Persen</label>
                                <div class="input-group shadow-sm">
                                    <input type="number" name="diskon_persen" 
                                           value="{{ $diskon->diskon_persen }}" class="form-control">
                                    <span class="input-group-text">%</span>
                                </div>
                            </div>

                            <!-- Nominal -->
                            <div class="col-md-6 mb-3" id="field_nominal">
                                <label class="form-label fw-bold text-muted small text-uppercase">Diskon Nominal</label>
                                <div class="input-group shadow-sm">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" name="diskon_nominal" 
                                           value="{{ $diskon->diskon_nominal }}" class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Mulai -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold text-muted small text-uppercase">Mulai Diskon</label>
                                <input type="datetime-local" name="mulai_diskon"
                                       value="{{ \Carbon\Carbon::parse($diskon->mulai_diskon)->format('Y-m-d\TH:i') }}"
                                       class="form-control shadow-sm">
                            </div>

                            <!-- Akhir -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold text-muted small text-uppercase">Akhir Diskon</label>
                                <input type="datetime-local" name="akhir_diskon"
                                       value="{{ \Carbon\Carbon::parse($diskon->akhir_diskon)->format('Y-m-d\TH:i') }}"
                                       class="form-control shadow-sm">
                            </div>
                        </div>

                        <hr class="my-4 opacity-25">

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('diskon.index') }}" class="btn btn-outline-secondary px-4">
                                Batal
                            </a>
                            <button type="submit" class="btn btn-warning px-4 shadow-sm">
                                <i class="fas fa-save me-2"></i>Update Diskon
                            </button>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>
</div>

<!-- Toggle Script -->
<script>
function toggleDiskon() {
    let tipe = document.getElementById('tipe_diskon').value;

    document.getElementById('field_persen').style.display =
        (tipe === 'Persen') ? 'block' : 'none';

    document.getElementById('field_nominal').style.display =
        (tipe === 'Nominal') ? 'block' : 'none';
}

// jalan saat load
toggleDiskon();

// jalan saat change
document.getElementById('tipe_diskon').addEventListener('change', toggleDiskon);
</script>

@endsection
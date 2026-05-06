@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <!-- Judul -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-edit text-warning"></i> Edit Diskon
        </h1>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">

            <div class="card shadow mb-4 border-left-warning">

                <!-- Header -->
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-warning">
                        Form Edit Diskon
                    </h6>
                </div>

                <div class="card-body">

                    {{-- ERROR --}}
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('diskon.update', $diskon->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            {{-- MENU --}}
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="font-weight-bold">Menu</label>
                                    <select name="menu_id" class="form-control">
                                        @foreach($menus as $m)
                                            <option value="{{ $m->id }}" {{ $m->id == $diskon->menu_id ? 'selected' : '' }}>
                                                {{ $m->nama }} (Rp {{ number_format($m->harga,0,',','.') }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            {{-- TIPE --}}
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="font-weight-bold">Tipe Diskon</label>
                                    <select name="tipe_diskon" id="tipe_diskon" class="form-control">
                                        <option value="Persen" {{ $diskon->tipe_diskon == 'Persen' ? 'selected' : '' }}>
                                            Persen (%)
                                        </option>
                                        <option value="Nominal" {{ $diskon->tipe_diskon == 'Nominal' ? 'selected' : '' }}>
                                            Nominal (Rp)
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            {{-- PERSEN --}}
                            <div id="input_persen" class="col-md-6 {{ $diskon->tipe_diskon == 'Persen' ? '' : 'd-none' }}">
                                <div class="form-group">
                                    <label class="font-weight-bold">Diskon Persen (%)</label>
                                    <input type="number" name="diskon_persen" 
                                           class="form-control"
                                           value="{{ $diskon->diskon_persen }}" min="1" max="100">
                                </div>
                            </div>

                            {{-- NOMINAL --}}
                            <div id="input_nominal" class="col-md-6 {{ $diskon->tipe_diskon == 'Nominal' ? '' : 'd-none' }}">
                                <div class="form-group">
                                    <label class="font-weight-bold">Diskon Nominal</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Rp</span>
                                        </div>
                                        <input type="number" name="diskon_nominal" 
                                               class="form-control"
                                               value="{{ $diskon->diskon_nominal }}">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            {{-- MULAI --}}
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="font-weight-bold">Mulai Diskon</label>
                                    <input type="datetime-local" name="mulai_diskon" 
                                           class="form-control"
                                           value="{{ date('Y-m-d\TH:i', strtotime($diskon->mulai_diskon)) }}">
                                </div>
                            </div>

                            {{-- AKHIR --}}
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="font-weight-bold">Akhir Diskon</label>
                                    <input type="datetime-local" name="akhir_diskon" 
                                           class="form-control"
                                           value="{{ date('Y-m-d\TH:i', strtotime($diskon->akhir_diskon)) }}">
                                </div>
                            </div>
                        </div>

                        <hr>

                        <!-- Tombol -->
                        <div class="text-right">
                            <a href="{{ route('diskon.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Batal
                            </a>

                            <button type="submit" class="btn btn-warning">
                                <i class="fas fa-save"></i> Update
                            </button>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>

</div>

<script>
    const tipe = document.getElementById('tipe_diskon');
    const persen = document.getElementById('input_persen');
    const nominal = document.getElementById('input_nominal');

    tipe.addEventListener('change', function() {
        if (this.value === 'Persen') {
            persen.classList.remove('d-none');
            nominal.classList.add('d-none');
        } else {
            persen.classList.add('d-none');
            nominal.classList.remove('d-none');
        }
    });
</script>

@endsection
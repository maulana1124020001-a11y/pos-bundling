@extends('layouts.app')

@section('content')

    <div class="container-fluid">

    <!-- Judul -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-plus-circle text-primary"></i> Tambah Diskon
        </h1>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">

            <!-- Card -->
            <div class="card shadow mb-4">

                <!-- Header -->
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        Form Tambah Diskon
                    </h6>
                </div>

                <!-- Body -->
                <div class="card-body">

                    <!-- VALIDASI ERROR -->
                    @if ($errors->any())
                        <!-- alert bootstrap -->
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                <!-- looping semua error -->
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('diskon.store') }}" method="POST">
                        @csrf

                        <div class="row">
                            {{-- Pilih Menu --}}
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="font-weight-bold">Pilih Menu</label>
                                    <select name="menu_id" class="form-control" required>
                                        @foreach($menus as $m)
                                            <option value="{{ $m->id }}">
                                                {{ $m->nama }} (Rp {{ number_format($m->harga) }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            {{-- Tipe Diskon --}}
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="font-weight-bold">Tipe Diskon</label>
                                    <select name="tipe_diskon" id="tipe_diskon" class="form-control" required>
                                        <option value="Persen">Persen (%)</option>
                                        <option value="Nominal">Nominal (Rp)</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            {{-- Persen --}}
                            <div id="input_persen" class="col-md-6">
                                <div class="form-group">
                                    <label class="font-weight-bold">Diskon Persen (%)</label>
                                    <input type="number" name="diskon_persen" class="form-control" min="1" max="100">
                                </div>
                            </div>

                            {{-- Nominal --}}
                            <div id="input_nominal" class="col-md-6" style="display:none;">
                                <div class="form-group">
                                    <label class="font-weight-bold">Diskon Nominal (Rp)</label>
                                    <input type="number" name="diskon_nominal" class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            {{-- Mulai --}}
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="font-weight-bold">Mulai Diskon</label>
                                    <input type="datetime-local" name="mulai_diskon" class="form-control" required>
                                </div>
                            </div>

                            {{-- Akhir --}}
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="font-weight-bold">Akhir Diskon</label>
                                    <input type="datetime-local" name="akhir_diskon" class="form-control" required>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <!-- Tombol -->
                        <div class="text-right">
                            <a href="{{ route('diskon.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Batal
                            </a>

                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Simpan
                            </button>
                        </div>

                    </form>

                </div>
            </div>

        <!-- Judul -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">
                <i class="fas fa-plus-circle text-primary"></i> Tambah Diskon
            </h1>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-8">

                <!-- Card -->
                <div class="card shadow mb-4">

                    <!-- Header -->
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">
                            Form Tambah Diskon
                        </h6>
                    </div>

                    <!-- Body -->
                    <div class="card-body">

                        <form action="{{ route('diskon.store') }}" method="POST">
                            @csrf

                            <div class="row">
                                {{-- Pilih Menu --}}
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="font-weight-bold">Pilih Menu</label>
                                        <select name="menu_id" class="form-control" required>
                                            @foreach($menus as $m)
                                                <option value="{{ $m->id }}">
                                                    {{ $m->nama }} (Rp {{ number_format($m->harga) }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                {{-- Tipe Diskon --}}
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="font-weight-bold">Tipe Diskon</label>
                                        <select name="tipe_diskon" id="tipe_diskon" class="form-control" required>
                                            <option value="Persen">Persen (%)</option>
                                            <option value="Nominal">Nominal (Rp)</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                {{-- Persen --}}
                                <div id="input_persen" class="col-md-6">
                                    <div class="form-group">
                                        <label class="font-weight-bold">Diskon Persen (%)</label>
                                        <input type="number" name="diskon_persen" class="form-control" min="1" max="100">
                                    </div>
                                </div>
                               
                                @error('diskon_persen')
                                    <small class="text-danger">
                                        {{ $message }}
                                    </small>
                                @enderror

                                {{-- Nominal --}}
                                <div id="input_nominal" class="col-md-6" style="display:none;">
                                    <div class="form-group">
                                        <label class="font-weight-bold">Diskon Nominal (Rp)</label>
                                        <input type="number" name="diskon_nominal" class="form-control">
                                    </div>
                                </div>
                            </div>
                           

                            @error('diskon_nominal')
                                <small class="text-danger">
                                    {{ $message }}
                                </small>
                            @enderror


                            <div class="row">
                                {{-- Mulai --}}
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="font-weight-bold">Mulai Diskon</label>
                                        <input type="datetime-local" name="mulai_diskon" class="form-control" required>
                                    </div>
                                </div>

                                {{-- Akhir --}}
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="font-weight-bold">Akhir Diskon</label>
                                        <input type="datetime-local" name="akhir_diskon" class="form-control" required>
                                    </div>
                                </div>
                            </div>

                            <hr>

                            <!-- Tombol -->
                            <div class="text-right">
                                <a href="{{ route('diskon.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left"></i> Batal
                                </a>

                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Simpan
                                </button>
                            </div>

                        </form>

                    </div>
                </div>

            </div>
        </div>

    </div>

    <script>
        document.getElementById('tipe_diskon').addEventListener('change', function () {
            if (this.value === 'Persen') {
                document.getElementById('input_persen').style.display = 'block';
                document.getElementById('input_nominal').style.display = 'none';
            } else {
                document.getElementById('input_persen').style.display = 'none';
                document.getElementById('input_nominal').style.display = 'block';
            }
        });
    </script>

@endsection
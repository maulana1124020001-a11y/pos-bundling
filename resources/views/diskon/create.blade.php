@extends('layouts.app')

@section('content')

    <div class="container-fluid">

        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">
                <i class="fas fa-plus-circle text-primary"></i> Tambah Diskon
            </h1>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-8">

                <div class="card shadow mb-4 border-left-primary">

                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">
                            Form Tambah Diskon
                        </h6>
                    </div>

                    <div class="card-body">

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
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
                                                <option value="{{ $m->id }}" {{ old('menu_id') == $m->id ? 'selected' : '' }}>
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
                                            <option value="Persen" {{ old('tipe_diskon') == 'Persen' ? 'selected' : '' }}>Persen (%)</option>
                                            <option value="Nominal" {{ old('tipe_diskon') == 'Nominal' ? 'selected' : '' }}>Nominal (Rp)</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                {{-- Persen --}}
                                <div id="input_persen" class="col-md-6">
                                    <div class="form-group">
                                        <label class="font-weight-bold">Diskon Persen (%)</label>
                                        <input type="number" name="diskon_persen" class="form-control" min="1" max="100" value="{{ old('diskon_persen') }}">
                                        @error('diskon_persen')
                                            <small class="text-danger d-block mt-1">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Nominal --}}
                                <div id="input_nominal" class="col-md-6" style="display:none;">
                                    <div class="form-group">
                                        <label class="font-weight-bold">Diskon Nominal (Rp)</label>
                                        <input type="number" name="diskon_nominal" class="form-control" value="{{ old('diskon_nominal') }}">
                                        @error('diskon_nominal')
                                            <small class="text-danger d-block mt-1">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                {{-- Mulai --}}
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="font-weight-bold">Mulai Diskon</label>
                                        <input type="datetime-local" name="mulai_diskon" class="form-control" value="{{ old('mulai_diskon') }}" required>
                                        @error('mulai_diskon')
                                            <small class="text-danger d-block mt-1">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Akhir --}}
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="font-weight-bold">Akhir Diskon</label>
                                        <input type="datetime-local" name="akhir_diskon" class="form-control" value="{{ old('akhir_diskon') }}" required>
                                        @error('akhir_diskon')
                                            <small class="text-danger d-block mt-1">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <hr>

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

        // Trigger fungsi saat halaman dimuat ulang (menjaga state jika ada error dari server)
        window.addEventListener('DOMContentLoaded', function() {
            document.getElementById('tipe_diskon').dispatchEvent(new Event('change'));
        });
    </script>

@endsection
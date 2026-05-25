@extends('layouts.app')

@section('content')

<!-- SB Admin 2 pakai container-fluid, bukan container biasa -->
<div class="container-fluid">

    <!-- Judul halaman (style SB Admin 2) -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-plus-circle text-primary"></i> Tambah Kategori
        </h1>
    </div>

    <!-- Row untuk posisi tengah -->
    <div class="row justify-content-center">
        <div class="col-lg-6">

            <!-- Card utama (style SB Admin 2) -->
           
                 <div class="card shadow mb-4 border-left-primary">

                
                <!-- Header card -->
                <div class="card-header py-3">
                    <!-- class text-primary = warna biru khas SB Admin -->
                    <h6 class="m-0 font-weight-bold text-primary">
                        Form Tambah Kategori
                    </h6>
                </div>

                <!-- Body card -->
                <div class="card-body">

                    <!-- VALIDASI ERROR -->
                    {{-- @if ($errors->any())
                        <!-- alert bootstrap -->
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                <!-- looping semua error -->
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif --}}

                    <!-- FORM -->
                    <form action="{{ route('kategori.store') }}" method="POST">
                        @csrf <!-- wajib di Laravel untuk keamanan -->

                        <!-- INPUT NAMA KATEGORI -->
                        <div class="form-group">
                            <label class="font-weight-bold">Nama Kategori</label>

                            <!-- 
                                class form-control = input bootstrap
                                is-invalid = otomatis merah kalau error
                            -->
                            <input type="text" 
                                   name="nama_kategori"
                                   value="{{ old('nama_kategori') }}"
                                   class="form-control @error('nama_kategori') is-invalid @enderror"
                                   placeholder="Contoh: Makanan, Minuman"
                                   required>

                            <!-- tampilkan error spesifik field -->
                            @error('nama_kategori')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- GARIS PEMBATAS -->
                        <hr>

                        <!-- TOMBOL AKSI -->
                        <div class="text-right">
                            
                            <!-- tombol kembali -->
                            <a href="{{ route('kategori.index') }}" 
                               class="btn btn-secondary">
                                <!-- icon -->
                                <i class="fas fa-arrow-left"></i> Batal
                            </a>

                            <!-- tombol simpan -->
                            <button type="submit" 
                                    class="btn btn-primary">
                                <i class="fas fa-save"></i> Simpan
                            </button>

                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>

</div>

@endsection
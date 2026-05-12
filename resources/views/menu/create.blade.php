@extends('layouts.app')

@section('content')

    <div class="container-fluid">

        <!-- Judul halaman -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">
                <i class="fas fa-plus-circle text-primary"></i> Tambah Menu
            </h1>
        </div>

        <!-- Center Layout -->
        <div class="row justify-content-center">
            <div class="col-lg-8">

                <!-- Card -->
                <div class="card shadow mb-4 border-left-primary">

                    <!-- Header -->
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">
                            Form Tambah Menu
                        </h6>
                    </div>

                    <!-- Body -->
                    <div class="card-body">

                        <form action="{{ route('menu.store') }}" method="POST" enctype="multipart/form-data">

                            @csrf

                            <!-- Row 1 -->
                            <div class="row">

                                {{-- Kategori --}}
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="font-weight-bold">
                                            Kategori
                                        </label>

                                        <select name="kategori_id" class="form-control" required>

                                            <option value="" selected disabled>
                                                Pilih Kategori...
                                            </option>

                                            @foreach($kategoris as $k)
                                                <option value="{{ $k->id }}">
                                                    {{ $k->nama_kategori }}
                                                </option>
                                            @endforeach

                                        </select>
                                    </div>
                                </div>

                                {{-- Nama Menu --}}
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="font-weight-bold">
                                            Nama Menu
                                        </label>

                                        <input type="text" name="nama" class="form-control"
                                            placeholder="Misal: Nasi Goreng, Matcha Latte dll" required>
                                    </div>
                                </div>

                            </div>

                            <!-- Row 2 -->
                            <div class="row">

                                {{-- Harga Modal --}}
                                <div class="col-md-6">
                                    <div class="form-group">

                                        <label class="font-weight-bold">
                                            Harga Modal
                                        </label>

                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Rp</span>
                                            </div>

                                            <!-- Input ini HANYA untuk tampilan (User Interface) -->
                                            <input type="text" class="form-control" placeholder="0"
                                                oninput="formatRupiah(this, 'modal_asli')" required>
                                            <input type="hidden" name="modal" id="modal_asli">
                                        </div>

                                    </div>
                                </div>

                                {{-- Harga Jual --}}
                                <div class="col-md-6">
                                    <div class="form-group">

                                        <label class="font-weight-bold">
                                            Harga Jual
                                        </label>

                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Rp</span>
                                            </div>

                                            <!-- Input ini HANYA untuk tampilan (User Interface) -->
                                            <input type="text" class="form-control" placeholder="0"
                                                oninput="formatRupiah(this, 'harga_asli')" required>
                                            <input type="hidden" name="harga" id="harga_asli">
                                        </div>

                                    </div>
                                </div>

                            </div>

                            <!-- Row Gambar -->
                            <div class="row">
                                {{-- Input Gambar --}}
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="font-weight-bold">
                                            Gambar Menu
                                        </label>
                                        <input type="file" name="gambar" class="form-control" onchange="previewImage(event)"
                                            required>
                                        <small class="form-text text-muted">
                                            Format: JPG, PNG, WEBP. Maks 2MB.
                                        </small>
                                    </div>
                                </div>

                                {{-- Preview Gambar --}}
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <img id="preview" src="https://placehold.co/300x200?text=Preview+Gambar"
                                            class="img-fluid rounded" style="max-height: 130px; object-fit: cover;">
                                    </div>
                                </div>
                            </div>

                         

                            <!-- Tombol -->
                            <div class="text-right">

                                <a href="{{ route('menu.index') }}" class="btn btn-secondary">

                                    <i class="fas fa-arrow-left"></i>
                                    Batal
                                </a>

                                <button type="submit" class="btn btn-primary">

                                    <i class="fas fa-save"></i>
                                    Simpan
                                </button>

                            </div>

                        </form>

                    </div>
                </div>

            </div>
        </div>

    </div>

@endsection

<script src="{{ asset('js/format-harga.js') }}"></script>
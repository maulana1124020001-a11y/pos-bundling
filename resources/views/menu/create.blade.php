@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <!-- Judul halaman -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-plus-circle text-primary"></i> Tambah Menu
        </h1>
    </div>

    <!-- Center layout -->
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

                        <div class="row">
                            {{-- Kategori --}}
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="font-weight-bold">Kategori</label>
                                    <select name="kategori_id" class="form-control" required>
                                        <option value="" selected disabled>Pilih Kategori...</option>
                                        @foreach($kategoris as $k)
                                            <option value="{{ $k->id }}">{{ $k->nama_kategori }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            {{-- Nama Menu --}}
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="font-weight-bold">Nama Menu</label>
                                    <input type="text" name="nama" class="form-control"
                                           placeholder="Misal: Nasi Goreng, Matcha Latte dll" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            {{-- Modal --}}
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="font-weight-bold">Harga Modal</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Rp</span>
                                        </div>
                                        <input type="number" name="modal" class="form-control" required>
                                    </div>
                                </div>
                            </div>

                            {{-- Harga Jual --}}
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="font-weight-bold">Harga Jual</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Rp</span>
                                        </div>
                                        <input type="number" name="harga" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Gambar --}}
                        <div class="form-group">
                            <label class="font-weight-bold">Gambar Menu</label>
                            <input type="file" name="gambar" class="form-control" required>
                            <small class="form-text text-muted">
                                Format: JPG, PNG, WEBP. Maks 2MB.
                            </small>
                        </div>

                        <hr>

                        <!-- Tombol -->
                        <div class="text-right">
                            <a href="{{ route('menu.index') }}" class="btn btn-secondary">
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

@endsection
@extends('layouts.app')

@section('content')

<!-- container-fluid = standar layout SB Admin 2 -->
<div class="container-fluid">

    <!-- Judul halaman -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-edit text-warning"></i> Edit Kategori
        </h1>
    </div>

    <!-- Row -->
    <div class="row justify-content-center">
        <div class="col-lg-6">

            <!-- Card utama -->
            <div class="card shadow mb-4 border-left-warning">

                 <!-- Header Card -->

                <!-- Header Card -->
                <div class="card-header py-3">
                    <!-- text-warning = warna kuning (edit biasanya beda warna) -->
                    <h6 class="m-0 font-weight-bold text-warning">
                        Form Edit Kategori
                    </h6>
                </div>

                <!-- Body Card -->
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

                    <!-- FORM UPDATE -->
                    <form action="{{ route('kategori.update', $kategori->id) }}" method="POST">
                        @csrf
                        @method('PUT') <!-- method PUT untuk update data -->

                        <!-- INPUT NAMA -->
                        <div class="form-group">
                            <label class="font-weight-bold">Nama Kategori</label>

                            <!-- 
                                old() = agar value tidak hilang saat error
                                $kategori->nama_kategori = isi default dari database
                            -->
                            <input type="text"
                                   name="nama_kategori"
                                   value="{{ old('nama_kategori', $kategori->nama_kategori) }}"
                                   class="form-control @error('nama_kategori') is-invalid @enderror"
                                   placeholder="Masukkan nama kategori"
                                   required>

                            <!-- error per field -->
                            @error('nama_kategori')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- garis pembatas -->
                        <hr>

                        <!-- tombol aksi -->
                        <div class="text-right">

                            <!-- tombol kembali -->
                            <a href="{{ route('kategori.index') }}" 
                               class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>

                            <!-- tombol update -->
                            <button type="submit" 
                                    class="btn btn-warning">
                                <i class="fas fa-check-circle"></i> Update
                            </button>

                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>

</div>

@endsection
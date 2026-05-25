@extends('layouts.app')

@section('content')
    <div class="container-fluid">

        <!-- Judul -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">
                <i class="fas fa-edit text-warning"></i> Edit Menu
            </h1>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-8">

                <div class="card shadow mb-4 border-left-warning">

                    <!-- Header -->
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-warning">
                            Form Edit Menu
                        </h6>
                    </div>

                    <div class="card-body">

                        {{-- Error --}}
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('menu.update', $menu->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                {{-- Kategori --}}
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="font-weight-bold">Kategori</label>
                                        <select name="kategori_id" class="form-control">
                                            @foreach($kategoris as $k)
                                                <option value="{{ $k->id }}" {{ $menu->kategori_id == $k->id ? 'selected' : '' }}>
                                                    {{ $k->nama_kategori }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                {{-- Nama --}}
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="font-weight-bold">Nama Menu</label>
                                        <input type="text" name="nama" value="{{ old('nama', $menu->nama) }}"
                                            class="form-control">
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

                                            <!-- Input Tampilan (Text agar bisa pakai titik) -->
                                            <input type="text" class="form-control" id="modal_tampilan"
                                                placeholder="Masukkan harga modal"
                                                value="{{ number_format(old('modal', $menu->modal ?? 0), 0, ',', '.') }}"
                                                oninput="formatRupiah(this, 'modal_asli')" required>

                                            <!-- Input Hidden (Untuk dikirim ke Database) -->
                                            <input type="hidden" name="modal" id="modal_asli"
                                                value="{{ old('modal', $menu->modal ?? 0) }}">
                                        </div>
                                    </div>
                                </div>


                                {{-- Harga --}}
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="font-weight-bold">Harga Jual</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Rp</span>
                                            </div>

                                            <!-- Input Tampilan (Text agar bisa pakai titik) -->
                                            <input type="text" class="form-control" id="harga_tampilan"
                                                placeholder="Masukkan harga jual"
                                                value="{{ number_format(old('harga', $menu->harga ?? 0), 0, ',', '.') }}"
                                                oninput="formatRupiah(this, 'harga_asli')" required>

                                            <!-- Input Hidden (Untuk dikirim ke Database) -->
                                            <input type="hidden" name="harga" id="harga_asli"
                                                value="{{ old('harga', $menu->harga ?? 0) }}">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Status --}}
                            <div class="form-group">
                                <label class="font-weight-bold">Status</label>
                                <select name="status" class="form-control">
                                    <option value="tersedia" {{ $menu->status == 'tersedia' ? 'selected' : '' }}>Tersedia
                                    </option>
                                    <option value="tidak tersedia" {{ $menu->status == 'tidak tersedia' ? 'selected' : '' }}>
                                        Tidak Tersedia</option>
                                </select>
                            </div>

                            {{-- Gambar --}}
                            <div class="form-group">
                                <label class="font-weight-bold">Gambar</label>

                                <div class="mb-3">
                                    @if($menu->gambar)
                                        <!-- ID "preview" diletakkan di sini agar bisa diubah oleh JavaScript -->
                                        <img id="preview" src="{{ asset('images/' . $menu->gambar) }}"
                                           class="img-fluid rounded" style="max-height: 130px; object-fit: cover;">
                                    @else
                                        <img id="preview" src="https://placehold.co" class="img-thumbnail shadow"
                                            style="width:120px;height:120px;object-fit:cover;">
                                    @endif
                                      
                                </div>
                            

                                <!-- Tambahkan onchange="previewImage(event)" -->
                                <input type="file" name="gambar" class="form-control" onchange="previewImage(event)">
                                <small class="text-muted">
                                    Kosongkan jika tidak ingin mengganti gambar
                                </small>
                            </div>

                            <div class="text-right">
                                <a href="{{ route('menu.index') }}" class="btn btn-secondary">
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
@endsection

<script src="{{ asset('js/format-harga.js') }}"></script>
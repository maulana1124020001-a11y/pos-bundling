@extends('layouts.app')

@section('content')

<div class="container">
    <h3 class="mb-3">Tambah Kategori</h3>

    {{-- Error validation --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card">
        <div class="card-body">

            <form action="{{ route('kategori.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label>Nama Kategori</label>
                    <input type="text" 
                           name="nama_kategori" 
                           value="{{ old('nama_kategori') }}" 
                           class="form-control"
                           placeholder="Masukkan nama kategori">
                </div>

                <button class="btn btn-primary">Simpan</button>
                <a href="{{ route('kategori.index') }}" class="btn btn-secondary">Kembali</a>

            </form>

        </div>
    </div>
</div>

@endsection
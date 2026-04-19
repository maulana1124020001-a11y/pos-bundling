@extends('layouts.app')

@section('content')

<h3>Edit Menu</h3>

<form action="{{ route('menu.update', $menu->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label>Kategori</label>
        <select name="kategori_id" class="form-control">
            @foreach($kategoris as $k)
                <option value="{{ $k->id }}" 
                    {{ $menu->kategori_id == $k->id ? 'selected' : '' }}>
                    {{ $k->nama_kategori }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label>Nama Menu</label>
        <input type="text" name="nama" value="{{ $menu->nama }}" class="form-control">
    </div>

    <div class="mb-3">
        <label>Modal</label>
        <input type="number" name="modal" value="{{ $menu->modal }}" class="form-control">
    </div>

    <div class="mb-3">
        <label>Harga</label>
        <input type="number" name="harga" value="{{ $menu->harga }}" class="form-control">
    </div>

    <div class="mb-3">
        <label>Status</label>
        <select name="status" class="form-control">
            <option value="tersedia" {{ $menu->status == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
            <option value="tidak tersedia" {{ $menu->status == 'tidak tersedia' ? 'selected' : '' }}>Tidak Tersedia</option>
        </select>
    </div>

    <div class="mb-3">
        <label>Gambar</label><br>

        @if($menu->gambar)
            <img src="{{ asset('images/'.$menu->gambar) }}" width="100"><br><br>
        @endif

        <input type="file" name="gambar" class="form-control">
    </div>

    <button class="btn btn-success">Update</button>

</form>

@endsection
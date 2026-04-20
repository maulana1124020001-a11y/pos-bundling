@extends('layouts.app')

@section('content')

<h3>Tambah Bundling</h3>

<form action="{{ route('bundling.store') }}" method="POST">
    @csrf

    <div class="mb-3">
        <label>Menu Bundling</label>
        <select name="menu_id" class="form-control">
            <option value="">-- Pilih Menu --</option>
            @foreach($menus as $m)
                <option value="{{ $m->id }}">{{ $m->nama }}</option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label>Menu Item</label>
        <select name="menu_non_bundling_id" class="form-control">
            <option value="">-- Pilih Menu --</option>
            @foreach($menus as $m)
                <option value="{{ $m->id }}">{{ $m->nama }}</option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label>Harga Bundling</label>
        <input type="number" name="harga" class="form-control">
    </div>

    <button class="btn btn-primary">Simpan</button>
    <a href="{{ route('bundling.index') }}" class="btn btn-secondary">Kembali</a>

</form>

@endsection
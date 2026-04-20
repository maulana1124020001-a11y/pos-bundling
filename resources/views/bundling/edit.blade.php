@extends('layouts.app')

@section('content')

<h3>Edit Bundling</h3>

<form action="{{ route('bundling.update', $bundling->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label>Menu Bundling</label>
        <select name="menu_id" class="form-control">
            @foreach($menus as $m)
                <option value="{{ $m->id }}" 
                    {{ $bundling->menu_id == $m->id ? 'selected' : '' }}>
                    {{ $m->nama }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label>Menu Item</label>
        <select name="menu_non_bundling_id" class="form-control">
            @foreach($menus as $m)
                <option value="{{ $m->id }}" 
                    {{ $bundling->menu_non_bundling_id == $m->id ? 'selected' : '' }}>
                    {{ $m->nama }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label>Harga Bundling</label>
        <input type="number" name="harga" value="{{ $bundling->harga }}" class="form-control">
    </div>

    <button class="btn btn-success">Update</button>
    <a href="{{ route('bundling.index') }}" class="btn btn-secondary">Kembali</a>

</form>

@endsection
@extends('layouts.app')

@section('content')

<div class="container">
    <h3>Tambah Diskon</h3>

    <form action="{{ route('diskon.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>Menu</label>
            <select name="menu_id" class="form-control">
                @foreach($menus as $m)
                    <option value="{{ $m->id }}">{{ $m->nama }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Tipe Diskon</label>
            <select name="tipe_diskon" class="form-control">
                <option value="Persen">Persen</option>
                <option value="Nominal">Nominal</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Diskon Persen</label>
            <input type="number" name="diskon_persen" class="form-control">
        </div>

        <div class="mb-3">
            <label>Diskon Nominal</label>
            <input type="number" name="diskon_nominal" class="form-control">
        </div>

        <div class="mb-3">
            <label>Mulai</label>
            <input type="datetime-local" name="mulai_diskon" class="form-control">
        </div>

        <div class="mb-3">
            <label>Akhir</label>
            <input type="datetime-local" name="akhir_diskon" class="form-control">
        </div>

        <button class="btn btn-primary">Simpan</button>
    </form>

</div>

@endsection
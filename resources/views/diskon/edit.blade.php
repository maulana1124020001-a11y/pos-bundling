@extends('layouts.app')

@section('content')

<div class="container">
    <h3>Edit Diskon</h3>

    <form action="{{ route('diskon.update',$diskon->id) }}" method="POST">
        @csrf @method('PUT')

        <div class="mb-3">
            <label>Menu</label>
            <select name="menu_id" class="form-control">
                @foreach($menus as $m)
                    <option value="{{ $m->id }}" 
                        {{ $m->id == $diskon->menu_id ? 'selected' : '' }}>
                        {{ $m->nama }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Tipe Diskon</label>
            <select name="tipe_diskon" class="form-control">
                <option value="Persen" {{ $diskon->tipe_diskon=='Persen'?'selected':'' }}>Persen</option>
                <option value="Nominal" {{ $diskon->tipe_diskon=='Nominal'?'selected':'' }}>Nominal</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Diskon Persen</label>
            <input type="number" name="diskon_persen" value="{{ $diskon->diskon_persen }}" class="form-control">
        </div>

        <div class="mb-3">
            <label>Diskon Nominal</label>
            <input type="number" name="diskon_nominal" value="{{ $diskon->diskon_nominal }}" class="form-control">
        </div>

        <div class="mb-3">
            <label>Mulai</label>
            <input type="datetime-local" name="mulai_diskon" value="{{ $diskon->mulai_diskon }}" class="form-control">
        </div>

        <div class="mb-3">
            <label>Akhir</label>
            <input type="datetime-local" name="akhir_diskon" value="{{ $diskon->akhir_diskon }}" class="form-control">
        </div>

        <button class="btn btn-success">Update</button>
    </form>

</div>

@endsection
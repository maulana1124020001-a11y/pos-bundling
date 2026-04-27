@extends('layouts.app')

@section('content')
<div class="container">
    <h4>Edit Diskon: {{ $diskon->menu->nama }}</h4>
    <div class="card">
        <div class="card-body">
            <form action="{{ route('diskon.update', $diskon->id) }}" method="POST">
                @csrf @method('PUT')
                
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label>Menu</label>
                        <select name="menu_id" class="form-control">
                            @foreach($menus as $m)
                                <option value="{{ $m->id }}" {{ $m->id == $diskon->menu_id ? 'selected' : '' }}>
                                    {{ $m->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Tipe Diskon</label>
                        <select name="tipe_diskon" id="tipe_diskon" class="form-control">
                            <option value="Persen" {{ $diskon->tipe_diskon == 'Persen' ? 'selected' : '' }}>Persen (%)</option>
                            <option value="Nominal" {{ $diskon->tipe_diskon == 'Nominal' ? 'selected' : '' }}>Nominal (Rp)</option>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div id="input_persen" class="col-md-6 form-group" style="{{ $diskon->tipe_diskon == 'Persen' ? '' : 'display:none;' }}">
                        <label>Diskon Persen (%)</label>
                        <input type="number" name="diskon_persen" class="form-control" value="{{ $diskon->diskon_persen }}">
                    </div>
                    <div id="input_nominal" class="col-md-6 form-group" style="{{ $diskon->tipe_diskon == 'Nominal' ? '' : 'display:none;' }}">
                        <label>Diskon Nominal (Rp)</label>
                        <input type="number" name="diskon_nominal" class="form-control" value="{{ $diskon->diskon_nominal }}">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 form-group">
                        <label>Mulai Diskon</label>
                        <input type="datetime-local" name="mulai_diskon" class="form-control" value="{{ date('Y-m-d\TH:i', strtotime($diskon->mulai_diskon)) }}">
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Akhir Diskon</label>
                        <input type="datetime-local" name="akhir_diskon" class="form-control" value="{{ date('Y-m-d\TH:i', strtotime($diskon->akhir_diskon)) }}">
                    </div>
                </div>

                <button type="submit" class="btn btn-warning">Update Diskon</button>
            </form>
        </div>
    </div>
</div>

<script>
    document.getElementById('tipe_diskon').addEventListener('change', function() {
        const p = document.getElementById('input_persen');
        const n = document.getElementById('input_nominal');
        p.style.display = this.value === 'Persen' ? 'block' : 'none';
        n.style.display = this.value === 'Nominal' ? 'block' : 'none';
    });
</script>
@endsection
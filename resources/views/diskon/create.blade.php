@extends('layouts.app')

@section('content')
<div class="container">
    <h4>Tambah Diskon Baru</h4>
    <div class="card">
        <div class="card-body">
            <form action="{{ route('diskon.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label>Pilih Menu</label>
                        <select name="menu_id" class="form-control" required>
                            @foreach($menus as $m)
                                <option value="{{ $m->id }}">{{ $m->nama }} (Rp {{ number_format($m->harga) }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Tipe Diskon</label>
                        <select name="tipe_diskon" id="tipe_diskon" class="form-control" required>
                            <option value="Persen">Persen (%)</option>
                            <option value="Nominal">Nominal (Rp)</option>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div id="input_persen" class="col-md-6 form-group">
                        <label>Diskon Persen (%)</label>
                        <input type="number" name="diskon_persen" class="form-control" min="1" max="100">
                    </div>
                    <div id="input_nominal" class="col-md-6 form-group" style="display:none;">
                        <label>Diskon Nominal (Rp)</label>
                        <input type="number" name="diskon_nominal" class="form-control">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 form-group">
                        <label>Mulai Diskon</label>
                        <input type="datetime-local" name="mulai_diskon" class="form-control" required>
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Akhir Diskon</label>
                        <input type="datetime-local" name="akhir_diskon" class="form-control" required>
                    </div>
                </div>

                <button type="submit" class="btn btn-success">Simpan Diskon</button>
                <a href="{{ route('diskon.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>

<script>
    // Script simpel untuk toggle input persen/nominal
    document.getElementById('tipe_diskon').addEventListener('change', function() {
        if (this.value === 'Persen') {
            document.getElementById('input_persen').style.display = 'block';
            document.getElementById('input_nominal').style.display = 'none';
        } else {
            document.getElementById('input_persen').style.display = 'none';
            document.getElementById('input_nominal').style.display = 'block';
        }
    });
</script>
@endsection
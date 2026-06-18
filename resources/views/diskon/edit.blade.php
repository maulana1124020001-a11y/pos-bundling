@extends('layouts.app')

@section('content')
<div class="container-fluid">

    <!-- Judul -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-edit text-warning"></i>
            Edit Diskon 
        </h1>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">

            <div class="card shadow mb-4 border-left-warning">

                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-warning">
                        Form Edit Diskon
                    </h6>
                </div>

                <div class="card-body">

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('diskon.update', $diskon->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">

                            <!-- Menu -->
                            <div class="col-md-6 form-group">
                                <label class="font-weight-bold">
                                    Pilih Menu
                                </label>

                                <select name="menu_id" class="form-control" required>
                                    @foreach ($menus as $m)
                                        <option value="{{ $m->id }}"
                                            {{ old('menu_id', $diskon->menu_id) == $m->id ? 'selected' : '' }}>

                                            {{ $m->nama }}
                                            (Rp {{ number_format($m->harga,0,',','.') }})

                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Tipe Diskon -->
                            <div class="col-md-6 form-group">
                                <label class="font-weight-bold">
                                    Tipe Diskon
                                </label>

                                <select name="tipe_diskon"
                                    id="tipe_diskon"
                                    class="form-control">

                                    <option value="Persen"
                                        {{ old('tipe_diskon', $diskon->tipe_diskon) == 'Persen' ? 'selected' : '' }}>
                                        Persen (%)
                                    </option>

                                    <option value="Nominal"
                                        {{ old('tipe_diskon', $diskon->tipe_diskon) == 'Nominal' ? 'selected' : '' }}>
                                        Nominal (Rp)
                                    </option>

                                </select>
                            </div>

                        </div>

                        <div class="row">

                            <!-- Persen -->
                            <div class="col-md-6 form-group"
                                id="input_persen"
                                style="{{ old('tipe_diskon', $diskon->tipe_diskon) == 'Persen' ? '' : 'display:none;' }}">

                                <label class="font-weight-bold">
                                    Diskon Persen (%)
                                </label>

                                <input type="number"
                                    id="diskon_persen"
                                    name="diskon_persen"
                                    min="1"
                                    max="100"
                                    class="form-control"
                                    value="{{ old('diskon_persen', $diskon->diskon_persen) }}">
                            </div>


                            <!-- Nominal -->
                            <div class="col-md-6 form-group"
                                id="input_nominal"
                                style="{{ old('tipe_diskon', $diskon->tipe_diskon) == 'Nominal' ? '' : 'display:none;' }}">

                                <label class="font-weight-bold">
                                    Diskon Nominal (Rp)
                                </label>

                                <input type="text"
                                    id="diskon_nominal_tampil"
                                    class="form-control"
                                    maxlength="16"
                                    value="{{ old('diskon_nominal', $diskon->diskon_nominal) }}">

                                <input type="hidden"
                                    id="diskon_nominal"
                                    name="diskon_nominal"
                                    value="{{ old('diskon_nominal', $diskon->diskon_nominal) }}">
                            </div>

                        </div>

                        <div class="row">

                            <div class="col-md-6 form-group">
                                <label class="font-weight-bold">
                                    Mulai Diskon
                                </label>

                                <input type="datetime-local"
                                    name="mulai_diskon"
                                    class="form-control"
                                    value="{{ old('mulai_diskon', date('Y-m-d\TH:i', strtotime($diskon->mulai_diskon))) }}">
                            </div>

                            <div class="col-md-6 form-group">
                                <label class="font-weight-bold">
                                    Akhir Diskon
                                </label>

                                <input type="datetime-local"
                                    name="akhir_diskon"
                                    class="form-control"
                                    value="{{ old('akhir_diskon', date('Y-m-d\TH:i', strtotime($diskon->akhir_diskon))) }}">
                            </div>

                        </div>

                        <hr>

                        <div class="text-right">

                            <a href="{{ route('diskon.index') }}"
                                class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i>
                                Batal
                            </a>

                            <button type="submit"
                                class="btn btn-warning">
                                <i class="fas fa-save"></i>
                                Update Diskon
                            </button>

                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const tipe = document.getElementById('tipe_diskon');
    const persen = document.getElementById('input_persen');
    const nominal = document.getElementById('input_nominal');

    function tampilkanInput() {

        if (tipe.value === 'Persen') {
            persen.style.display = 'block';
            nominal.style.display = 'none';
        } else {
            persen.style.display = 'none';
            nominal.style.display = 'block';
        }

    }

    tampilkanInput();

    tipe.addEventListener('change', tampilkanInput);


    // FORMAT RUPIAH
    const tampil = document.getElementById('diskon_nominal_tampil');
    const asli = document.getElementById('diskon_nominal');

    if (tampil) {

        let angkaAwal = tampil.value.replace(/\D/g,'');

        if (angkaAwal != '') {

            tampil.value = Number(angkaAwal).toLocaleString('id-ID');
            asli.value = angkaAwal;

        }

        tampil.addEventListener('input', function () {

            let angka = this.value.replace(/\D/g,'');

            // maksimal 16 digit
            if (angka.length > 16) {
                angka = angka.substring(0,16);
            }

            asli.value = angka;

            this.value = angka == ''
                ? ''
                : Number(angka).toLocaleString('id-ID');

        });

    }


    // BATASI DISKON PERSEN
    const diskonPersen = document.getElementById('diskon_persen');

    if (diskonPersen) {

        diskonPersen.addEventListener('input', function () {

            let nilai = this.value.replace(/\D/g,'');

            // maksimal 3 digit
            if (nilai.length > 3) {
                nilai = nilai.substring(0,3);
            }

            // maksimal 100
            if (parseInt(nilai) > 100) {
                nilai = '100';
            }

            this.value = nilai;

        });

    }

});
</script>

@endsection


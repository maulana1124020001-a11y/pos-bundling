@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <!-- Judul -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-project-diagram text-primary"></i> Hasil Association Rule
        </h1>
    </div>

    <!-- Notifikasi -->
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Card -->
    <div class="card shadow mb-4">

        <!-- Header -->
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                Daftar Rule & Bundling
            </h6>
        </div>

        <!-- Body -->
        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-bordered table-hover" id="dataTable" width="100%">

                    <thead class="thead-light">
                        <tr>
                            <th width="50">No</th>
                            <th>Rule</th>
                            <th width="120">Support</th>
                            <th width="120">Confidence</th>
                            <th width="100">Lift</th>
                            <th width="300">Buat Bundling</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($associationRules as $index => $rule)

                        <tr>
                            <td class="text-center">
                                {{ $index + 1 }}
                            </td>

                            <td>
                                {{ $rule['rule'] }}
                            </td>

                            <td class="text-center">
                                {{ $rule['support'] }}
                            </td>

                            <td class="text-center">
                                {{ $rule['confidence'] }}%
                            </td>

                            <td class="text-center">
                                {{ $rule['lift'] }}
                            </td>

                            <td>

                                <form action="{{ route('rekomendasi.simpan-bundling') }}" method="POST">
                                    @csrf

                                    <!-- hidden id -->
                                    <input type="hidden" name="menu_a_id" value="{{ $rule['item_a_id'] }}">
                                    <input type="hidden" name="menu_b_id" value="{{ $rule['item_b_id'] }}">

                                    <div class="input-group">

                                        <input 
                                            type="text" 
                                            name="nama_bundling" 
                                            class="form-control form-control-sm"
                                            placeholder="Masukkan nama paket..."
                                            required
                                        >

                                        <div class="input-group-append">
                                            <button type="submit" class="btn btn-success btn-sm">
                                                <i class="fas fa-save"></i> Simpan
                                            </button>
                                        </div>

                                    </div>

                                </form>

                            </td>
                        </tr>

                        @empty

                        <tr>
                            <td colspan="6" class="text-center">
                                Data association rule belum tersedia
                            </td>
                        </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>
    </div>

</div>

@endsection
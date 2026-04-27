@extends('layouts.app')

@section('content')
<<<<<<< HEAD

<div class="container-fluid">

    <!-- Judul -->
    <h1 class="h3 mb-3 text-gray-800">Data Diskon</h1>

    <!-- Card -->
    <div class="card shadow mb-4">

        <!-- Header -->
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Tabel Diskon</h6>

            <a href="{{ route('diskon.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Tambah
            </a>
        </div>

        <!-- Body -->
        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-bordered table-hover" id="dataTable" width="100%">
                    
                    <thead class="thead-light">
                        <tr>
                            <th width="50">No</th>
                            <th>Menu</th>
                            <th>Tipe</th>
                            <th>Nilai Diskon</th>
                            <th>Periode</th>
                            <th width="150">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($diskons as $d)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>

                            <td>{{ $d->menu->nama ?? '-' }}</td>

                            <td>{{ $d->tipe_diskon }}</td>

                            <td>
                                @if($d->tipe_diskon == 'Persen')
                                    {{ $d->diskon_persen }}%
                                @else
                                    Rp {{ number_format($d->diskon_nominal, 0, ',', '.') }}
                                @endif
                            </td>

                            <td>
                                {{ $d->mulai_diskon }} <br>
                                s/d <br>
                                {{ $d->akhir_diskon }}
                            </td>

                            <td class="text-center">
                                <a href="{{ route('diskon.edit', $d->id) }}" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>


                                <form action="{{ route('diskon.destroy', $d->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>

                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">
                                Data diskon belum tersedia
                            </td>
                        </tr>
                        @endforelse
                    </tbody>

                </table>

            </div>
        </div>
=======
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>Daftar Diskon Menu</h4>
        <a href="{{ route('diskon.create') }}" class="btn btn-primary">Tambah Diskon</a>
>>>>>>> 39627ed945561892d020686296fa88ddad0e273d
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-body">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Menu</th>
                        <th>Tipe</th>
                        <th>Potongan</th>
                        <th>Periode</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($diskons as $d)
                    <tr>
                        <td>{{ $d->menu->nama }}</td>
                        <td><span class="badge badge-info">{{ $d->tipe_diskon }}</span></td>
                        <td>
                            {{ $d->tipe_diskon == 'Persen' ? $d->diskon_persen . '%' : 'Rp ' . number_format($d->diskon_nominal) }}
                        </td>
                        <td>
                            <small>
                                {{ date('d M Y', strtotime($d->mulai_diskon)) }} s/d 
                                {{ date('d M Y', strtotime($d->akhir_diskon)) }}
                            </small>
                        </td>
                        <td>
                            @if(now()->between($d->mulai_diskon, $d->akhir_diskon))
                                <span class="text-success font-weight-bold">Aktif</span>
                            @elseif(now()->lt($d->mulai_diskon))
                                <span class="text-warning">Mendatang</span>
                            @else
                                <span class="text-danger">Berakhir</span>
                            @endif
                        </td>
                        <td>
                            <form action="{{ route('diskon.destroy', $d->id) }}" method="POST" onsubmit="return confirm('Hapus diskon ini?')">
                                <a href="{{ route('diskon.edit', $d->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
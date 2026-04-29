@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>Daftar Diskon Menu</h4>
        <a href="{{ route('diskon.create') }}" class="btn btn-primary">Tambah Diskon</a>
    </div>

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
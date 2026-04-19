@extends('layouts.app')

@section('content')

<h3>Data Menu</h3>

<a href="{{ route('menu.create') }}" class="btn btn-primary mb-3">
    Tambah Menu
</a>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>No</th>
            <th>Kategori</th>
            <th>Nama</th>
            <th>Harga</th>
            <th>Gambar</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
    </thead>

    <tbody>
        @foreach($menus as $m)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $m->kategori->nama_kategori }}</td>
            <td>{{ $m->nama }}</td>
            <td>Rp {{ number_format($m->harga) }}</td>

            <td>
                @if($m->gambar)
                    <img src="{{ asset('images/'.$m->gambar) }}" width="70">
                @else
                    -
                @endif
            </td>

            <td>{{ $m->status }}</td>

            <td>
                <a href="{{ route('menu.show', $m->id) }}" class="btn btn-info btn-sm">Detail</a>

                <a href="{{ route('menu.edit', $m->id) }}" class="btn btn-warning btn-sm">Edit</a>

                <form action="{{ route('menu.destroy', $m->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger btn-sm">Hapus</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>

</table>

@endsection
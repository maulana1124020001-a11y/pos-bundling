@extends('layouts.app')

@section('content')

<h1>Data Bundling</h1>

<a href="{{ route('bundling.create') }}" class="btn btn-primary mb-3">Tambah Bundling</a>

@if(session('success'))
    <p>{{ session('success') }}</p>
@endif

<table class="table table-bordered">
    <tr>
        <th>ID</th>
        <th>Menu Bundling</th>
        <th>Menu Item</th>
        <th>Harga</th>
        <th>Aksi</th>
    </tr>

    @foreach($bundlings as $b)
    <tr>
        <td>{{ $b->id }}</td>
        <td>{{ $b->menu->nama }}</td>
        <td>{{ $b->menuNonBundling->nama }}</td>
        <td>{{ $b->harga }}</td>
        <td>
            <a href="{{ route('bundling.show', $b->id) }}" class="btn btn-info btn-sm">Detail</a>

            <a href="{{ route('bundling.edit', $b->id) }}" class="btn btn-warning btn-sm">Edit</a>

            <form action="{{ route('bundling.destroy', $b->id) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger btn-sm">Hapus</button>
            </form>
        </td>
    </tr>
    @endforeach
</table>
@endsection
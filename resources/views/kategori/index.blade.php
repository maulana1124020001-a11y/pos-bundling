@extends('layouts.app')

@section('content')

<h3>Data Kategori</h3>

<a href="{{ route('kategori.create') }}" class="btn btn-primary mb-3">
    Tambah Kategori
</a>

@if(session('success'))
    <p>{{ session('success') }}</p>
@endif

<table class="table table-bordered">
    <tr>
        <th>No</th>
        <th>Nama Kategori</th>
        <th>Aksi</th>
    </tr>

                    <tbody>
                        @foreach($kategoris as $k)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>{{ $k->nama_kategori }}</td>
                            <td class="text-center">

                                <a href="{{ route('kategori.edit', $k->id) }}" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <form action="{{ route('kategori.destroy', $k->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>

                            </td>
                        </tr>
                        @endforeach
                    </tbody>

                </table>

            </div>
        </div>
    </div>

</div>

@endsection
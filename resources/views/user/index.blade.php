@extends('layouts.app')

@section('content')

<h3>Data User</h3>

<a href="{{ route('user.create') }}" class="btn btn-primary mb-3">
    Tambah User
</a>

<table class="table table-bordered">
<tr>
    <th>No</th>
    <th>Nama</th>
    <th>Email</th>
    <th>Role</th>
    <th>Aksi</th>
</tr>

@foreach($users as $u)
<tr>
    <td>{{ $loop->iteration }}</td>
    <td>{{ $u->nama }}</td>
    <td>{{ $u->email }}</td>
    <td>{{ $u->role->nama_role }}</td>
    <td>
        
        <a href="{{ route('kategori.edit', $k->id) }}" class="btn btn-warning btn-sm">
            <i class="fas fa-edit"></i>
        </a>

        <form action="{{ route('user.destroy',$u->id) }}" method="POST" style="display:inline;">
            @csrf
            @method('DELETE')
            <button class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus?')">
                <i class="fas fa-trash"></i>
            </button>
        </form>
    </td>
</tr>
@endforeach

</table>

@endsection
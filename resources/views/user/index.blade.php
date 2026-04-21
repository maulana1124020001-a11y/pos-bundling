@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <!-- Judul -->
    <h1 class="h3 mb-3 text-gray-800">Data User</h1>

    <!-- Card -->
    <div class="card shadow mb-4">

        <!-- Header -->
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Tabel User</h6>

            <a href="{{ route('user.create') }}" class="btn btn-primary btn-sm">
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
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th width="150">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($users as $u)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>

                            <td>{{ $u->nama }}</td>

                            <td>{{ $u->email }}</td>

                            <td>
                                <span">
                                    {{ $u->role->nama_role ?? '-' }}
                                </span>
                            </td>

                            <td class="text-center">

                                <a href="{{ route('user.edit', $u->id) }}" 
                                   class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <form action="{{ route('user.destroy',$u->id) }}" 
                                      method="POST" 
                                      class="d-inline">
                                    @csrf
                                    @method('DELETE')

                                    <button class="btn btn-danger btn-sm" 
                                        onclick="return confirm('Yakin hapus user ini?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>

                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center">
                                Data user belum tersedia
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
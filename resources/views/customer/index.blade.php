@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <!-- Judul -->
    <h1 class="h3 mb-3 text-gray-800">Data Customer</h1>

    <!-- Card -->
    <div class="card shadow mb-4">

        <!-- Header -->
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Tabel Customer</h6>

            <a href="{{ route('customer.create') }}" class="btn btn-primary btn-sm">
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
                            <th>No HP</th>
                            <th width="150">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($customers as $c)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>{{ $c->nama }}</td>
                            <td>{{ $c->no_hp }}</td>
                            <td class="text-center">

                                <a href="{{ route('customer.edit', $c->id) }}" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <form action="{{ route('customer.destroy', $c->id) }}" method="POST" class="d-inline">
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
                            <td colspan="5" class="text-center">
                                Data customer belum tersedia
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
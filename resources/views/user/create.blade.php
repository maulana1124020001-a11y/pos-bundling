@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <!-- Judul -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-plus-circle text-primary"></i> Tambah User
        </h1>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-6">

            <!-- Card -->
            <div class="card shadow mb-4 border-left-primary">

                <!-- Header -->
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        Form Tambah User
                    </h6>
                </div>

                <!-- Body -->
                <div class="card-body">

                    <form action="{{ route('user.store') }}" method="POST">
                        @csrf

                        <div class="form-group">
                            <label class="font-weight-bold">Role</label>
                            <select name="role_id" class="form-control" required>
                                @foreach($roles as $r)
                                    <option value="{{ $r->id }}">{{ $r->nama_role }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="font-weight-bold">Nama</label>
                            <input type="text" name="nama" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label class="font-weight-bold">Email</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label class="font-weight-bold">Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>

                        <hr>

                        <!-- Tombol -->
                        <div class="text-right">
                            <a href="{{ route('user.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Batal
                            </a>

                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Simpan
                            </button>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>

</div>

@endsection
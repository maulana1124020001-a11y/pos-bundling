@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <!-- Judul -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-edit text-warning"></i> Edit User
        </h1>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-6">

            <!-- Card -->
            <div class="card shadow mb-4 border-left-warning">

                <!-- Header -->
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-warning">
                        Form Edit User
                    </h6>
                </div>

                <!-- Body -->
                <div class="card-body">

                    {{-- ERROR --}}
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('user.update', $user->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        {{-- ROLE --}}
                        <div class="form-group">
                            <label class="font-weight-bold">Role</label>
                            <select name="role_id" class="form-control" required>
                                @foreach($roles as $r)
                                    <option value="{{ $r->id }}" {{ $user->role_id == $r->id ? 'selected' : '' }}>
                                        {{ $r->nama_role }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- NAMA --}}
                        <div class="form-group">
                            <label class="font-weight-bold">Nama</label>
                            <input type="text" name="nama" 
                                   value="{{ old('nama', $user->nama) }}"
                                   class="form-control" required>
                        </div>

                        {{-- EMAIL --}}
                        <div class="form-group">
                            <label class="font-weight-bold">Email</label>
                            <input type="email" name="email" 
                                   value="{{ old('email', $user->email) }}"
                                   class="form-control" required>
                        </div>

                        {{-- PASSWORD --}}
                        <div class="form-group">
                            <label class="font-weight-bold">Password</label>
                            <input type="password" name="password" class="form-control">
                            <small class="text-muted">
                                Kosongkan jika tidak ingin mengubah password
                            </small>
                        </div>

                        <hr>

                        <!-- Tombol -->
                        <div class="text-right">
                            <a href="{{ route('user.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Batal
                            </a>

                            <button type="submit" class="btn btn-warning">
                                <i class="fas fa-save"></i> Update
                            </button>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>

</div>

@endsection
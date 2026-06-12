@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-edit text-warning"></i> Edit User
        </h1>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-6">

            <div class="card shadow mb-4 border-left-warning">

                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-warning">
                        Form Edit User
                    </h6>
                </div>

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
                            
                            {{-- Jika User ID 1, select option di-disable agar rolenya tidak bisa diubah --}}
                            <select name="role_id" class="form-control" required {{ $user->id == 1 ? 'disabled' : '' }}>
                                @foreach($roles as $r)
                                    @php
                                        // Cek apakah ada inputan lama dari session error, kalau tidak ada pakai data asli dari database
                                        $selectedRole = old('role_id', $user->role_id);
                                    @endphp
                                    <option value="{{ $r->id }}" {{ $selectedRole == $r->id ? 'selected' : '' }}>
                                        {{ $r->nama_role }}
                                    </option>
                                @endforeach
                            </select>

                            @if($user->id == 1)
                                {{-- Pasang input hidden khusus ID 1 agar value role_id tetap terkirim saat disubmit --}}
                                <input type="hidden" name="role_id" value="{{ $user->role_id }}">
                                <small class="text-danger font-italic">
                                    * Role untuk User Master (ID 1) dikunci oleh sistem.
                                </small>
                            @endif
                        </div>

                        {{-- NAMA --}}
                        <div class="form-group">
                            <label class="font-weight-bold">Nama</label>
                            <input type="text" name="nama" 
                                   value="{{ old('nama', $user->nama) }}"
                                   class="form-control @error('nama') is-invalid @enderror" required>
                        </div>

                        {{-- EMAIL --}}
                        <div class="form-group">
                            <label class="font-weight-bold">Email</label>
                            <input type="email" name="email" 
                                   value="{{ old('email', $user->email) }}"
                                   class="form-control @error('email') is-invalid @enderror" required>
                        </div>

                        {{-- PASSWORD --}}
                        <div class="form-group">
                            <label class="font-weight-bold">Password</label>
                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror">
                            <small class="text-muted d-block mt-1">
                                Kosongkan jika tidak ingin mengubah password
                            </small>
                        </div>

                        <hr>

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
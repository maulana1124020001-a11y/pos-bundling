@extends('layouts.app')

@section('content')

<h3>Tambah User</h3>

<form action="{{ route('user.store') }}" method="POST">
@csrf

<div class="mb-3">
    <label>Role</label>
    <select name="role_id" class="form-control">
        @foreach($roles as $r)
            <option value="{{ $r->id }}">{{ $r->nama_role }}</option>
        @endforeach
    </select>
</div>

<div class="mb-3">
    <label>Nama</label>
    <input type="text" name="nama" class="form-control">
</div>

<div class="mb-3">
    <label>Email</label>
    <input type="email" name="email" class="form-control">
</div>

<div class="mb-3">
    <label>Password</label>
    <input type="password" name="password" class="form-control">
</div>

<button class="btn btn-success">Simpan</button>

</form>

@endsection
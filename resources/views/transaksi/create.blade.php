@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <h1 class="h3 mb-3 text-gray-800">Transaksi Baru</h1>

    <div class="card shadow">
        <div class="card-body">

            <form action="{{ route('transaksi.store') }}" method="POST">
                @csrf

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Menu</th>
                            <th>Harga</th>
                            <th>Jumlah</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($menus as $m)
                        <tr>
                            <td>
                                {{ $m->nama }}
                                <input type="hidden" name="menu_id[]" value="{{ $m->id }}">
                            </td>
                            <td>Rp {{ number_format($m->harga) }}</td>
                            <td>
                                <input type="number" name="jumlah[]" class="form-control" value="0">
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="mb-3">
                    <label>Metode Pembayaran</label>
                    <select name="metode_pembayaran" class="form-control">
                        <option value="cash">Cash</option>
                        <option value="qris">QRIS</option>
                        <option value="transfer">Transfer</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label>Uang Bayar</label>
                    <input type="number" name="uang_bayar" class="form-control">
                </div>

                <button class="btn btn-success">Simpan Transaksi</button>

            </form>

        </div>
    </div>

</div>

@endsection
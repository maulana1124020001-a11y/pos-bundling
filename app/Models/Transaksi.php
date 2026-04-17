<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $fillable = [
        'user_id',
        'total_harga',
        'uang_bayar',
        'kembalian',
        'status',
        'metode_pembayaran',
        'waktu'
    ];

    protected $dates = ['waktu'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function details()
    {
        return $this->hasMany(TransaksiDetail::class);
    }

    public function customer()
    {
        return $this->hasOne(Customer::class);
    }
}

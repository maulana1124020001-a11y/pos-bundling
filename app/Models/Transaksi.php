<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use \App\Models\TransaksiDetail;

class Transaksi extends Model
{
    protected $fillable = [
        'user_id',
        'customer_id',
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

    public function detail()
    {
        return $this->hasMany(TransaksiDetail::class, 'transaksi_id');
    }
    public function customer()
    {
        return $this->belongsto(Customer::class);
    }
}

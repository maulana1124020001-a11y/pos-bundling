<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use \App\Models\Transaksi;

class TransaksiDetail extends Model
{
    protected $table = 'transaksi_details';

    protected $fillable = [
        'transaksi_id',
        'menu_id',
        'jumlah',
        'harga',
        'subtotal'
    ];

    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class, 'transaksi_id');
    }

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }
}
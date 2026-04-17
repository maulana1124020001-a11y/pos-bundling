<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
        'transaksi_id',
        'nama',
        'no_hp'
    ];

    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class);
    }
}

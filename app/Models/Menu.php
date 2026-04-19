<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $fillable = [
        'kategori_id',
        'nama',
        'modal',
        'harga',
        'status',
        'gambar'

    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    public function diskon()
    {
        return $this->hasOne(Diskon::class);
    }

    public function bundlings()
    {
        return $this->hasMany(Bundling::class);
    }

    public function transaksiDetails()
    {
        return $this->hasMany(TransaksiDetail::class);
    }
}

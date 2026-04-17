<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Diskon extends Model
{
    protected $fillable = [
        'menu_id',
        'diskon_persen',
        'diskon_nominal',
        'tipe_diskon',
        'mulai_diskon',
        'akhir_diskon'
    ];

    protected $dates = ['mulai_diskon', 'akhir_diskon'];

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Diskon extends Model
{
    use SoftDeletes;
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

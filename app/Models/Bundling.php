<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class Bundling extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'nama_bundling',
        'menu_a_id',
        'menu_b_id',
        'harga_bundling'
    ];

    public function menu()
    {
        return $this->belongsTo(Menu::class, 'menu_id');
    }

    public function menuNonBundling()
    {
        return $this->belongsTo(Menu::class, 'menu_non_bundling_id');
    }

}
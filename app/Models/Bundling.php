<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bundling extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'menu_id',
        'menu_non_bundling_id',
        'harga'
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
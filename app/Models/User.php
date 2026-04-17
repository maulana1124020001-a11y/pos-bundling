<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Authenticatable
{
    protected $fillable = [
        'role_id',
        'nama',
        'email',
        'password'
    ];

    protected $hidden = [
        'password'
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function transaksis()
    {
        return $this->hasMany(Transaksi::class);
    }
}
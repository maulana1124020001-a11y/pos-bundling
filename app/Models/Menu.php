<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Menu extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'kategori_id',
        'nama',
        'gambar',
        'modal',
        'harga',
        'status'
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIP
    |--------------------------------------------------------------------------
    */

    // Relasi ke kategori
    public function kategori()
    {
        return $this->belongsTo(Kategori::class)->withTrashed();
    }

    // Semua diskon (history)
    public function diskons()
    {
        return $this->hasMany(Diskon::class, 'menu_id');
    }

    // Ambil 1 diskon yang sedang aktif
    public function diskon()
    {
        return $this->hasOne(Diskon::class, 'menu_id')
            ->where('mulai_diskon', '<=', now())
            ->where('akhir_diskon', '>=', now());
    }


    /*
    |--------------------------------------------------------------------------
    | ACCESSOR (LOGIKA HARGA)
    |--------------------------------------------------------------------------
    */

    // Harga setelah diskon
    // di blade tinggal panggil $menu->harga_diskon karena ini accessor 
    
    public function getHargaDiskonAttribute()
    {
        
        $diskon = $this->diskon;

        if ($diskon) {
            if ($diskon->tipe_diskon === 'Persen') {
                return $this->harga - ($this->harga * $diskon->diskon_persen / 100);
            } else {
                return $this->harga - $diskon->diskon_nominal;
            }
        }
    

        return $this->harga;
    }

    // Nominal diskon (biar gampang dipakai di struk)
    public function getNominalDiskonAttribute()
    {
        $diskon = $this->diskon;

        if ($diskon) {
            if ($diskon->tipe_diskon === 'Persen') {
                //
                return ($this->harga * $diskon->diskon_persen) / 100;
            } else {
                // 
                return $diskon->diskon_nominal;
            }
        }

        return 0;
    }

    // Cek apakah punya diskon
    public function getAdaDiskonAttribute()
    {
        return $this->diskon ? true : false;
    }
}
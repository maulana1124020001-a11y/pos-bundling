<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $fillable = ['kategori_id', 'nama', 'gambar', 'modal', 'harga', 'status'];

    // INI YANG HILANG: Definisi relasi ke tabel diskons
    public function diskons()
    {
        return $this->hasMany(Diskon::class);
    }

    // Relasi ke kategori (tambahan agar aman)
    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    // Logika harga diskon yang tadi kita buat
    public function getHargaDiskonAttribute()
    {
        // Sekarang $this->diskons() sudah bisa dipanggil karena sudah ada di atas
        $diskon = $this->diskons()
            ->where('mulai_diskon', '<=', now())
            ->where('akhir_diskon', '>=', now())
            ->first();

        if ($diskon) {
            if ($diskon->tipe_diskon === 'Persen') {
                return $this->harga - ($this->harga * $diskon->diskon_persen / 100);
            } else {
                return $this->harga - $diskon->diskon_nominal;
            }
        }
        
        return $this->harga;
    }
}


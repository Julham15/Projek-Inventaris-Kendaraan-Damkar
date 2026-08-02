<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class JenisMobil extends Model
{
      use HasFactory;

    protected $fillable = [
        'posko_id',
        'nama_jenis',
        'jumlah_mobil',
        'gambar',
    ];
    public function kendaraans()
    {
        return $this->hasMany(Kendaraan::class);
    }
    public function posko()
    {
        return $this->belongsTo(Posko::class);
    }
}

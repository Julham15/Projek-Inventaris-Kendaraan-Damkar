<?php

namespace App\Models;
use App\Models\Peralatan;
use App\Models\Kondisi;
use App\Models\Laporan;
use Illuminate\Database\Eloquent\Model;

class Kendaraan extends Model
{
    protected $fillable = [
    
    'jenis_mobil_id',
    'gambar',
    'nomor_polisi',
    'deskripsi',
   
];
 public function posko()
    {
        return $this->belongsTo(Posko::class);
    }

public function jenisMobil()
{   
    return $this->belongsTo(JenisMobil::class);
}

public function peralatans()
{
    return $this->hasMany(Peralatan::class);
}
public function kondisis()
{
    return $this->hasMany(Kondisi::class);
}
public function laporans()
{
    return $this->hasMany(Laporan::class);
}
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Peralatan extends Model
{
     protected $fillable = [
        'kendaraan_id',
        'nama_alat',
        
        'jumlah',
        'kondisi',
        'tanggal_pengadaan',
       
    ];
   
    public function kendaraan()
    {
      return $this->belongsTo(Kendaraan::class);
    }
}

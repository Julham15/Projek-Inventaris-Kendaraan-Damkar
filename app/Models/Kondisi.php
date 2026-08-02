<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kondisi extends Model
{
    protected $fillable = [
        'kendaraan_id',
        'nama_kondisi',
        'status',
        // 'keterangan'
    ];

    public function kendaraan()
    {
        return $this->belongsTo(Kendaraan::class);
    }
    
}

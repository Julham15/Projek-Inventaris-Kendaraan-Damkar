<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StatusKondisi extends Model
{
    //
    protected $fillable = [
    'kendaraan_id',
    'kondisi_id',
    'status',
];
   public function kendaraan()
    {
        return $this->belongsTo(Kendaraan::class);
    }

    public function kondisi()
    {
        return $this->belongsTo(Kondisi::class);
    }
}



<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StatusPeralatan extends Model
{
    protected $fillable = [
    'kendaraan_id',
    'peralatan_id',
    'status',
];
  public function kendaraan()
    {
        return $this->belongsTo(Kendaraan::class);
    }

    public function peralatan()
    {
        return $this->belongsTo(Peralatan::class);
    }
}

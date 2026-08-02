<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Posko extends Model
{
      protected $fillable = [
        'nama_posko',
        'alamat',
    ];

    public function jenisMobils()
    {
        return $this->hasMany(JenisMobil::class);
    }
}

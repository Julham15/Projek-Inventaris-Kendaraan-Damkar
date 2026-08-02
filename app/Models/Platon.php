<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Platon extends Model
{
      protected $fillable = ['nama'];

    public function regus()
    {
        return $this->hasMany(Regu::class);
    }

    // public function laporans()
    // {
    //     return $this->hasMany(Laporan::class);
    // }
    public function users()
{
    return $this->hasMany(User::class);
}
public function laporans()
{
    return $this->hasMany(Laporan::class);
}

}

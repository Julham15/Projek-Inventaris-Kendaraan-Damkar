<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Regu extends Model
{
     protected $fillable = ['platon_id', 'nama'];

    protected $casts = [
        'nama' => 'integer',
    ];
    public function platon()
    {
        return $this->belongsTo(Platon::class);
    }

    public function laporans()
    {
        return $this->hasMany(Laporan::class);
    }
    public function users()
{
    return $this->hasMany(User::class);
}
}

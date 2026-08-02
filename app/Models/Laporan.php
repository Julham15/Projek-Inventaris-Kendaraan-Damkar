<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Laporan extends Model
{
     use SoftDeletes;

    protected $fillable = [
        'user_id',
        'platon_id',
        'regu_id',
        'kendaraan_id',
        'kondisi_kendaraan',
        'kondisi_peralatan',
        'nama_posko',
        
        'deskripsi',
        'keterangan',
        'foto',
        'foto_kondisi',
        'tanggal_kejadian',
        'status',
        'selesai_at',
    ];
 protected $casts = [
        'tanggal_kejadian' => 'date',
        'selesai_at' => 'datetime',
    ];
   
    /*
    |--------------------------------------------------------------------------
    | RELASI USER
    |--------------------------------------------------------------------------
    */

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /*
    |--------------------------------------------------------------------------
    | RELASI KENDARAAN
    |--------------------------------------------------------------------------
    */

    public function kendaraan()
    {
        return $this->belongsTo(Kendaraan::class);
    }
    public function laporanPeralatans()
    {
    return $this->hasMany(LaporanPeralatan::class);
    }

    public function laporanKondisis()
    {
    return $this->hasMany(LaporanKondisi::class);
    }
      public function platon()
    {
        return $this->belongsTo(Platon::class);
    }

    public function regu()
    {
        return $this->belongsTo(Regu::class);
    }

    
}

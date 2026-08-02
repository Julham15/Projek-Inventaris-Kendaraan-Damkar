<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LaporanPeralatan extends Model
{
    protected $fillable = [
    'laporan_id',
    'peralatan_id',
    'nama_peralatan',
    'jumlah',
    'jumlah_awal',
    'kondisi',
    'foto',
    'foto_dihapus_admin',
    'deskripsi'
    
    ];
    public function peralatan()
{
    return $this->belongsTo(Peralatan::class);
}
public function laporan()
{
    return $this->belongsTo(Laporan::class);
}
}

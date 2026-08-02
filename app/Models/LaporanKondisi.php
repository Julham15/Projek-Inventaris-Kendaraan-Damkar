<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LaporanKondisi extends Model
{
    protected $fillable = [
    'laporan_id',
    'kondisi_id',
     'nama_kondisi',
    'status',
    'foto',
    'foto_dihapus_admin',
    'deskripsi'
];
public function kondisi()
{
    return $this->belongsTo(Kondisi::class);
}
public function laporan()
{
    return $this->belongsTo(Laporan::class);
}
}

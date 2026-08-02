<?php

namespace App\Http\Controllers;


use App\Models\LaporanPeralatan;
use App\Models\LaporanKondisi;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class PeralatanKondisiController extends Controller
{
    public function peralatanDownload(LaporanPeralatan $laporanPeralatan)
{
    if (!$laporanPeralatan->foto) {
        return back()->with('error', 'Foto sudah tidak tersedia.');
    }

    if (!Storage::disk('public')->exists($laporanPeralatan->foto)) {
        return back()->with('error', 'File foto tidak ditemukan.');
    }

    return Storage::disk('public')->download(
        $laporanPeralatan->foto,
        basename($laporanPeralatan->foto)
    );
}

    public function peralatanDestroy(LaporanPeralatan $laporanPeralatan)
{
    if (!$laporanPeralatan->foto) {
        return back()->with('error', 'Foto sudah dihapus sebelumnya.');
    }

    if (Storage::disk('public')->exists($laporanPeralatan->foto)) {
        Storage::disk('public')->delete($laporanPeralatan->foto);
    }

    $laporanPeralatan->update([
        'foto' => null,
        'foto_dihapus_admin' => true,
    ]);

    return back()->with('success', 'Foto peralatan berhasil dihapus.');
}

    public function kondisiDownload(LaporanKondisi $laporanKondisi)
{
    if (!$laporanKondisi->foto) {
        return back()->with('error', 'Foto sudah tidak tersedia.');
    }

    if (!Storage::disk('public')->exists($laporanKondisi->foto)) {
        return back()->with('error', 'File foto tidak ditemukan.');
    }

    return Storage::disk('public')->download(
        $laporanKondisi->foto,
        basename($laporanKondisi->foto)
    );
}

public function kondisiDestroy(LaporanKondisi $laporanKondisi)
{
    if (!$laporanKondisi->foto) {
        return back()->with('error', 'Foto sudah dihapus sebelumnya.');
    }

    if (Storage::disk('public')->exists($laporanKondisi->foto)) {
        Storage::disk('public')->delete($laporanKondisi->foto);
    }

    $laporanKondisi->update([
        'foto' => null,
         'foto_dihapus_admin' => true,
    ]);

    return back()->with('success', 'Foto kondisi berhasil dihapus.');
}
}

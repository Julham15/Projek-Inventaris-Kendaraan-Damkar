<?php

namespace App\Console\Commands;

use App\Models\Laporan;
use Illuminate\Support\Facades\Storage;
use Illuminate\Console\Command;

class KelolaLaporanOtomatis extends Command
{
    protected $signature = 'app:kelola-laporan-otomatis';

    protected $description = 'Mengarsipkan laporan Selesai (3 bulan) dan menghapus permanen (6 bulan sejak Selesai)';

    public function handle()
    {
        // =========================
        // 1. Selesai -> Diarsipkan (3 bulan sejak selesai_at)
        // =========================
        $totalArsip = Laporan::where('status', 'Selesai')
            ->whereNotNull('selesai_at')
            ->where('selesai_at', '<=', now()->subMonths(3))
            ->update(['status' => 'Diarsipkan']);

            // ->where('selesai_at', '<=', now()->subSeconds(30))

        // =========================
        // 2. Diarsipkan -> Soft Delete (6 bulan sejak selesai_at)
        // =========================
        $totalSoftDelete = Laporan::where('status', 'Diarsipkan')
            ->whereNotNull('selesai_at')
            ->where('selesai_at', '<=', now()->subMonths(60))
            ->delete(); // soft delete (isi kolom deleted_at)

        // =========================
        // 3. Hapus permanen semua yang sudah soft-deleted
        //    (termasuk yang baru saja di-soft-delete di atas)
        // =========================
        $laporans = Laporan::onlyTrashed()->get();
        $totalPermanen = 0;

        foreach ($laporans as $laporan) {
             // Hapus foto peralatan
        // =========================
        foreach ($laporan->laporanPeralatans as $peralatan) {
            if ($peralatan->foto && Storage::disk('public')->exists($peralatan->foto)) {
                Storage::disk('public')->delete($peralatan->foto);
            }
        }

        // =========================
        // Hapus foto kondisi
        // =========================
        foreach ($laporan->laporanKondisis as $kondisi) {
            if ($kondisi->foto && Storage::disk('public')->exists($kondisi->foto)) {
                Storage::disk('public')->delete($kondisi->foto);
            }
        }

     
            $laporan->forceDelete();
            $totalPermanen++;
        }

        $this->info("Diarsipkan: {$totalArsip} | Soft-deleted: {$totalSoftDelete} | Dihapus permanen: {$totalPermanen}");
    }
}
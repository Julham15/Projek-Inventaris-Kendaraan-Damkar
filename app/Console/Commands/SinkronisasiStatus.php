<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SinkronisasiStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
   protected $signature = 'status:sinkronisasi';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sinkronisasi status terkini dari laporan lama';

    /**
     * Execute the console command.
     */
   public function handle()
{
    // Sinkronisasi Status Peralatan
    $laporanPeralatan = \App\Models\LaporanPeralatan::with('laporan')
        ->orderBy('id')
        ->get();

    foreach ($laporanPeralatan as $item) {

        \App\Models\StatusPeralatan::updateOrCreate(
            [
                'kendaraan_id' => $item->laporan->kendaraan_id,
                'peralatan_id' => $item->peralatan_id,
            ],
            [
                'status' => $item->kondisi,
            ]
        );
    }

    $this->info('Status peralatan berhasil disinkronisasi.');



    // Sinkronisasi Status Kondisi
    $laporanKondisi = \App\Models\LaporanKondisi::with('laporan')
        ->orderBy('id')
        ->get();

    foreach ($laporanKondisi as $item) {

        \App\Models\StatusKondisi::updateOrCreate(
            [
                'kendaraan_id' => $item->laporan->kendaraan_id,
                'kondisi_id' => $item->kondisi_id,
            ],
            [
                'status' => $item->status,
            ]
        );
    }

    $this->info('Status kondisi berhasil disinkronisasi.');

    return Command::SUCCESS;
}
}

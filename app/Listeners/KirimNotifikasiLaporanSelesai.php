<?php

namespace App\Listeners;

use App\Events\LaporanSelesai;
use App\Notifications\LaporanSelesaiNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class KirimNotifikasiLaporanSelesai
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(LaporanSelesai $event): void
    {
        $laporan = $event->laporan;

        $laporan->user->notify(
            new LaporanSelesaiNotification($laporan)
        );
    }

    public function via($notifiable)
    {
        return ['database'];
    }
}

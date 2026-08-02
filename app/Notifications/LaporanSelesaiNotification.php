<?php

namespace App\Notifications;

use App\Models\Laporan;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class LaporanSelesaiNotification extends Notification
{
    use Queueable;

    protected $laporan;

    public function __construct(Laporan $laporan)
    {
        $this->laporan = $laporan;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable): array
    {
        return [
            'laporan_id' => $this->laporan->id,
            'judul' => 'Laporan Disetujui',
            'pesan' => 'Laporan anda pada kendaraan '
                        .$this->laporan->kendaraan->nomor_polisi.
                        ' telah disetujui oleh Admin.',
            'status' => $this->laporan->status,
            'icon' => 'task_alt',
        ];
    }
}
<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class PeralatanRusakNotification extends Notification
{
    use Queueable;

    public $laporan;
    public $peralatanRusak;

    public function __construct($laporan, $peralatanRusak)
    {
        $this->laporan = $laporan;
        $this->peralatanRusak = $peralatanRusak;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [

            'judul' => 'Peralatan Rusak',

            'pesan' =>
                'Mobil ' .
                $this->laporan->kendaraan->nomor_polisi .
                ' memiliki peralatan bermasalah: ' .
                implode(', ', $this->peralatanRusak),

            'laporan_id' => $this->laporan->id
        ];
    }
}
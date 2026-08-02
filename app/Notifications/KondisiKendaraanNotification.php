<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class KondisiKendaraanNotification extends Notification
{
    use Queueable;

    public $laporan;
    public $kondisiBermasalah;

    public function __construct($laporan, $kondisiBermasalah)
    {
        $this->laporan = $laporan;
        $this->kondisiBermasalah = $kondisiBermasalah;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [

            'judul' => 'Kondisi Bermasalah',

            'pesan' =>
                'Mobil ' .
                $this->laporan->kendaraan->nomor_polisi .
                ' memiliki kondisi yang perlu diperhatikan: ' .
                implode(', ', $this->kondisiBermasalah),
                'laporan_id' => $this->laporan->id
        ];
    }
}
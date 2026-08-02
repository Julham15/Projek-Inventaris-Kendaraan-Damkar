<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class LaporanBaruNotification extends Notification
{
    use Queueable;

    public $laporan;

    public function __construct($laporan)
    {
        $this->laporan = $laporan;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'judul' => 'Laporan Baru',
            'pesan' => $this->laporan->user->name .' melaporkan kendaraan ' .$this->laporan->kendaraan->nomor_polisi,
            'laporan_id' => $this->laporan->id
        ];
    }
}
<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;


Schedule::command('app:hapus-notifikasi-lama')
    ->daily();

// Schedule::command('app:kelola-laporan-otomatis')
//     ->daily();

    Schedule::command('app:kelola-laporan-otomatis')
    ->everyMinute();

    // php artisan schedule:work

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
class HapusNotifikasiLama extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:hapus-notifikasi-lama';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
{
    DB::table('notifications')
        ->where('created_at', '<', now()->subDays(7))
        ->delete();

    $this->info('Notifikasi lama berhasil dihapus');
}
}

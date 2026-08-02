<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use App\Models\LaporanPeralatan;
use App\Models\LaporanKondisi;
use App\Models\Platon;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardUserController extends Controller
{
    public function index()
    {

        $userId = auth()->id();
        $user = User::with(['platon', 'regu'])
            ->findOrFail(Auth::id());
       


        $laporanHarian = Laporan::where('user_id', $userId)
            ->whereDate('created_at', Carbon::today())
            ->count();

        $kendaraanHarian = Laporan::where('user_id', $userId)
            ->whereDate('created_at', Carbon::today())
            ->distinct('kendaraan_id')
            ->count('kendaraan_id');

        $peralatanRusakHarian = LaporanPeralatan::whereHas('laporan', function ($q) use ($userId) {
                $q->where('user_id', $userId)
                  ->whereDate('created_at', Carbon::today());
            })
            ->where('kondisi', 'Rusak Berat')
            ->count();

        $kondisiBermasalahHarian = LaporanKondisi::whereHas('laporan', function ($q) use ($userId) {
                $q->where('user_id', $userId)
                  ->whereDate('created_at', Carbon::today());
            })
            ->where('status', 'Perlu Perhatian')
            ->count();



        /*
        |--------------------------------------------------------------------------
        | Statistik Mingguan
        |--------------------------------------------------------------------------
        */

        $mingguLalu = Carbon::now()->subDays(7);

        $laporanMingguan = Laporan::where('user_id', $userId)
            ->where('created_at', '>=', $mingguLalu)
            ->count();

        $kendaraanMingguan = Laporan::where('user_id', $userId)
            ->where('created_at', '>=', $mingguLalu)
            ->distinct('kendaraan_id')
            ->count('kendaraan_id');

        $peralatanRusakMingguan = LaporanPeralatan::whereHas('laporan', function ($q) use ($userId, $mingguLalu) {
                $q->where('user_id', $userId)
                  ->where('created_at', '>=', $mingguLalu);
            })
            ->where('kondisi', 'Rusak Berat')
            ->count();

        $kondisiBermasalahMingguan = LaporanKondisi::whereHas('laporan', function ($q) use ($userId, $mingguLalu) {
                $q->where('user_id', $userId)
                  ->where('created_at', '>=', $mingguLalu);
            })
            ->where('status', 'Perlu Perhatian')
            ->count();
    $chartData = [
    [
        'name' => 'Laporan',
        'total' => $laporanMingguan
    ],
    [
        'name' => 'Kendaraan',
        'total' => $kendaraanMingguan
    ],
    [
        'name' => 'Peralatan Rusak',
        'total' => $peralatanRusakMingguan
    ],
    [
        'name' => 'Kondisi Bermasalah',
        'total' => $kondisiBermasalahMingguan
    ],
];



        return view('user.dashboard.index', compact(
            'laporanHarian',
            'kendaraanHarian',
            'peralatanRusakHarian',
            'kondisiBermasalahHarian',
            'user',
            'laporanMingguan',
            'kendaraanMingguan',
            'peralatanRusakMingguan',
            'kondisiBermasalahMingguan', 'chartData'

        ));
    }
}
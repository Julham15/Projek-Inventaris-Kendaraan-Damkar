<?php

namespace App\Http\Controllers;
use App\Models\JenisMobil;
use App\Models\Kendaraan;
use App\Models\Laporan;
use App\Models\LaporanPeralatan;
use App\Models\LaporanKondisi;
use App\Models\StatusPeralatan;
use App\Models\StatusKondisi;
use App\Models\Posko;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
class DashboardPemantauController extends Controller
{
     public function index(Posko $posko)
    {
         $user = Auth::user();
        $data =  $posko->jenisMobils;
        $jabatan = Auth::user()->jabatan;
        $namaPemantau = Auth::user()->name;
        $totalJenisMobil = JenisMobil::count();
        $totalposko = Posko::count();
        $totalKendaraan = Kendaraan::count();

        $totalLaporan = Laporan::count();

        $jumlahPeralatanRusak = StatusPeralatan::where('status','Rusak Berat')->count();
        $jumlahKondisiPerhatian = StatusKondisi::where('status','Perlu Perhatian')->count();

        $kendaraanTerbaru = Kendaraan::with('jenisMobil.posko')
            ->latest()
            ->take(5)
            ->get();

        $laporanTerbaru = Laporan::with([
                'user',
                'kendaraan'
            ])
            ->latest()
            ->take(5)
            ->get();

        $laporanBulanan = Laporan::select(
                DB::raw('MONTH(created_at) as bulan'),
                DB::raw('COUNT(*) as total')
            )
            ->groupBy('bulan')
            ->get();

        $peralatanRusakBulanan = LaporanPeralatan::select(
                DB::raw('MONTH(created_at) as bulan'),
                DB::raw('COUNT(*) as total')
            )
            ->where('kondisi', 'Rusak Berat')
            ->groupBy('bulan')
            ->get();

        $kondisiPerhatianBulanan = LaporanKondisi::select(
                DB::raw('MONTH(created_at) as bulan'),
                DB::raw('COUNT(*) as total')
            )
            ->where('status', 'Perlu Perhatian')
            ->groupBy('bulan')
            ->get();

        return view('pemantau.dashboard.index', compact(
            'totalJenisMobil',
            'totalKendaraan',
            'totalLaporan',
            'jumlahPeralatanRusak',
            'jumlahKondisiPerhatian',
            'kendaraanTerbaru',
            'laporanTerbaru',
            'jabatan',
            'user',
            'totalposko',
            'laporanBulanan',
            'peralatanRusakBulanan',
            'kondisiPerhatianBulanan',
            'namaPemantau',
            'posko'
        ));
    }
}
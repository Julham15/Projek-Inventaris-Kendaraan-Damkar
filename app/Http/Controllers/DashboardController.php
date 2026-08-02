<?php

namespace App\Http\Controllers;
use App\Models\Posko;
use App\Models\JenisMobil;
use App\Models\Kendaraan;
use App\Models\Laporan;
use App\Models\LaporanPeralatan;
use App\Models\LaporanKondisi;
use App\Models\StatusPeralatan;
use App\Models\StatusKondisi;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        
        $totalposko = Posko::count();
        $totalJenisMobil = JenisMobil::count();
        $totalKendaraan = Kendaraan::count();
        $totalLaporan = Laporan::count();
        $jumlahPeralatanRusak = StatusPeralatan::where('status','Rusak Berat')->count();
        $jumlahKondisiPerhatian = StatusKondisi::where('status','Perlu Perhatian')->count();
        // $kendaraanAktif = Kendaraan::where('status', 'Aktif')->count();
        // $kendaraanTidakAktif = Kendaraan::where('status', 'Tidak Aktif')->count();

        // chart laporan bulanan
        $laporanBulanan = Laporan::select(
                DB::raw('MONTH(created_at) as bulan'),
                DB::raw('COUNT(*) as total')
            )
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();
        $peralatanRusakBulanan = LaporanPeralatan::selectRaw(
    'MONTH(created_at) as bulan, COUNT(*) as total')
        ->where('kondisi', 'Rusak Berat')->groupBy('bulan')->get();

$kondisiPerhatianBulanan = LaporanKondisi::selectRaw(
    'MONTH(created_at) as bulan, COUNT(*) as total'
    )->where('status', 'Perlu Perhatian')->groupBy('bulan')->get();
        // kendaraan terbaru
        $kendaraanTerbaru = Kendaraan::latest()->take(3)->get();
        // laporan terbaru
        $laporanTerbaru = Laporan::with('user', 'kendaraan')
            ->latest()
            ->take(3)
            ->get();
        return view('admin.dashboard.index', compact(
            'totalJenisMobil',
            'totalKendaraan',
            'totalLaporan',
            // 'kendaraanAktif',
            // 'kendaraanTidakAktif',
            'laporanBulanan',
            'kendaraanTerbaru',
            'laporanTerbaru',
             'totalposko',
            'jumlahPeralatanRusak',
            'jumlahKondisiPerhatian',
            'peralatanRusakBulanan',
            'kondisiPerhatianBulanan',
        ));
    }
    public function peralatanRusak(){
            $data = StatusPeralatan::with([
                'kendaraan',
                'peralatan'])
            ->where('status', 'Rusak Berat')
            ->get();
    return view('admin.dashboard.peralatan-rusak',compact('data'));
    }
    public function kondisiBermasalah()
    {
        $data = StatusKondisi::with([
            'kendaraan',
            'kondisi'
        ])
        ->where('status', 'Perlu Perhatian')
        ->get();
        return view('admin.dashboard.kondisi-bermasalah',compact('data'));
    }
    public function alatrusak(){
        $user = Auth::user();
             $jabatan = Auth::user()->jabatan;
        $namaPemantau = Auth::user()->name;
            $data = StatusPeralatan::with([
                'kendaraan.jenisMobil.posko',
                'peralatan'])
            ->where('status', 'Rusak Berat')
            ->get();
    return view('pemantau.dashboard.peralatan-rusak',compact('data','jabatan','namaPemantau','user'));
    }
    public function kondisimasalah()
    {
        $user = Auth::user();
         $jabatan = Auth::user()->jabatan;
        $namaPemantau = Auth::user()->name;
        $data = StatusKondisi::with([
            'kendaraan.jenisMobil.posko',
            'kondisi'
        ])
        ->where('status', 'Perlu Perhatian')
        ->get();
        return view('pemantau.dashboard.kondisi-bermasalah',compact('data','jabatan','namaPemantau','user'));
    }
}
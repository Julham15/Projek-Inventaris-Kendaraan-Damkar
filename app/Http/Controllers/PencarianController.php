<?php

namespace App\Http\Controllers;

use App\Models\JenisMobil;
use App\Models\Kendaraan;
use App\Models\Peralatan;
use App\Models\Kondisi;
use App\Models\Posko;
use App\Models\Platon;
use App\Models\regu;
use App\Models\User;
use Illuminate\Http\Request;

class PencarianController extends Controller
{
    public function index(Request $request)
    {
        $poskos = Posko::all();
        $platons = Platon::all();
        $regus = Regu::all();
        $jenisMobil = JenisMobil::all();
      
        $kendaraans = Kendaraan::query();

        $peralatans = Peralatan::query();

          if ($request->posko_id) {

        $kendaraans->whereHas('jenisMobil', function ($q) use ($request) {

            $q->where('posko_id', $request->posko_id);

        });
    }
        // FILTER JENIS MOBIL
        if ($request->jenis_mobil_id) {

            $kendaraans->where(
                'jenis_mobil_id',
                $request->jenis_mobil_id
            );
        }

        // FILTER KENDARAAN
        if ($request->kendaraan_id) {

            $peralatans->where(
                'kendaraan_id',
                $request->kendaraan_id
            );
        }
        $users = User::query();

        if ($request->platon_id) {
    $users->where('platon_id', $request->platon_id);
}

if ($request->regu_id) {
    $users->where('regu_id', $request->regu_id);
}

        // FILTER KONDISI

        return view('admin.pencarian.index', [
             'poskos' => $poskos,
             'platons' => $platons,
            'regus' => $regus,
            'jenisMobil' => $jenisMobil,
            'kendaraans' => $kendaraans->get(),
            'peralatans' => $peralatans->get(),
        ]);
    }
    public function show(Kendaraan $kendaraan)
{
    $kendaraan->load([
        'jenisMobil',
        'peralatans',
        'kondisis'
    ]);

    return view('admin.pencarian.show', compact('kendaraan'));
}
}
<?php

namespace App\Http\Controllers;

use App\Models\Kondisi;
use Illuminate\Http\Request;
use App\Models\JenisMobil;
use App\Models\Posko;
use App\Models\Kendaraan;

class KondisiController extends Controller
{
    public function index(Posko $posko,JenisMobil $jenis_mobil, Kendaraan $kendaraan)
    {
        $kondisis = $kendaraan->kondisis;
        return view('admin.kondisi.index', compact('posko','jenis_mobil','kendaraan','kondisis'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Posko $posko,JenisMobil $jenis_mobil, Kendaraan $kendaraan)
    {
        return view('admin.kondisi.create', compact('posko','jenis_mobil','kendaraan'));
    }

 
    public function store(
        Request $request,Posko $posko,
        JenisMobil $jenis_mobil,
        Kendaraan $kendaraan
    ) {

        $request->validate([
            'nama_kondisi' => 'required',
            'status' => 'required|in:Baik,Cukup,Perlu Perhatian',
            'keterangan' => 'nullable'
        ]);

        Kondisi::create([
            'kendaraan_id' => $kendaraan->id,
            'nama_kondisi' => $request->nama_kondisi,
            'status' => $request->status,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route(
            'posko.jenis-mobil.kendaraan.kondisi.index',
            [$posko->id,$jenis_mobil->id, $kendaraan->id]
        )->with('success', 'Kondisi berhasil ditambahkan');
    }

    /**
     * Show the form for editing the resource.
     */
    public function edit(Posko $posko,JenisMobil $jenis_mobil,Kendaraan $kendaraan,Kondisi $kondisi)
    {
        return view('admin.kondisi.edit', compact('posko','jenis_mobil','kendaraan','kondisi'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        Request $request,Posko $posko,
        JenisMobil $jenis_mobil,
        Kendaraan $kendaraan,
        Kondisi $kondisi
    ) {

        $request->validate([
            'nama_kondisi' => 'required',
            'status' => 'required|in:Baik,Cukup,Perlu Perhatian',
            'keterangan' => 'nullable'
        ]);

        $kondisi->update([
            'nama_kondisi' => $request->nama_kondisi,
            'status' => $request->status,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route(
            'posko.jenis-mobil.kendaraan.kondisi.index',
            [$posko->id,$jenis_mobil->id, $kendaraan->id]
        )->with('success', 'Kondisi berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Posko $posko,
        JenisMobil $jenis_mobil,
        Kendaraan $kendaraan,
        Kondisi $kondisi
    ) {

        $kondisi->delete();

        return redirect()->back()
            ->with('success', 'Kondisi berhasil dihapus');
    }
}

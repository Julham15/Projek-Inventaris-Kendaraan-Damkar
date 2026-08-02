<?php

namespace App\Http\Controllers;

use App\Models\JenisMobil;
use App\Models\Kendaraan;
use App\Models\Peralatan;
use App\Models\Posko;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PeralatanController extends Controller
{
    public function index(Posko $posko, JenisMobil $jenis_mobil,Kendaraan $kendaraan)
    {
        $peralatans = $kendaraan->peralatans;
    $peralatans = Peralatan::where('kendaraan_id', $kendaraan->id)->paginate(10);
        return view('admin.peralatan.index', compact(
            'posko',
            'jenis_mobil',
            'kendaraan',
            'peralatans'
        ));
    }

    public function create(Posko $posko,
        JenisMobil $jenis_mobil,
        Kendaraan $kendaraan
    )
    {
        return view('admin.peralatan.create', compact('posko',
            'jenis_mobil',
            'kendaraan'
        ));
    }

    public function store(Request $request, Posko $posko,
        JenisMobil $jenis_mobil,
        Kendaraan $kendaraan
    )
    {
        $request->validate([
            'nama_alat' => 'required',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png',
            'jumlah' => 'required|integer',
            'kondisi' => 'required',
            'tanggal_pengadaan' => 'nullable|date',
            'deskripsi' => 'nullable',
        ]);

        $gambar = null;

        if ($request->hasFile('gambar')) {
            $gambar = $request->file('gambar')
                              ->store('peralatan', 'public');
        }

        Peralatan::create([
            'kendaraan_id' => $kendaraan->id,
            'nama_alat' => $request->nama_alat,
            'gambar' => $gambar,
            'jumlah' => $request->jumlah,
            'kondisi' => $request->kondisi,
            'tanggal_pengadaan' => $request->tanggal_pengadaan,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()->route(
            'posko.jenis-mobil.kendaraan.peralatan.index',
            [$posko->id,$jenis_mobil->id, $kendaraan->id]
        )->with('success', 'Peralatan berhasil ditambahkan');
    }

    public function edit(Posko $posko,
        JenisMobil $jenis_mobil,
        Kendaraan $kendaraan,
        Peralatan $peralatan
    )
    {
        return view('admin.peralatan.edit', compact('posko',
            'jenis_mobil',
            'kendaraan',
            'peralatan'
        ));
    }

    public function update(Request $request,Posko $posko,
        JenisMobil $jenis_mobil,
        Kendaraan $kendaraan,
        Peralatan $peralatan
    )
    {
        $request->validate([
            'nama_alat' => 'required',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png',
            'jumlah' => 'required|integer',
            'kondisi' => 'required',
            'tanggal_pengadaan' => 'nullable|date',
            'deskripsi' => 'nullable',
        ]);

        $gambar = $peralatan->gambar;

        if ($request->hasFile('gambar')) {

            if ($peralatan->gambar) {
                Storage::disk('public')
                       ->delete($peralatan->gambar);
            }

            $gambar = $request->file('gambar')
                              ->store('peralatan', 'public');
        }

        $peralatan->update([
            'nama_alat' => $request->nama_alat,
            'gambar' => $gambar,
            'jumlah' => $request->jumlah,
            'kondisi' => $request->kondisi,
            'tanggal_pengadaan' => $request->tanggal_pengadaan,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()->route(
            'posko.jenis-mobil.kendaraan.peralatan.index',
            [$posko->id,$jenis_mobil->id, $kendaraan->id]
        )->with('success', 'Peralatan berhasil diupdate');
    }

    public function destroy(Posko $posko,
        JenisMobil $jenis_mobil,
        Kendaraan $kendaraan,
        Peralatan $peralatan
    )
    {
        if ($peralatan->gambar) {
            Storage::disk('public')
                   ->delete($peralatan->gambar);
        }

        $peralatan->delete();

        return redirect()->route(
            'posko.jenis-mobil.kendaraan.peralatan.index',
            [$posko->id, $jenis_mobil->id, $kendaraan->id]
        )->with('success', 'Peralatan berhasil dihapus');
    }
}
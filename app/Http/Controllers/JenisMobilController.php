<?php

namespace App\Http\Controllers;

use App\Models\JenisMobil;
use Illuminate\Http\Request;
use App\Models\Posko;
use Illuminate\Support\Facades\Storage;

class JenisMobilController extends Controller
{
    public function index(Posko $posko, JenisMobil $jenis_mobil)
    {
        // Di controller, cek jumlah data per halaman
       
// atau

       
        $data = JenisMobil::where('posko_id', $posko->id)->paginate(5);
   
                return view('admin.jenis_mobil.index', compact('data', 'posko'));
    }

    public function create(Posko $posko)
    {

        return view('admin.jenis_mobil.create',compact('posko'));
    }

   public function store(Request $request, Posko $posko)
    {
        $request->validate([
            'nama_jenis' => 'required',
            'gambar' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $gambar = $request->file('gambar')
                        ->store('jenis_mobil', 'public');

        $posko->jenisMobils()->create([
            'nama_jenis' => $request->nama_jenis,
            'gambar'     => $gambar,
        ]);

        return redirect()
            ->route('posko.jenis-mobil.index', $posko)
            ->with('success', 'Data berhasil ditambahkan');
    }

    public function edit(Posko $posko, JenisMobil $jenisMobil)
{
    return view('admin.jenis_mobil.edit', [
        'data' => $jenisMobil,
        'posko' => $posko,
    ]);
}
    

    

    public function update(Request $request,Posko $posko,JenisMobil $jenisMobil)
{
    $request->validate([
        'nama_jenis' => 'required',
        'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
    ]);

    $gambar = $jenisMobil->gambar;

    if ($request->hasFile('gambar')) {

        if ($jenisMobil->gambar) {
            Storage::disk('public')->delete($jenisMobil->gambar);
        }

        $gambar = $request->file('gambar')
                           ->store('jenis_mobil', 'public');
    }

    $jenisMobil->update([
        'nama_jenis' => $request->nama_jenis,
        'keterangan' => $request->keterangan,
        'gambar'     => $gambar,
    ]);

    return redirect()->route('posko.jenis-mobil.index', $posko)->with('success', 'Data berhasil diupdate');
}
   public function destroy(Posko $posko, JenisMobil $jenisMobil)
{
    // Cek apakah masih memiliki kendaraan
    if ($jenisMobil->kendaraans()->exists()) {
        return redirect()
            ->route('posko.jenis-mobil.index', $posko)
            ->with(
                'error',
                'Jenis mobil tidak dapat dihapus karena masih memiliki kendaraan.'
            );
    }

    // Hapus gambar jika ada
    if (
        $jenisMobil->gambar &&
        Storage::disk('public')->exists($jenisMobil->gambar)
    ) {
        Storage::disk('public')->delete($jenisMobil->gambar);
    }

    // Hapus data jenis mobil
    $jenisMobil->delete();

    return redirect()
        ->route('posko.jenis-mobil.index', $posko)
        ->with(
            'success',
            'Data berhasil dihapus.'
        );
}
}

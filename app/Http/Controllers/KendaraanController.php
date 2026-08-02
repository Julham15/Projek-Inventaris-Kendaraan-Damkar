<?php

namespace App\Http\Controllers;

use App\Models\Kendaraan;
use App\Models\JenisMobil;
use App\Models\Posko;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
class KendaraanController extends Controller
{
  public function index(Posko $posko, JenisMobil $jenis_mobil)
{
    $kendaraan = $jenis_mobil->kendaraans()
        ->with('jenisMobil.posko')
        ->latest()
        ->paginate(5);

    return view('admin.kendaraan.index', compact('kendaraan', 'posko', 'jenis_mobil'));
}
    public function create(Posko $posko, JenisMobil $jenis_mobil)
    {
         return view('admin.kendaraan.create', compact('posko','jenis_mobil'));
    }

    public function store(Request $request, Posko $posko, JenisMobil $jenis_mobil)
    {
        $request->validate([
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            // 'status' => 'required|in:Aktif,Tidak Aktif',
        ]);

        $gambar = null;
        if ($request->hasFile('gambar'))
        {
            $gambar = $request->file('gambar')->store('kendaraan', 'public');
        }

        $jenis_mobil->kendaraans()->create([
            'nomor_polisi' => $request->nomor_polisi,
            'deskripsi' => $request->deskripsi,
            // 'status' => $request->status,
            'gambar' => $gambar,
        ]);
       $jenis_mobil->increment('jumlah_mobil');
        return redirect()->route('posko.jenis-mobil.kendaraan.index',[$posko, $jenis_mobil]);
    }

    public function edit(Posko $posko, JenisMobil $jenis_mobil,Kendaraan $kendaraan)
    {
         return view('admin.kendaraan.edit', compact('posko','jenis_mobil','kendaraan'));
    }
  
   public function update(Request $request,Posko $posko, JenisMobil $jenis_mobil, Kendaraan $kendaraan)
{
    $request->validate([
        // 'status' => 'required|in:Aktif,Tidak Aktif',
        'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
    ]);

    // gunakan gambar lama terlebih dahulu
    $gambar = $kendaraan->gambar;

    // jika upload gambar baru
    if ($request->hasFile('gambar')) {

        // hapus gambar lama
        if ($kendaraan->gambar) {
            Storage::disk('public')->delete($kendaraan->gambar);
        }

        // simpan gambar baru
        $gambar = $request->file('gambar')
            ->store('kendaraan', 'public');
    }

    // update data
    $kendaraan->update([
        'nomor_polisi' => $request->nomor_polisi,
        'deskripsi' => $request->deskripsi,
        'gambar' => $gambar
    ]);

    return redirect()->route(
        'posko.jenis-mobil.kendaraan.index',
        [$posko->id,$jenis_mobil->id]
    );
}

    public function destroy(Posko $posko, JenisMobil $jenis_mobil, Kendaraan $kendaraan)
{
    
    // Cek apakah kendaraan sudah memiliki laporan
    if ($kendaraan->laporans()->exists()) {
        return redirect()->back()->with(
            'error',
            'Kendaraan tidak dapat dihapus karena sudah memiliki riwayat laporan.'
        );
    }

    // Hapus gambar jika ada
    if (
        $kendaraan->gambar &&
        Storage::disk('public')->exists($kendaraan->gambar)
    ) {
        Storage::disk('public')->delete($kendaraan->gambar);
    }

    // Kurangi jumlah mobil
    $kendaraan->jenisMobil->decrement('jumlah_mobil');

    // Hapus kendaraan
    $kendaraan->delete();

    return redirect()->route(
        'posko.jenis-mobil.kendaraan.index',
        [$posko->id, $jenis_mobil->id]
    )->with('success', 'Data kendaraan berhasil dihapus.');
}

public function mutasi(Posko $posko, JenisMobil $jenis_mobil, Kendaraan $kendaraan)
{
    // Semua posko kecuali posko kendaraan saat ini
    $poskos = Posko::where('id', '!=', $posko->id)
        ->orderBy('nama_posko')
        ->get();

    return view(
        'admin.kendaraan.mutasi',
        compact(
            'posko',
            'jenis_mobil',
            'kendaraan',
            'poskos'
        )
    );
}


public function prosesMutasi(Request $request,Posko $posko,JenisMobil $jenis_mobil, Kendaraan $kendaraan) {
    $request->validate([
        'posko_tujuan' => 'required|exists:poskos,id',
    ]);

    // Ambil data asli kendaraan
    $jenisMobilAsal = $kendaraan->jenisMobil;
    $poskoAsal = $jenisMobilAsal->posko;

    // Tidak boleh memindahkan ke Posko yang sama
    if ($request->posko_tujuan == $poskoAsal->id) {
        return back()->with(
            'error',
            'Kendaraan sudah berada pada Posko yang dipilih.'
        );
    }

    DB::transaction(function () use (
        $request,
        $kendaraan,
        $jenisMobilAsal
    ) {

       $jenisMobilTujuan = JenisMobil::where('posko_id', $request->posko_tujuan)
    ->where('nama_jenis', $jenisMobilAsal->nama_jenis)
    ->first();

if (!$jenisMobilTujuan) {
    return back()->with(
        'error',
        'Jenis mobil "' . $jenisMobilAsal->nama_jenis . '" tidak ditemukan pada Posko tujuan.'
    );
}

DB::transaction(function () use (
    $kendaraan,
    $jenisMobilAsal,
    $jenisMobilTujuan
) {
    $jenisMobilAsal->decrement('jumlah_mobil');

    $jenisMobilTujuan->increment('jumlah_mobil');

  
    $kendaraan->update([
        'jenis_mobil_id' => $jenisMobilTujuan->id,
    ]);
});
       
    });

    // Ambil kembali data kendaraan setelah dimutasi
    $kendaraan->refresh();

    return redirect()->route('posko.jenis-mobil.kendaraan.index',[$kendaraan->jenisMobil->posko,$kendaraan->jenisMobil])->with( 'success','Kendaraan berhasil dimutasikan.');
}
}

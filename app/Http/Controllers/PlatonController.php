<?php

namespace App\Http\Controllers;
use App\Models\Platon;
use App\Models\Regu;
use App\Models\User;
use Illuminate\Http\Request;

class PlatonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{
     $platons = Platon::with('regus')->get(); 
    $regus = Regu::with('platon')->get();
   
           // Asumsi: user memiliki relasi ke platon_id dan regu_id di tabel users
        $totalPetugas = User::where(function($query) {
                $query->whereNotNull('platon_id')
                      ->orWhereNotNull('regu_id');
            })
            ->count();

    return view('admin.platon.index', compact('platons','regus','totalPetugas'));
}

  
    public function create()
    {
        //
    }

   
   public function store(Request $request)
{
    $request->validate([
            'nama' => 'required|string|max:25|unique:platons,nama'
        ], [
            'nama.unique' => 'Nama Platon ":input" sudah ada. Silakan gunakan nama yang berbeda.'
        ]);

        Platon::create([
            'nama' => $request->nama
        ]);

    return back()->with('success', 'Platon "' . $request->nama . '" berhasil ditambahkan');
}

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Platon $platon)
{
    $request->validate([
        'nama' => 'required|string|max:255',
    ]);

    $platon->update($request->all());

    return back()->with('success', 'Platon berhasil diupdate');
}
    /**
     * Remove the specified resource from storage.
     */
   public function destroy($id)
{
    $platon = Platon::findOrFail($id);

    // Cek apakah ada laporan
    if ($platon->laporans()->exists()) {
        return back()->with(
            'error',
            'Platon "' . $platon->nama . '" tidak dapat dihapus karena masih digunakan pada data laporan.'
        );
    }

    // Cek apakah masih ada user
    if ($platon->users()->exists()) {
        return back()->with(
            'error',
            'Platon "' . $platon->nama . '" tidak dapat dihapus karena masih digunakan oleh pengguna.'
        );
    }

    // Cek apakah masih ada regu
    if ($platon->regus()->exists()) {
        return back()->with(
            'error',
            'Hapus seluruh Regu pada Platon "' . $platon->nama . '" terlebih dahulu.'
        );
    }

    $platon->delete();

    return back()->with(
        'success',
        'Platon "' . $platon->nama . '" berhasil dihapus.'
    );
}
}

<?php

namespace App\Http\Controllers;
use App\Models\Regu;
use App\Models\Platon;
use Illuminate\Http\Request;

class ReguController extends Controller
{
    public function index()
{
    $regus = Regu::with('platon')
        ->latest()
        ->get();

    $platons = Platon::all();

    return view('admin.regu.index', compact(
        'regus',
        'platons'
    ));
}
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
   public function store(Request $request)
{
     $request->validate([
            'platon_id' => 'required|exists:platons,id',
            'nama' => 'required|integer|min:1|max:999'
        ]);
     $existingRegu = Regu::where('platon_id', $request->platon_id)
                            ->where('nama', (int)$request->nama) // Cast ke integer
                            ->first();

        if ($existingRegu) {
            $platon = Platon::find($request->platon_id);
            return redirect()->back()
                ->withInput()
                ->with('error', 'Regu nomor ' . $request->nama . ' sudah ada di Platon "' . $platon->nama . '". Silakan gunakan nomor yang berbeda.');
        }

        Regu::create([
            'platon_id' => $request->platon_id,
            'nama' => (int)$request->nama // Pastikan integer
        ]);

        $platon = Platon::find($request->platon_id);
    return back()
        ->with('success', 'Regu berhasil ditambahkan');
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
   public function update(Request $request, Regu $regu)
{
    $request->validate([
        'platon_id' => 'required|exists:platons,id',
        'nama' => 'required|max:255',
    ]);

    $regu->update([
        'platon_id' => $request->platon_id,
        'nama' => $request->nama,
    ]);

    return back()
        ->with('success', 'Regu berhasil diubah');
}

    /**
     * Remove the specified resource from storage.
     */
  public function destroy(Regu $regu)
{
    // Cek laporan
    if ($regu->laporans()->exists()) {
        return back()->with(
            'error',
            'Regu nomor ' . $regu->nama .
            ' tidak dapat dihapus karena masih digunakan pada data laporan.'
        );
    }

    // Cek user
    if ($regu->users()->exists()) {
        return back()->with(
            'error',
            'Regu nomor ' . $regu->nama .
            ' tidak dapat dihapus karena masih digunakan oleh pengguna.'
        );
    }

    $namaRegu = $regu->nama;
    $namaPlaton = $regu->platon->nama;

    $regu->delete();

    return back()->with(
        'success',
        'Regu nomor ' . $namaRegu .
        ' dari Platon "' . $namaPlaton .
        '" berhasil dihapus.'
    );
}
}

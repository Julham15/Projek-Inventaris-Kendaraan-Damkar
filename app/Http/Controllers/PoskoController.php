<?php

namespace App\Http\Controllers;

use App\Models\Posko;
use Illuminate\Http\Request;


class PoskoController extends Controller
{
   public function index()
    {
        $poskos = Posko::latest()->get();
            $poskos = Posko::paginate(10);
        return view('admin.posko.index', compact('poskos'));
    }

    public function create()
    {
        return view('admin.posko.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_posko' => 'required|string|max:255',
            'alamat' => 'nullable|string',
        ]);

        Posko::create($request->only('nama_posko', 'alamat'));

        return redirect()
            ->route('posko.index')
            ->with('success', 'Posko berhasil ditambahkan.');
    }

    public function edit(Posko $posko)
    {
        return view('admin.posko.edit', compact('posko'));
    }

    public function update(Request $request, Posko $posko)
    {
        $request->validate([
            'nama_posko' => 'required|string|max:255',
            'alamat' => 'nullable|string',
        ]);

        $posko->update($request->only('nama_posko', 'alamat'));

        return redirect()
            ->route('posko.index')
            ->with('success', 'Posko berhasil diperbarui.');
    }

    public function destroy(Posko $posko)
{
    // Cek apakah masih memiliki jenis mobil
    if ($posko->jenisMobils()->exists()) {

        return redirect()
            ->route('posko.index')
            ->with(
                'error',
                'Posko tidak dapat dihapus karena masih memiliki data jenis mobil.'
            );
    }

    // Hapus posko
    $posko->delete();

    return redirect()
        ->route('posko.index')
        ->with(
            'success',
            'Posko berhasil dihapus.'
        );
}
}

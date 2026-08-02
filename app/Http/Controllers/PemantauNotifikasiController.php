<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;

class PemantauNotifikasiController extends Controller
{
    public function index()
{
    $jabatan = Auth::user()->jabatan;
    $namaPemantau = Auth::user()->name;
    $user = User::with(['platon', 'regu'])
            ->findOrFail(Auth::id());

    $notifikasis = auth()->user()
        ->notifications()
        ->latest()
        ->paginate(10);

    return view('pemantau.notifikasi.index', compact(
        'notifikasis',
        'jabatan',
        'namaPemantau','user'
    ));
}

    public function read($id)
    {
        $notif = auth()->user()
            ->notifications()
            ->findOrFail($id);

        $notif->markAsRead();

        return back();
    }

}

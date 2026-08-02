<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotifikasiController extends Controller
{
    public function index()
    {
        $notifikasis = auth()->user()
            ->notifications()
            ->latest()
            ->get();

        return view('admin.notifikasi.index', compact('notifikasis'));
    }

    public function read($id)
    {
        $notif = auth()->user()
            ->notifications()
            ->findOrFail($id);

        $notif->markAsRead();

        return back();
    }
    // Hapus satu notifikasi tertentu (boleh dibaca/belum)
    public function destroy($id)
    {
        $notif = auth()->user()
            ->notifications()
            ->findOrFail($id);

        $notif->delete();

        return back()->with('success', 'Notifikasi berhasil dihapus');
    }

    // Hapus SEMUA notifikasi yang sudah dibaca sekaligus
    public function deleteRead()
    {
        auth()->user()
            ->notifications()
            ->whereNotNull('read_at')
            ->delete();

        return back()->with('success', 'Semua notifikasi yang sudah dibaca berhasil dihapus');
    }

}


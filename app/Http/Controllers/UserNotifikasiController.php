<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;


class UserNotifikasiController extends Controller
{
    public function index()
    {
        $user = User::with(['platon', 'regu'])
            ->findOrFail(Auth::id());
       
        $notifikasis = auth()->user()
            ->notifications()
            ->latest()
            ->paginate(10);

        return view('user.notifikasi.index', compact('notifikasis','user'));
    }

    public function read($id)
    {
        $notif = auth()->user()
            ->notifications()
            ->findOrFail($id);

        $notif->markAsRead();

        return back();
    }

    public function destroy($id)
    {
        $notif = auth()->user()
            ->notifications()
            ->findOrFail($id);

        $notif->delete();

        return back()->with(
            'success',
            'Notifikasi berhasil dihapus'
        );
    }

    public function deleteRead()
    {
        auth()->user()
            ->notifications()
            ->whereNotNull('read_at')
            ->delete();

        return back()->with(
            'success',
            'Semua notifikasi berhasil dihapus'
        );
    }
}
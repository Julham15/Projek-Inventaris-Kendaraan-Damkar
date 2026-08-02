<?php

namespace App\Http\Controllers;
use App\Models\Platon;
use App\Models\Regu;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
class UserManagementController extends Controller
{
      public function index()
      {
           $platons = Platon::all();
              $activeUsers =  User::where('role', '!=', 'admin')
                          ->whereNull('deleted_at')
                          ->count();
            $regus = Regu::all();
            $penggunaAktif = User::where('role', '!=', 'admin')
                ->latest()
                ->get();
            $penggunaNonaktif = User::onlyTrashed()
                ->where('role', '!=', 'admin')
                ->latest()
                ->get();
//             dd(
//     $platons,
//     $regus,
//     $penggunaAktif,
//     $penggunaNonaktif
// );
            return view('admin.pengguna.index', compact('penggunaAktif','penggunaNonaktif', 'platons','regus','activeUsers'));
      }
      public function create()
    {
    $platons = Platon::all();
    $regus = Regu::all();

    return view('admin.users.create', compact(
        'platons',
        'regus'
    ));
    }
    public function edit(User $user)
{
    $platons = Platon::all();
    $regus = Regu::all();

    return view('admin.users.edit', compact(
        'user',
        'platons',
        'regus'
    ));
}

public function update(Request $request, User $user)
{
    $request->validate([
        'platon_id' => 'nullable|exists:platons,id',
        'regu_id' => 'nullable|exists:regus,id',
    ]);

    $user->update([
        'platon_id' => $request->platon_id,
        'regu_id' => $request->regu_id,
    ]);

    if ($user->role === 'user') {
    if (!$request->platon_id || !$request->regu_id) {
        return back()->with('error', 'User harus ditempatkan di Platon dan Regu.');
    }
}
    return redirect()
        ->route('pengguna.index')
        ->with('success', 'Penempatan pengguna berhasil diperbarui.');
}
      public function createPemantau()
      {
            return view('admin.pengguna.create-pemantau');
      }
      public function storePemantau(Request $request)
      {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'phone'    => 'nullable|string|max:20',
            'password' => 'required|min:8|confirmed',
            'jabatan'  => 'required|in:Kepala Dinas,Sekretaris,Kepala Seksi,Kepala Bidang',
        ]);
        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'phone'    => $request->phone,
            'password' => Hash::make($request->password),
            'role'     => 'admin2',
            'jabatan'  => $request->jabatan,
        ]);

        return redirect()->route('pengguna.index')->with('success', 'Akun pemantau berhasil ditambahkan.');
      }

      public function nonaktifkan(User $user)
      {
        // Admin tidak boleh menonaktifkan dirinya sendiri
        if ($user->id === auth()->id()) {
            return redirect()
                ->route('pengguna.index')
                ->with('error', 'Anda tidak dapat menonaktifkan akun sendiri.');
        }
        // Admin tidak boleh dinonaktifkan
        if ($user->role === 'admin') {
            return redirect()->route('pengguna.index')->with('error', 'Akun admin tidak dapat dinonaktifkan.');
        }
        $user->delete();
            return redirect()->route('pengguna.index')->with('success', 'Pengguna berhasil dinonaktifkan.');
      }
      public function restore($id)
      {
        $user = User::onlyTrashed()->findOrFail($id);

        $user->restore();

        return redirect()
            ->route('pengguna.index')
            ->with('success', 'Pengguna berhasil dipulihkan.');
      }

     

public function forceDelete($id)
{
    $user = User::onlyTrashed()->findOrFail($id);

    // Admin tidak boleh dihapus
    if ($user->role === 'admin') {
        return redirect()
            ->route('pengguna.index')
            ->with('error', 'Akun admin tidak dapat dihapus.');
    }

    // Masih memiliki laporan
    if ($user->laporans()->exists()) {
        return redirect()
            ->route('pengguna.index')
            ->with(
                'error',
                'Pengguna ini tidak dapat dihapus permanen karena masih memiliki laporan.'
            );
    }

    // Hapus foto profil jika ada
    if (
        $user->photo &&
        Storage::disk('public')->exists('profile/' . $user->photo)
    ) {
        Storage::disk('public')->delete('profile/' . $user->photo);
    }

    // Hapus permanen data pengguna
    $user->forceDelete();

    return redirect()
        ->route('pengguna.index')
        ->with('success', 'Pengguna berhasil dihapus permanen.');
}
}

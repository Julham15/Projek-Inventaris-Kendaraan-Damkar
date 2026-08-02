<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $user = User::with(['platon', 'regu'])
            ->findOrFail(Auth::id());
       
        return view('profile.edit', [
            'user' => $request->user(), compact('user')
        ]);
    }

 
   public function update(ProfileUpdateRequest $request): RedirectResponse
{
    $user = $request->user();

    $data = $request->validated();

    if ($request->hasFile('photo')) {

        // Hapus foto lama
        if ($user->photo && Storage::disk('public')->exists('profile/' . $user->photo)) {
            Storage::disk('public')->delete('profile/' . $user->photo);
        }

        // Simpan foto baru
        $filename = time() . '.' . $request->photo->extension();

        $request->photo->storeAs(
            'profile',
            $filename,
            'public'
        );

        // Update nama file di database
        $data['photo'] = $filename;
    }

    $user->fill($data);

    if ($user->isDirty('email')) {
        $user->email_verified_at = null;
    }

    $user->save();

    if ($user->role == 'admin2') {
        return Redirect::route('pemantau.profil')
            ->with('status', 'profile-updated');
    }

    return Redirect::route('profile.edit')
        ->with('status', 'profile-updated');
}

    public function destroy(Request $request): RedirectResponse
{
    $request->validateWithBag('userDeletion', [
        'password' => ['required', 'current_password'],
    ]);

    $user = $request->user();

    // Hapus file foto
    if ($user->photo && Storage::disk('public')->exists('profile/' . $user->photo)) {
        Storage::disk('public')->delete('profile/' . $user->photo);
    }

    Auth::logout();

    $user->delete();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return Redirect::to('/');
}
    public function Pemantauedit()
{
     $jabatan = Auth::user()->jabatan;
    $namaPemantau = Auth::user()->name;
    $user = User::with(['platon', 'regu'])
        ->findOrFail(Auth::id());

    return view('Pemantau.profil', compact('user','jabatan','namaPemantau'));
}
}

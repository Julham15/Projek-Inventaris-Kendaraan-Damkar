<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class PasswordController extends Controller
{
    /**
     * Update the user's password.
     */
    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validateWithBag('updatePassword', [
            'current_password' => ['required', 'current_password'],
            'password' => ['required', Password::defaults(), 'confirmed'],
        ]);

        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        return back()->with('status', 'password-updated');
    }
    protected function sendFailedPasswordUpdateResponse(Request $request)
{
    return redirect()
        ->route('pemantau.profil')
        ->withErrors(['current_password' => 'Password yang Anda masukkan salah.'])
        ->withInput($request->only('email'))
        ->with('scroll_to', 'password-section'); // Tambahkan session
}
}

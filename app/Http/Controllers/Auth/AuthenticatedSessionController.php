<?php

namespace App\Http\Controllers\Auth;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;


class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
{
    $request->authenticate();

    $request->session()->regenerate();

    $user = auth()->user();

    $role = strtolower(trim($user->role ?? ''));

    \Log::info('Login redirect check', [
        'user_id' => $user->id,
        'email'   => $user->email,
        'role'    => $role,
    ]);

    return match ($role) {
        'admin'  => redirect()->route('dashboard'),
        'admin2' => redirect()->route('dashboard-pemantau'),
        'user'   => redirect()->route('dashboard-user'),
        default  => throw new \Exception("Role tidak dikenali: '{$role}' untuk user ID {$user->id}"),
    };
}

    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}

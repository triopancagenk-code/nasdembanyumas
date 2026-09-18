<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
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

        $user = Auth::user();

        return redirect()->route('home')->with('success', 'Selamat datang ' . ($user && $user->isAdmin() ? 'Administrator DPD Partai NasDem Banyumas!' : ($user->name ?? 'Kader') . '!'));
    }

    /**
     * One-click demo login for instant role switching (Admin vs Pengguna).
     */
    public function quickLogin(string $role): RedirectResponse
    {
        if (!in_array($role, ['admin', 'pengguna'])) {
            return redirect()->route('login')->with('error', 'Role tidak valid.');
        }

        $user = User::where('role', $role)->first();

        if (!$user) {
            return redirect()->route('login')->with('error', 'Akun ' . $role . ' belum tersedia di sistem.');
        }

        Auth::login($user);
        request()->session()->regenerate();

        return redirect()->route('home')->with('success', $user->isAdmin() ? 'Berhasil masuk sebagai Administrator DPD!' : 'Berhasil masuk sebagai Pengguna / Kader Partai!');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/')->with('info', 'Anda telah keluar dari sesi.');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;

class AuthController extends Controller
{
    public function showLogin(): View
    {
        return view('pages.auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (! Auth::attempt([...$credentials, 'is_active' => true])) {
            return back()
                ->withErrors(['email' => 'Email atau password tidak sesuai.'])
                ->onlyInput('email');
        }

        $request->session()->regenerate();

        $user = Auth::user();
        if ($user && ($user->hasRole('super_admin') || $user->hasRole('reviewer'))) {
            return redirect()->intended(url('/admin'));
        }

        return redirect()->intended(route('recruitments.index'));
    }

    public function showRegister(): View
    {
        return view('pages.auth.register');
    }

    public function register(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'student_number' => ['required', 'string', 'max:20', 'unique:users,student_number'],
            'full_name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:150', 'unique:users,email'],
            'password' => ['required', 'confirmed', Password::min(8)],
            'phone' => ['nullable', 'string', 'max:20'],
            'faculty' => ['nullable', 'string', 'max:100'],
            'study_program' => ['nullable', 'string', 'max:100'],
            'entry_year' => ['nullable', 'integer', 'digits:4', 'min:2000', 'max:'.((int) date('Y') + 1)],
        ]);

        $user = User::create([
            'student_number' => $validated['student_number'],
            'full_name' => $validated['full_name'],
            'email' => $validated['email'],
            'password_hash' => Hash::make($validated['password']),
            'phone' => $validated['phone'] ?? null,
            'faculty' => $validated['faculty'] ?? null,
            'study_program' => $validated['study_program'] ?? null,
            'entry_year' => $validated['entry_year'] ?? null,
            'is_active' => true,
        ]);

        $user->assignRole(Role::findOrCreate('applicant', 'web'));

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('recruitments.index')->with('status', 'Registrasi berhasil. Kamu sudah login.');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('status', 'Kamu berhasil logout.');
    }
}

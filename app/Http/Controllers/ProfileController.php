<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function show(Request $request): View
    {
        $user = $request->user()->load([
            'applications.recruitmentPeriod.organization',
        ]);

        return view('pages.profile.show', [
            'user' => $user,
            'applications' => $user->applications()->with('recruitmentPeriod.organization')->latest('submitted_at')->get(),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $user = $request->user();

        $validated = $request->validate([
            'student_number' => ['required', 'string', 'max:20', Rule::unique('users', 'student_number')->ignore($user->id)],
            'full_name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:150', Rule::unique('users', 'email')->ignore($user->id)],
            'phone' => ['nullable', 'string', 'max:20'],
            'faculty' => ['nullable', 'string', 'max:100'],
            'study_program' => ['nullable', 'string', 'max:100'],
            'entry_year' => ['nullable', 'integer', 'digits:4', 'min:2000', 'max:'.((int) date('Y') + 1)],
            'password' => ['nullable', 'confirmed', Password::min(8)],
        ]);

        $user->fill([
            'student_number' => $validated['student_number'],
            'full_name' => $validated['full_name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'faculty' => $validated['faculty'] ?? null,
            'study_program' => $validated['study_program'] ?? null,
            'entry_year' => $validated['entry_year'] ?? null,
        ]);

        if (! empty($validated['password'])) {
            $user->password_hash = Hash::make($validated['password']);
        }

        $user->save();

        return back()->with('status', 'Profil berhasil diperbarui.');
    }
}

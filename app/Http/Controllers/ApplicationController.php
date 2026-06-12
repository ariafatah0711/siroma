<?php

namespace App\Http\Controllers;

use App\Mail\ApplicationSubmitted;
use App\Models\Application;
use App\Models\ApplicationDocument;
use App\Models\RecruitmentPeriod;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class ApplicationController extends Controller
{
    public function store(Request $request, RecruitmentPeriod $period): RedirectResponse
    {
        $validated = $request->validate([
            'first_division_id' => ['required', 'integer', 'exists:divisions,id'],
            'second_division_id' => ['nullable', 'integer', 'different:first_division_id', 'exists:divisions,id'],
            'motivation' => ['required', 'string', 'min:20'],
            'cv' => ['required', 'file', 'mimes:pdf,doc,docx', 'max:5120'],
        ]);

        $existing = $period->applications()->where('user_id', $request->user()->id)->first();

        if ($existing) {
            return redirect()->route('applications.show', $existing)
                ->with('status', 'Kamu sudah mendaftar di rekrutmen ini.');
        }

        DB::statement('SET @new_application_id = NULL');
        DB::statement('CALL `sp_submit_application`(?, ?, ?, ?, ?, @new_application_id)', [
            $request->user()->id,
            $period->id,
            $validated['first_division_id'],
            $validated['second_division_id'] ?? null,
            $validated['motivation'],
        ]);
        $applicationId = DB::selectOne('SELECT @new_application_id AS id')->id;

        $cv = $request->file('cv');
        $path = $cv->store("applications/{$applicationId}", 'public');

        ApplicationDocument::create([
            'application_id' => $applicationId,
            'document_type' => 'cv',
            'original_file_name' => $cv->getClientOriginalName(),
            'file_path' => $path,
        ]);

        $application = Application::with('user', 'recruitmentPeriod.organization')->findOrFail($applicationId);

        try {
            Mail::to($application->user->email)->send(new ApplicationSubmitted($application));
        } catch (\Throwable $e) {
            logger('Gagal kirim email pendaftaran: ' . $e->getMessage());
        }

        return redirect()
            ->route('applications.show', $applicationId)
            ->with('status', 'Pendaftaran berhasil dikirim. Cek email untuk informasi lebih lanjut.');
    }

    public function show(Application $application): View
    {
        $user = request()->user();

        abort_unless(
            $user && ($application->user_id === $user->id || $user->hasAnyRole(['super_admin', 'reviewer'])),
            403
        );

        $application->load([
            'user',
            'recruitmentPeriod.organization',
            'preferences.division',
            'documents',
            'statusHistory' => fn ($query) => $query->orderBy('changed_at'),
        ]);

        return view('pages.applications.show', [
            'application' => $application,
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\RecruitmentPeriod;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ApplicationController extends Controller
{
    public function store(Request $request, RecruitmentPeriod $period): RedirectResponse
    {
        $validated = $request->validate([
            'user_id' => ['required', 'integer', 'exists:users,id'],
            'first_division_id' => ['required', 'integer', 'exists:divisions,id'],
            'second_division_id' => ['nullable', 'integer', 'different:first_division_id', 'exists:divisions,id'],
            'motivation' => ['required', 'string', 'min:20'],
        ]);

        DB::statement('SET @new_application_id = NULL');
        DB::statement('CALL `sp_submit_application`(?, ?, ?, ?, ?, @new_application_id)', [
            $validated['user_id'],
            $period->id,
            $validated['first_division_id'],
            $validated['second_division_id'] ?? null,
            $validated['motivation'],
        ]);

        $applicationId = DB::selectOne('SELECT @new_application_id AS id')->id;

        return redirect()
            ->route('applications.show', $applicationId)
            ->with('status', 'Pendaftaran berhasil dikirim.');
    }

    public function show(Application $application): View
    {
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

<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use App\Models\RecruitmentPeriod;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RecruitmentController extends Controller
{
    public function index(Request $request): View
    {
        $query = RecruitmentPeriod::query()
            ->with('organization')
            ->withCount('applications');

        // Filter by organization
        if ($request->filled('organization')) {
            $query->where('organization_id', $request->integer('organization'));
        }

        // Search by title or organization name
        if ($request->filled('search')) {
            $search = $request->string('search');
            $query->where(function ($q) use ($search) {
                $q->where('recruitment_title', 'like', "%{$search}%")
                  ->orWhereHas('organization', fn ($q) => $q->where('organization_name', 'like', "%{$search}%"));
            });
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('recruitment_status', $request->string('status'));
        }

        $recruitments = $query
            ->orderByRaw("FIELD(recruitment_status, 'open', 'draft', 'closed', 'completed')")
            ->orderBy('registration_end_date')
            ->paginate(10)
            ->withQueryString();

        return view('pages.recruitments.index', [
            'organizations' => Organization::orderBy('organization_name')->get(),
            'recruitments' => $recruitments,
            'selectedOrganization' => $request->integer('organization') ?: null,
            'searchQuery' => $request->string('search') ?: null,
            'selectedStatus' => $request->string('status') ?: null,
        ]);
    }

    public function show(RecruitmentPeriod $period): View
    {
        $period->load([
            'organization.divisions' => fn ($query) => $query->where('is_active', true)->orderBy('division_name'),
            'applications',
        ]);

        return view('pages.recruitments.show', [
            'period' => $period,
        ]);
    }

    public function apply(Request $request, RecruitmentPeriod $period): View|RedirectResponse
    {
        $existing = $period->applications()->where('user_id', $request->user()->id)->first();

        if ($existing) {
            return redirect()->route('applications.show', $existing)
                ->with('status', 'Kamu sudah mendaftar di rekrutmen ini. Lihat status pendaftaran kamu.');
        }

        $period->load([
            'organization.divisions' => fn ($query) => $query->where('is_active', true)->orderBy('division_name'),
        ]);

        return view('pages.recruitments.apply', [
            'period' => $period,
        ]);
    }
}

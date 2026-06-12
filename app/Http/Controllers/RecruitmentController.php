<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use App\Models\RecruitmentPeriod;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RecruitmentController extends Controller
{
    public function index(Request $request): View
    {
        $recruitments = RecruitmentPeriod::query()
            ->with('organization')
            ->withCount('applications')
            ->when($request->filled('organization'), function ($query) use ($request) {
                $query->where('organization_id', $request->integer('organization'));
            })
            ->orderByRaw("FIELD(recruitment_status, 'open', 'draft', 'closed', 'completed')")
            ->orderBy('registration_end_date')
            ->get();

        return view('pages.recruitments.index', [
            'organizations' => Organization::orderBy('organization_name')->get(),
            'recruitments' => $recruitments,
            'selectedOrganization' => $request->integer('organization') ?: null,
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

    public function apply(RecruitmentPeriod $period): View
    {
        $period->load([
            'organization.divisions' => fn ($query) => $query->where('is_active', true)->orderBy('division_name'),
        ]);

        return view('pages.recruitments.apply', [
            'period' => $period,
        ]);
    }
}

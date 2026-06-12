<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use Illuminate\View\View;

class OrganizationController extends Controller
{
    public function index(): View
    {
        return view('pages.organizations.index', [
            'organizations' => Organization::query()
                ->withCount(['divisions', 'recruitmentPeriods'])
                ->when(request('search'), fn ($q, $s) => $q->where('organization_name', 'like', "%{$s}%")
                    ->orWhere('organization_code', 'like', "%{$s}%")
                    ->orWhere('description', 'like', "%{$s}%"))
                ->orderBy('organization_name')
                ->get(),
        ]);
    }

    public function show(Organization $organization): View
    {
        $organization->load([
            'divisions' => fn ($query) => $query->orderBy('division_name'),
            'recruitmentPeriods' => fn ($query) => $query->latest('created_at'),
        ]);

        return view('pages.organizations.show', [
            'organization' => $organization,
        ]);
    }
}

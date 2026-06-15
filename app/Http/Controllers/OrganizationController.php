<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use Illuminate\View\View;

class OrganizationController extends Controller
{
    public function index(): View
    {
        $query = Organization::query()
            ->withCount(['divisions', 'recruitmentPeriods']);

        // Advanced search
        if (request('search')) {
            $search = request('search');
            $query->where(function ($q) use ($search) {
                $q->where('organization_name', 'like', "%{$search}%")
                  ->orWhere('organization_code', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Sort options
        $sort = request('sort', 'name');
        match ($sort) {
            'divisions' => $query->orderByDesc('divisions_count'),
            'recruitments' => $query->orderByDesc('recruitment_periods_count'),
            'newest' => $query->latest('created_at'),
            default => $query->orderBy('organization_name'),
        };

        $organizations = $query->paginate(12)->withQueryString();

        return view('pages.organizations.index', [
            'organizations' => $organizations,
            'searchQuery' => request('search'),
            'sortBy' => $sort,
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

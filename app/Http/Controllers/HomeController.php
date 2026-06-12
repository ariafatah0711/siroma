<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Organization;
use App\Models\RecruitmentPeriod;
use App\Models\User;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        if (! Schema::hasTable('organizations')) {
            return view('pages.home', [
                'stats' => [
                    'organizations' => 0,
                    'openRecruitments' => 0,
                    'applications' => 0,
                    'students' => 0,
                ],
                'activeRecruitments' => collect(),
                'organizations' => collect(),
            ]);
        }

        return view('pages.home', [
            'stats' => [
                'organizations' => Organization::count(),
                'openRecruitments' => RecruitmentPeriod::where('recruitment_status', 'open')->count(),
                'applications' => Application::count(),
                'students' => User::count(),
            ],
            'activeRecruitments' => RecruitmentPeriod::query()
                ->with('organization')
                ->where('recruitment_status', 'open')
                ->orderBy('registration_end_date')
                ->limit(3)
                ->get(),
            'organizations' => Organization::query()
                ->withCount('divisions')
                ->orderBy('organization_name')
                ->limit(4)
                ->get(),
        ]);
    }
}

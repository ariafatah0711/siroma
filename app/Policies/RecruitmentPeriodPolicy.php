<?php

namespace App\Policies;

use App\Models\RecruitmentPeriod;
use App\Models\User;

class RecruitmentPeriodPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('view recruitment periods');
    }

    public function view(User $user, RecruitmentPeriod $recruitmentPeriod): bool
    {
        return $user->hasPermissionTo('view recruitment periods');
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('manage recruitment periods');
    }

    public function update(User $user, RecruitmentPeriod $recruitmentPeriod): bool
    {
        return $user->hasPermissionTo('manage recruitment periods');
    }

    public function delete(User $user, RecruitmentPeriod $recruitmentPeriod): bool
    {
        return $user->hasPermissionTo('manage recruitment periods');
    }

    public function restore(User $user, RecruitmentPeriod $recruitmentPeriod): bool
    {
        return $user->hasPermissionTo('manage recruitment periods');
    }

    public function forceDelete(User $user, RecruitmentPeriod $recruitmentPeriod): bool
    {
        return $user->hasPermissionTo('manage recruitment periods');
    }
}
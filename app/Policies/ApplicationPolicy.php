<?php

namespace App\Policies;

use App\Models\Application;
use App\Models\User;

class ApplicationPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('view applications');
    }

    public function view(User $user, Application $application): bool
    {
        return $user->hasPermissionTo('view applications');
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('manage users');
    }

    public function update(User $user, Application $application): bool
    {
        return $user->hasPermissionTo('review applications');
    }

    public function delete(User $user, Application $application): bool
    {
        return $user->hasPermissionTo('delete applications');
    }

    public function restore(User $user, Application $application): bool
    {
        return $user->hasPermissionTo('delete applications');
    }

    public function forceDelete(User $user, Application $application): bool
    {
        return $user->hasPermissionTo('delete applications');
    }
}
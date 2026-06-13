<?php

namespace App\Policies;

use App\Models\Organization;
use App\Models\User;

class OrganizationPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('view organizations');
    }

    public function view(User $user, Organization $organization): bool
    {
        return $user->hasPermissionTo('view organizations');
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('manage organizations');
    }

    public function update(User $user, Organization $organization): bool
    {
        return $user->hasPermissionTo('manage organizations');
    }

    public function delete(User $user, Organization $organization): bool
    {
        return $user->hasPermissionTo('manage organizations');
    }

    public function restore(User $user, Organization $organization): bool
    {
        return $user->hasPermissionTo('manage organizations');
    }

    public function forceDelete(User $user, Organization $organization): bool
    {
        return $user->hasPermissionTo('manage organizations');
    }
}
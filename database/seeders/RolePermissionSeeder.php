<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'view users',
            'manage users',
            'view organizations',
            'manage organizations',
            'view divisions',
            'manage divisions',
            'view recruitment periods',
            'manage recruitment periods',
            'view applications',
            'create applications',
            'review applications',
            'delete applications',
        ];

        foreach ($permissions as $permission) {
            Permission::findOrCreate($permission, 'web');
        }

        $admin = Role::findOrCreate('super_admin', 'web');
        $reviewer = Role::findOrCreate('reviewer', 'web');
        $applicant = Role::findOrCreate('applicant', 'web');

        $admin->syncPermissions(Permission::all());

        $reviewer->syncPermissions([
            'view organizations',
            'view divisions',
            'view recruitment periods',
            'view applications',
            'review applications',
        ]);

        $applicant->syncPermissions([
            'view organizations',
            'view divisions',
            'view recruitment periods',
            'view applications',
            'create applications',
        ]);
    }
}

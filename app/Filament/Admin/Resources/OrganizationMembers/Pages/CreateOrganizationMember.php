<?php

namespace App\Filament\Admin\Resources\OrganizationMembers\Pages;

use App\Filament\Admin\Resources\OrganizationMembers\OrganizationMemberResource;
use Filament\Resources\Pages\CreateRecord;

class CreateOrganizationMember extends CreateRecord
{
    protected static string $resource = OrganizationMemberResource::class;
}

<?php

namespace App\Filament\Admin\Resources\OrganizationMembers\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class OrganizationMemberForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('organization_id')
                    ->label('Organisasi')
                    ->relationship('organization', 'organization_name')
                    ->required(),
                Select::make('user_id')
                    ->label('Pengguna')
                    ->relationship('user', 'full_name')
                    ->required(),
                Select::make('member_role')
                    ->options([
            'chairperson' => 'Chairperson',
            'recruitment_admin' => 'Recruitment admin',
            'interviewer' => 'Interviewer',
            'member' => 'Member',
        ])
                    ->default('member')
                    ->required(),
                DatePicker::make('joined_at')
                    ->required(),
                Toggle::make('is_active')
                    ->required(),
            ]);
    }
}

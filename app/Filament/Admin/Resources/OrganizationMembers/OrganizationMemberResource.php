<?php

namespace App\Filament\Admin\Resources\OrganizationMembers;

use App\Filament\Admin\Resources\OrganizationMembers\Pages\CreateOrganizationMember;
use App\Filament\Admin\Resources\OrganizationMembers\Pages\EditOrganizationMember;
use App\Filament\Admin\Resources\OrganizationMembers\Pages\ListOrganizationMembers;
use App\Filament\Admin\Resources\OrganizationMembers\Schemas\OrganizationMemberForm;
use App\Filament\Admin\Resources\OrganizationMembers\Tables\OrganizationMembersTable;
use App\Models\OrganizationMember;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class OrganizationMemberResource extends Resource
{
    protected static ?string $model = OrganizationMember::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-identification';

    protected static ?string $navigationLabel = 'Keanggotaan / Reviewer';
    protected static ?string $modelLabel = 'Keanggotaan';
    protected static ?string $pluralModelLabel = 'Keanggotaan';
    protected static ?int $navigationSort = 5;

    public static function canAccess(): bool
    {
        return auth()->user()?->hasRole('super_admin') ?? false;
    }

    public static function form(Schema $schema): Schema
    {
        return OrganizationMemberForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return OrganizationMembersTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListOrganizationMembers::route('/'),
            'create' => CreateOrganizationMember::route('/create'),
            'edit' => EditOrganizationMember::route('/{record}/edit'),
        ];
    }
}

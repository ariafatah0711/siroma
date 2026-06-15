<?php

namespace App\Filament\Admin\Resources\OrganizationMembers\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class OrganizationMembersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->recordActionsColumnLabel('Aksi')
            ->columns([
                TextColumn::make('organization.organization_name')
                    ->label('Organisasi')
                    ->searchable(),
                TextColumn::make('user.full_name')
                    ->label('Nama Lengkap')
                    ->searchable(),
                TextColumn::make('member_role')
                    ->badge(),
                TextColumn::make('joined_at')
                    ->date()
                    ->sortable(),
                IconColumn::make('is_active')
                    ->boolean(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}

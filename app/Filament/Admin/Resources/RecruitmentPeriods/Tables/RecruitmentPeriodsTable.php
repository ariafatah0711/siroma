<?php

namespace App\Filament\Admin\Resources\RecruitmentPeriods\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class RecruitmentPeriodsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('organization.id')
                    ->searchable(),
                TextColumn::make('created_by')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('recruitment_title')
                    ->searchable(),
                TextColumn::make('academic_year')
                    ->searchable(),
                TextColumn::make('registration_start_date')
                    ->date()
                    ->sortable(),
                TextColumn::make('registration_end_date')
                    ->date()
                    ->sortable(),
                TextColumn::make('total_quota')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('recruitment_status')
                    ->badge(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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

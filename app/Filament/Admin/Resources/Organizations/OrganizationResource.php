<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\Organizations\Pages;
use App\Models\Organization;
use Filament\Forms;
use Filament\Schemas\Schema; // Menggunakan Schema untuk v5
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use BackedEnum;

class OrganizationResource extends Resource
{
    protected static ?string $model = Organization::class;
    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-building-office';
    protected static ?string $recordTitleAttribute = 'organization_name';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Forms\Components\TextInput::make('organization_code')
                    ->required()
                    ->maxLength(50),
                Forms\Components\TextInput::make('organization_name')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('organization_code')->searchable(),
                Tables\Columns\TextColumn::make('organization_name')->searchable(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrganizations::route('/'),
            'create' => Pages\CreateOrganization::route('/create'),
            'edit' => Pages\EditOrganization::route('/{record}/edit'),
        ];
    }
}
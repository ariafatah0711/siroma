<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\Divisions\Pages;
use App\Models\Division;
use Filament\Forms;
use Filament\Schemas\Schema; // Menggunakan Schema untuk v5
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use BackedEnum;

class DivisionResource extends Resource
{
    protected static ?string $model = Division::class;
    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-rectangle-group';
    protected static ?string $recordTitleAttribute = 'division_name';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Forms\Components\Select::make('organization_id')
                    ->relationship('organization', 'organization_name')
                    ->required()
                    ->searchable()
                    ->preload(),
                Forms\Components\TextInput::make('division_name')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('organization.organization_name')->label('Organisasi')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('division_name')->label('Nama Divisi')->searchable(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDivisions::route('/'),
            'create' => Pages\CreateDivision::route('/create'),
            'edit' => Pages\EditDivision::route('/{record}/edit'),
        ];
    }
}
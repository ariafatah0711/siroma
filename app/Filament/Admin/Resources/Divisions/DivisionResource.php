<?php

namespace App\Filament\Admin\Resources\Divisions;

use App\Filament\Admin\Resources\Divisions\Pages;
use App\Models\Division;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use BackedEnum;

class DivisionResource extends Resource
{
    protected static ?string $model = Division::class;
    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-rectangle-group';
    protected static ?string $recordTitleAttribute = 'division_name';
    protected static ?string $navigationLabel = 'Divisi';
    protected static ?string $modelLabel = 'Divisi';
    protected static ?string $pluralModelLabel = 'Divisi';
    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Forms\Components\Select::make('organization_id')
                    ->label('Organisasi')
                    ->relationship('organization', 'organization_name')
                    ->required()
                    ->searchable()
                    ->preload(),
                Forms\Components\TextInput::make('division_name')
                    ->label('Nama Divisi')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('description')
                    ->label('Deskripsi')
                    ->rows(3),
                Forms\Components\Toggle::make('is_active')
                    ->label('Aktif')
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('organization.organization_name')->label('Organisasi')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('division_name')->label('Nama Divisi')->searchable(),
                Tables\Columns\IconColumn::make('is_active')->label('Aktif')->boolean(),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
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
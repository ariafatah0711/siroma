<?php

namespace App\Filament\Admin\Resources\Organizations;

use App\Filament\Admin\Resources\Organizations\Pages;
use App\Models\Organization;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use BackedEnum;

class OrganizationResource extends Resource
{
    protected static ?string $model = Organization::class;
    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-building-office';
    protected static ?string $recordTitleAttribute = 'organization_name';
    protected static ?string $navigationLabel = 'Organisasi';
    protected static ?string $modelLabel = 'Organisasi';
    protected static ?string $pluralModelLabel = 'Organisasi';
    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Forms\Components\TextInput::make('organization_code')
                    ->label('Kode Organisasi')
                    ->required()
                    ->maxLength(50),
                Forms\Components\TextInput::make('organization_name')
                    ->label('Nama Organisasi')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('contact_email')
                    ->label('Email Kontak')
                    ->email()
                    ->maxLength(255),
                Forms\Components\TextInput::make('contact_phone')
                    ->label('Telepon Kontak')
                    ->maxLength(20),
                Forms\Components\Textarea::make('description')
                    ->label('Deskripsi')
                    ->rows(4),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordActionsColumnLabel('Aksi')
            ->columns([
                Tables\Columns\TextColumn::make('organization_code')->label('Kode')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('organization_name')->label('Nama Organisasi')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('contact_email')->label('Email')->searchable(),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ]);
    }

    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        $query = parent::getEloquentQuery();
        $user = auth()->user();

        if ($user && !$user->hasRole('super_admin')) {
            $myOrgIds = $user->organizationMemberships()->where('is_active', true)->pluck('organization_id')->toArray();
            $query->whereIn('id', $myOrgIds);
        }

        return $query;
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
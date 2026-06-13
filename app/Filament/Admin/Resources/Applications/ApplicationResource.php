<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\Applications\Pages;
use App\Models\Application;
use Filament\Forms;
use Filament\Schemas\Schema; // Menggunakan Schema untuk v5
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use BackedEnum;

class ApplicationResource extends Resource
{
    protected static ?string $model = Application::class;
    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-document-check';
    protected static ?string $recordTitleAttribute = 'application_code';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Forms\Components\Section::make('Detail Pendaftaran')
                    ->schema([
                        Forms\Components\Placeholder::make('application_code')
                            ->label('Kode Aplikasi')
                            ->content(fn ($record) => $record?->application_code),
                        Forms\Components\Placeholder::make('applicant')
                            ->label('Nama Pendaftar')
                            ->content(fn ($record) => $record?->user?->full_name),
                    ])->columns(2),

                Forms\Components\Section::make('Kelola Status')
                    ->schema([
                        Forms\Components\Select::make('application_status')
                            ->label('Status Aplikasi')
                            ->options([
                                'pending' => 'Pending / Proses Seleksi',
                                'accepted' => 'Diterima',
                                'rejected' => 'Ditolak',
                            ])
                            ->required()
                            ->native(false),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('application_code')->searchable(),
                Tables\Columns\TextColumn::make('user.full_name')->label('Pendaftar')->searchable(),
                Tables\Columns\TextColumn::make('application_status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'accepted' => 'success',
                        'pending' => 'warning',
                        'rejected' => 'danger',
                        default => 'secondary',
                    }),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListApplications::route('/'),
            'view' => Pages\ViewApplication::route('/{record}'),
            'edit' => Pages\EditApplication::route('/{record}/edit'),
        ];
    }
}
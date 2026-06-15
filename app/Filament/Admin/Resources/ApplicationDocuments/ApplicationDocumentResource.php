<?php

namespace App\Filament\Admin\Resources\ApplicationDocuments;

use App\Filament\Admin\Resources\ApplicationDocuments\Pages;
use App\Models\ApplicationDocument;
use Filament\Actions\ViewAction;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use BackedEnum;

class ApplicationDocumentResource extends Resource
{
    protected static ?string $model = ApplicationDocument::class;
    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-paper-clip';
    protected static ?string $recordTitleAttribute = 'document_type';
    protected static ?string $navigationLabel = 'Berkas Pendaftar';
    protected static ?string $modelLabel = 'Berkas';
    protected static ?string $pluralModelLabel = 'Berkas Pendaftar';
    protected static ?int $navigationSort = 6;

    public static function form(Schema $schema): Schema
    {
        return $schema->components([]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('application.application_code')->label('Kode Aplikasi')->searchable(),
                Tables\Columns\TextColumn::make('application.user.full_name')->label('Nama Pendaftar')->searchable(),
                Tables\Columns\TextColumn::make('document_type')->label('Jenis Dokumen'),
                Tables\Columns\TextColumn::make('original_file_name')->label('Nama File'),
                Tables\Columns\TextColumn::make('file_path')
                    ->label('Buka Berkas')
                    ->formatStateUsing(fn (): string => 'Lihat Dokumen')
                    ->color('primary')
                    ->icon('heroicon-o-eye')
                    ->url(fn ($record) => asset('storage/' . $record->file_path))
                    ->openUrlInNewTab(),
            ])
            ->actions([
                ViewAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListApplicationDocuments::route('/'),
            'view'  => Pages\ViewApplicationDocument::route('/{record}'),
        ];
    }
}
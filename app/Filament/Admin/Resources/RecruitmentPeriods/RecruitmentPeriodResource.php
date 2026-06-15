<?php

namespace App\Filament\Admin\Resources\RecruitmentPeriods;

use App\Filament\Admin\Resources\RecruitmentPeriods\Pages;
use App\Models\RecruitmentPeriod;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use BackedEnum;

class RecruitmentPeriodResource extends Resource
{
    protected static ?string $model = RecruitmentPeriod::class;
    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-calendar-days';
    protected static ?string $recordTitleAttribute = 'recruitment_title';
    protected static ?string $navigationLabel = 'Periode Rekrutmen';
    protected static ?string $modelLabel = 'Periode Rekrutmen';
    protected static ?string $pluralModelLabel = 'Periode Rekrutmen';
    protected static ?int $navigationSort = 3;

    public static function canAccess(): bool
    {
        return auth()->user()?->hasAnyRole(['super_admin']) ?? false;
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Forms\Components\Select::make('organization_id')
                    ->label('Organisasi')
                    ->relationship('organization', 'organization_name')
                    ->required()
                    ->preload()
                    ->searchable(),
                Forms\Components\TextInput::make('recruitment_title')
                    ->label('Judul Rekrutmen')
                    ->required()
                    ->maxLength(150),
                Forms\Components\TextInput::make('academic_year')
                    ->label('Tahun Akademik')
                    ->placeholder('Contoh: 2025/2026')
                    ->maxLength(9)
                    ->required(),
                Forms\Components\Select::make('recruitment_status')
                    ->label('Status')
                    ->options([
                        'draft'     => 'Draft',
                        'open'      => 'Buka',
                        'closed'    => 'Tutup',
                        'completed' => 'Selesai',
                    ])
                    ->default('draft')
                    ->required()
                    ->native(false),
                Forms\Components\DatePicker::make('registration_start_date')
                    ->label('Tanggal Mulai Pendaftaran')
                    ->required(),
                Forms\Components\DatePicker::make('registration_end_date')
                    ->label('Tanggal Selesai Pendaftaran')
                    ->required()
                    ->after('registration_start_date'),
                Forms\Components\TextInput::make('total_quota')
                    ->label('Total Kuota')
                    ->numeric()
                    ->minValue(1)
                    ->default(1)
                    ->required(),
                Forms\Components\Textarea::make('description')
                    ->label('Deskripsi')
                    ->rows(3)
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('organization.organization_name')
                    ->label('Organisasi')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('recruitment_title')
                    ->label('Judul Rekrutmen')
                    ->searchable(),
                Tables\Columns\TextColumn::make('academic_year')
                    ->label('T.A.')
                    ->sortable(),
                Tables\Columns\TextColumn::make('recruitment_status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'open'      => 'success',
                        'draft'     => 'gray',
                        'closed'    => 'warning',
                        'completed' => 'info',
                        default     => 'secondary',
                    }),
                Tables\Columns\TextColumn::make('registration_start_date')
                    ->label('Mulai')
                    ->date('d M Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('registration_end_date')
                    ->label('Selesai')
                    ->date('d M Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('total_quota')
                    ->label('Kuota')
                    ->numeric()
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListRecruitmentPeriods::route('/'),
            'create' => Pages\CreateRecruitmentPeriod::route('/create'),
            'edit'   => Pages\EditRecruitmentPeriod::route('/{record}/edit'),
        ];
    }
}
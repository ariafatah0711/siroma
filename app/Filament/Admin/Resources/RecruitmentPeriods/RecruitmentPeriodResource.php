<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\RecruitmentPeriods\Pages;
use App\Models\RecruitmentPeriod;
use Filament\Forms;
use Filament\Schemas\Schema; // Menggunakan Schema untuk v5
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use BackedEnum;

class RecruitmentPeriodResource extends Resource
{
    protected static ?string $model = RecruitmentPeriod::class;
    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-calendar-days';
    protected static ?string $recordTitleAttribute = 'recruitment_title';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Forms\Components\Select::make('organization_id')
                    ->relationship('organization', 'organization_name')
                    ->required()
                    ->preload(),
                Forms\Components\TextInput::make('recruitment_title')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('academic_year')
                    ->placeholder('Contoh: 2025/2026')
                    ->required(),
                Forms\Components\DatePicker::make('start_date'),
                Forms\Components\DatePicker::make('end_date'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('organization.organization_name')->label('Organisasi')->sortable(),
                Tables\Columns\TextColumn::make('recruitment_title')->label('Judul Rekrutmen')->searchable(),
                Tables\Columns\TextColumn::make('academic_year')->label('Tahun Akademik'),
                Tables\Columns\TextColumn::make('start_date')->label('Mulai')->date(),
                Tables\Columns\TextColumn::make('end_date')->label('Selesai')->date(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRecruitmentPeriods::route('/'),
            'create' => Pages\CreateRecruitmentPeriod::route('/create'),
            'edit' => Pages\EditRecruitmentPeriod::route('/{record}/edit'),
        ];
    }
}
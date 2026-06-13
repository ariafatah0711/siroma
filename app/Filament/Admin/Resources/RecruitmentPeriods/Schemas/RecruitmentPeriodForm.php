<?php

namespace App\Filament\Admin\Resources\RecruitmentPeriods\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class RecruitmentPeriodForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('organization_id')
                    ->relationship('organization', 'id')
                    ->required(),
                TextInput::make('created_by')
                    ->numeric()
                    ->default(null),
                TextInput::make('recruitment_title')
                    ->required(),
                TextInput::make('academic_year')
                    ->required(),
                DatePicker::make('registration_start_date')
                    ->required(),
                DatePicker::make('registration_end_date')
                    ->required(),
                TextInput::make('total_quota')
                    ->required()
                    ->numeric()
                    ->default(1),
                Select::make('recruitment_status')
                    ->options(['draft' => 'Draft', 'open' => 'Open', 'closed' => 'Closed', 'completed' => 'Completed'])
                    ->default('draft')
                    ->required(),
                Textarea::make('description')
                    ->default(null)
                    ->columnSpanFull(),
            ]);
    }
}

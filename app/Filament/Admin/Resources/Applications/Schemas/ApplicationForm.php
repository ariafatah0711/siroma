<?php

namespace App\Filament\Admin\Resources\Applications\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class ApplicationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('application_code')
                    ->required()
                    ->default(''),
                Select::make('recruitment_period_id')
                    ->relationship('recruitmentPeriod', 'id')
                    ->required(),
                Select::make('user_id')
                    ->relationship('user', 'id')
                    ->required(),
                Textarea::make('motivation')
                    ->required()
                    ->columnSpanFull(),
                TextInput::make('final_score')
                    ->numeric()
                    ->default(null),
                Select::make('application_status')
                    ->options([
            'submitted' => 'Submitted',
            'under_review' => 'Under review',
            'accepted' => 'Accepted',
            'rejected' => 'Rejected',
            'withdrawn' => 'Withdrawn',
        ])
                    ->default('submitted')
                    ->required(),
                TextInput::make('reviewer_notes')
                    ->default(null),
                DateTimePicker::make('submitted_at')
                    ->required(),
                DateTimePicker::make('reviewed_at'),
            ]);
    }
}

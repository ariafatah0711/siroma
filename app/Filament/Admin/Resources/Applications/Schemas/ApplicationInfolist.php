<?php

namespace App\Filament\Admin\Resources\Applications\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class ApplicationInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('application_code'),
                TextEntry::make('recruitmentPeriod.id')
                    ->label('Recruitment period'),
                TextEntry::make('user.id')
                    ->label('User'),
                TextEntry::make('motivation')
                    ->columnSpanFull(),
                TextEntry::make('final_score')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('application_status')
                    ->badge(),
                TextEntry::make('reviewer_notes')
                    ->placeholder('-'),
                TextEntry::make('submitted_at')
                    ->dateTime(),
                TextEntry::make('reviewed_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime(),
            ]);
    }
}

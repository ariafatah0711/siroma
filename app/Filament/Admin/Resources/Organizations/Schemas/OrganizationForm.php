<?php

namespace App\Filament\Admin\Resources\Organizations\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class OrganizationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('organization_code')
                    ->required(),
                TextInput::make('organization_name')
                    ->required(),
                Textarea::make('description')
                    ->default(null)
                    ->columnSpanFull(),
                TextInput::make('contact_email')
                    ->email()
                    ->default(null),
                TextInput::make('contact_phone')
                    ->tel()
                    ->default(null),
            ]);
    }
}

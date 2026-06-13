<?php

namespace App\Filament\Admin\Resources\ApplicationDocuments\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ApplicationDocumentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('application_id')
                    ->relationship('application', 'id')
                    ->required(),
                Select::make('document_type')
                    ->options(['cv' => 'Cv', 'portfolio' => 'Portfolio', 'certificate' => 'Certificate', 'other' => 'Other'])
                    ->default('other')
                    ->required(),
                TextInput::make('original_file_name')
                    ->required(),
                TextInput::make('file_path')
                    ->required(),
                DateTimePicker::make('uploaded_at')
                    ->required(),
            ]);
    }
}

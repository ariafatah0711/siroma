<?php

namespace App\Filament\Admin\Resources\ApplicationDocuments\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class ApplicationDocumentInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('application.id')
                    ->label('Application'),
                TextEntry::make('document_type')
                    ->badge(),
                TextEntry::make('original_file_name'),
                TextEntry::make('file_path'),
                TextEntry::make('uploaded_at')
                    ->dateTime(),
            ]);
    }
}

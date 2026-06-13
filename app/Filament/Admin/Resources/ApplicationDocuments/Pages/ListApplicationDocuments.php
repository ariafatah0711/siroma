<?php

namespace App\Filament\Admin\Resources\ApplicationDocuments\Pages;

use App\Filament\Admin\Resources\ApplicationDocuments\ApplicationDocumentResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListApplicationDocuments extends ListRecords
{
    protected static string $resource = ApplicationDocumentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}

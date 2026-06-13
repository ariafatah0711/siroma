<?php

namespace App\Filament\Admin\Resources\ApplicationDocuments\Pages;

use App\Filament\Admin\Resources\ApplicationDocuments\ApplicationDocumentResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewApplicationDocument extends ViewRecord
{
    protected static string $resource = ApplicationDocumentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}

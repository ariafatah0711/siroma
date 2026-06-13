<?php

namespace App\Filament\Admin\Resources\ApplicationDocuments\Pages;

use App\Filament\Admin\Resources\ApplicationDocuments\ApplicationDocumentResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditApplicationDocument extends EditRecord
{
    protected static string $resource = ApplicationDocumentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}

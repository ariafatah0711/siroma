<?php

namespace App\Filament\Admin\Resources\ApplicationDocuments\Pages;

use App\Filament\Admin\Resources\ApplicationDocuments\ApplicationDocumentResource;
use Filament\Resources\Pages\CreateRecord;

class CreateApplicationDocument extends CreateRecord
{
    protected static string $resource = ApplicationDocumentResource::class;
}

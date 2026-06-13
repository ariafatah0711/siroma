<?php

namespace App\Filament\Admin\Resources\Divisions\Pages;

use App\Filament\Admin\Resources\Divisions\DivisionResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditDivision extends EditRecord
{
    protected static string $resource = DivisionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}

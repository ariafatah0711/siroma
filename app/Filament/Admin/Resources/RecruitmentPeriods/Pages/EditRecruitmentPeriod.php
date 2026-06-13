<?php

namespace App\Filament\Admin\Resources\RecruitmentPeriods\Pages;

use App\Filament\Admin\Resources\RecruitmentPeriods\RecruitmentPeriodResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditRecruitmentPeriod extends EditRecord
{
    protected static string $resource = RecruitmentPeriodResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}

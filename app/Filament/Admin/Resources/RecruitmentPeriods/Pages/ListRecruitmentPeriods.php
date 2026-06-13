<?php

namespace App\Filament\Admin\Resources\RecruitmentPeriods\Pages;

use App\Filament\Admin\Resources\RecruitmentPeriods\RecruitmentPeriodResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListRecruitmentPeriods extends ListRecords
{
    protected static string $resource = RecruitmentPeriodResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}

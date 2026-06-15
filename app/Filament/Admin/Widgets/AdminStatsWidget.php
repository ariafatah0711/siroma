<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Application;
use App\Models\Organization;
use App\Models\RecruitmentPeriod;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class AdminStatsWidget extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $pendingCount     = Application::where('application_status', 'submitted')->count();
        $reviewingCount   = Application::where('application_status', 'under_review')->count();
        $acceptedCount    = Application::where('application_status', 'accepted')->count();
        $rejectedCount    = Application::where('application_status', 'rejected')->count();
        $activeRecruitments = RecruitmentPeriod::where('recruitment_status', 'open')->count();
        $totalOrgs        = Organization::count();

        return [
            Stat::make('Pendaftaran Menunggu', $pendingCount)
                ->description('Belum diproses')
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning'),

            Stat::make('Sedang Diseleksi', $reviewingCount)
                ->description('Dalam proses review')
                ->descriptionIcon('heroicon-m-magnifying-glass')
                ->color('info'),

            Stat::make('Diterima', $acceptedCount)
                ->description('Total pendaftar diterima')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success'),

            Stat::make('Ditolak', $rejectedCount)
                ->description('Total pendaftar ditolak')
                ->descriptionIcon('heroicon-m-x-circle')
                ->color('danger'),

            Stat::make('Rekrutmen Aktif', $activeRecruitments)
                ->description('Periode rekrutmen buka')
                ->descriptionIcon('heroicon-m-calendar-days')
                ->color('primary'),

            Stat::make('Total Organisasi', $totalOrgs)
                ->description('Terdaftar di sistem')
                ->descriptionIcon('heroicon-m-building-office')
                ->color('gray'),
        ];
    }
}

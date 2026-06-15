<?php

namespace App\Filament\Admin\Resources\Applications\Pages;

use App\Filament\Admin\Resources\Applications\ApplicationResource;
use App\Models\Application;
use Filament\Actions\Action;
use Filament\Forms;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Fieldset;
use Illuminate\Support\Facades\DB;

class ViewApplication extends ViewRecord
{
    protected static string $resource = ApplicationResource::class;

    protected function getHeaderActions(): array
    {
        /** @var Application $record */
        $record = $this->record;

        $actions = [];

        if ($record->application_status === 'submitted') {
            $actions[] = Action::make('mulai_seleksi')
                ->label('Mulai Seleksi')
                ->icon('heroicon-o-magnifying-glass')
                ->color('info')
                ->requiresConfirmation()
                ->modalHeading('Mulai Seleksi Pendaftar?')
                ->modalSubmitActionLabel('Ya, Mulai Seleksi')
                ->action(function (): void {
                    try {
                        DB::statement('CALL sp_update_application_status(?, ?, ?, ?)', [
                            $this->record->id, 'under_review', null, 'Seleksi dimulai oleh reviewer.',
                        ]);
                        $this->record->refresh();
                        Notification::make()->title('Status diubah ke "Sedang Diseleksi"')->success()->send();
                    } catch (\Exception $e) {
                        Notification::make()->title('Gagal')->body($e->getMessage())->danger()->send();
                    }
                });
        }

        if ($record->application_status === 'under_review') {
            $actions[] = Action::make('terima')
                ->label('Terima')
                ->icon('heroicon-o-check-circle')
                ->color('success')
                ->form([
                    Forms\Components\TextInput::make('final_score')
                        ->label('Nilai Akhir (0–100)')
                        ->numeric()->minValue(0)->maxValue(100)->required()->step(0.01),
                    Forms\Components\Textarea::make('reviewer_notes')
                        ->label('Catatan (opsional)')->rows(3)->maxLength(500),
                ])
                ->modalHeading('Terima Pendaftar')
                ->modalSubmitActionLabel('Konfirmasi Terima')
                ->action(function (array $data): void {
                    try {
                        DB::statement('CALL sp_update_application_status(?, ?, ?, ?)', [
                            $this->record->id, 'accepted', $data['final_score'], $data['reviewer_notes'] ?? null,
                        ]);
                        $this->record->refresh();
                        Notification::make()->title('Pendaftar DITERIMA')->success()->send();
                    } catch (\Exception $e) {
                        Notification::make()->title('Gagal')->body($e->getMessage())->danger()->send();
                    }
                });

            $actions[] = Action::make('tolak')
                ->label('Tolak')
                ->icon('heroicon-o-x-circle')
                ->color('danger')
                ->form([
                    Forms\Components\TextInput::make('final_score')
                        ->label('Nilai Akhir (0–100)')
                        ->numeric()->minValue(0)->maxValue(100)->required()->step(0.01),
                    Forms\Components\Textarea::make('reviewer_notes')
                        ->label('Alasan Penolakan')->rows(3)->maxLength(500)->required(),
                ])
                ->modalHeading('Tolak Pendaftar')
                ->modalSubmitActionLabel('Konfirmasi Tolak')
                ->action(function (array $data): void {
                    try {
                        DB::statement('CALL sp_update_application_status(?, ?, ?, ?)', [
                            $this->record->id, 'rejected', $data['final_score'], $data['reviewer_notes'],
                        ]);
                        $this->record->refresh();
                        Notification::make()->title('Pendaftar DITOLAK')->warning()->send();
                    } catch (\Exception $e) {
                        Notification::make()->title('Gagal')->body($e->getMessage())->danger()->send();
                    }
                });
        }

        return $actions;
    }

    public function infolist(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Informasi Pendaftar')
                ->schema([
                    Forms\Components\Placeholder::make('application_code')
                        ->label('Kode Aplikasi')
                        ->content(fn ($record) => $record?->application_code),
                    Forms\Components\Placeholder::make('applicant')
                        ->label('Nama Pendaftar')
                        ->content(fn ($record) => $record?->user?->full_name),
                    Forms\Components\Placeholder::make('student_number')
                        ->label('NIM')
                        ->content(fn ($record) => $record?->user?->student_number),
                    Forms\Components\Placeholder::make('study_program')
                        ->label('Program Studi')
                        ->content(fn ($record) => $record?->user?->study_program),
                    Forms\Components\Placeholder::make('organization')
                        ->label('Organisasi')
                        ->content(fn ($record) => $record?->recruitmentPeriod?->organization?->organization_name),
                    Forms\Components\Placeholder::make('recruitment_title')
                        ->label('Periode Rekrutmen')
                        ->content(fn ($record) => $record?->recruitmentPeriod?->recruitment_title),
                ])->columns(3),

            Section::make('Pilihan Divisi')
                ->schema([
                    Forms\Components\Placeholder::make('division_1')
                        ->label('Pilihan Divisi 1')
                        ->content(fn ($record) => $record?->preferences
                            ?->where('preference_order', 1)->first()
                            ?->division?->division_name ?? '-'),
                    Forms\Components\Placeholder::make('division_2')
                        ->label('Pilihan Divisi 2')
                        ->content(fn ($record) => $record?->preferences
                            ?->where('preference_order', 2)->first()
                            ?->division?->division_name ?? '-'),
                ])->columns(2),

            Section::make('Motivasi')
                ->schema([
                    Forms\Components\Placeholder::make('motivation')
                        ->label('')
                        ->content(fn ($record) => $record?->motivation)
                        ->columnSpanFull(),
                ]),

            Section::make('Status & Penilaian')
                ->schema([
                    Forms\Components\Placeholder::make('application_status')
                        ->label('Status')
                        ->content(fn ($record) => match ($record?->application_status) {
                            'submitted'    => 'Menunggu Seleksi',
                            'under_review' => 'Sedang Diseleksi',
                            'accepted'     => 'Diterima ✓',
                            'rejected'     => 'Ditolak ✗',
                            'withdrawn'    => 'Mengundurkan Diri',
                            default        => $record?->application_status,
                        }),
                    Forms\Components\Placeholder::make('final_score')
                        ->label('Nilai Akhir')
                        ->content(fn ($record) => $record?->final_score ?? '-'),
                    Forms\Components\Placeholder::make('reviewer_notes')
                        ->label('Catatan Reviewer')
                        ->content(fn ($record) => $record?->reviewer_notes ?? '-')
                        ->columnSpanFull(),
                    Forms\Components\Placeholder::make('submitted_at')
                        ->label('Tanggal Daftar')
                        ->content(fn ($record) => $record?->submitted_at?->format('d M Y H:i')),
                    Forms\Components\Placeholder::make('reviewed_at')
                        ->label('Tanggal Review')
                        ->content(fn ($record) => $record?->reviewed_at?->format('d M Y H:i') ?? '-'),
                ])->columns(2),

            Section::make('Riwayat Status')
                ->schema([
                    Forms\Components\Placeholder::make('status_history')
                        ->label('')
                        ->content(function ($record) {
                            if (!$record) return '-';
                            $histories = $record->statusHistory()->orderBy('changed_at')->get();
                            if ($histories->isEmpty()) return 'Belum ada riwayat.';
                            return $histories->map(fn ($h) =>
                                '[' . ($h->changed_at?->format('d/m/Y H:i') ?? '-') . '] ' .
                                ($h->old_status ?? '(awal)') . ' → ' . $h->new_status .
                                ($h->change_note ? " ({$h->change_note})" : '')
                            )->implode("\n");
                        })
                        ->columnSpanFull(),
                ]),

            Section::make('Berkas yang Diunggah')
                ->schema([
                    Forms\Components\Placeholder::make('documents')
                        ->label('')
                        ->content(function ($record) {
                            if (!$record) return '-';
                            $docs = $record->documents;
                            if ($docs->isEmpty()) return 'Belum ada berkas yang diunggah.';
                            return $docs->map(fn ($d) =>
                                "[{$d->document_type}] {$d->original_file_name}"
                            )->implode("\n");
                        })
                        ->columnSpanFull(),
                ]),
        ]);
    }
}

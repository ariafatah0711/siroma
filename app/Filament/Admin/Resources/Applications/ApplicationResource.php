<?php

namespace App\Filament\Admin\Resources\Applications;

use App\Filament\Admin\Resources\Applications\Pages;
use App\Models\Application;
use Filament\Actions\Action;
use Filament\Actions\ViewAction;
use Filament\Forms;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\DB;
use BackedEnum;

class ApplicationResource extends Resource
{

    protected static ?string $model = Application::class;
    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-document-check';
    protected static ?string $recordTitleAttribute = 'application_code';
    protected static ?string $navigationLabel = 'Pendaftaran';
    protected static ?string $modelLabel = 'Pendaftaran';
    protected static ?string $pluralModelLabel = 'Pendaftaran';
    protected static ?int $navigationSort = 4;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Forms\Components\Section::make('Detail Pendaftar')
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
                    ])->columns(2),

                Forms\Components\Section::make('Pilihan Divisi')
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

                Forms\Components\Section::make('Motivasi')
                    ->schema([
                        Forms\Components\Placeholder::make('motivation')
                            ->label('')
                            ->content(fn ($record) => $record?->motivation),
                    ]),

                Forms\Components\Section::make('Status & Penilaian')
                    ->schema([
                        Forms\Components\Placeholder::make('application_status')
                            ->label('Status Saat Ini')
                            ->content(fn ($record) => match ($record?->application_status) {
                                'submitted'    => '⏳ Menunggu Seleksi',
                                'under_review' => '🔍 Sedang Diseleksi',
                                'accepted'     => '✅ Diterima',
                                'rejected'     => '❌ Ditolak',
                                'withdrawn'    => '↩️ Mengundurkan Diri',
                                default        => $record?->application_status,
                            }),
                        Forms\Components\Placeholder::make('final_score')
                            ->label('Nilai Akhir')
                            ->content(fn ($record) => $record?->final_score ?? '-'),
                        Forms\Components\Placeholder::make('reviewer_notes')
                            ->label('Catatan Reviewer')
                            ->content(fn ($record) => $record?->reviewer_notes ?? '-'),
                        Forms\Components\Placeholder::make('reviewed_at')
                            ->label('Waktu Review')
                            ->content(fn ($record) => $record?->reviewed_at?->format('d M Y H:i') ?? '-'),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('application_code')
                    ->label('Kode')
                    ->searchable()
                    ->copyable()
                    ->fontFamily('mono'),
                Tables\Columns\TextColumn::make('user.full_name')
                    ->label('Pendaftar')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.study_program')
                    ->label('Prodi')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('recruitmentPeriod.organization.organization_name')
                    ->label('Organisasi')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('divisi_pilihan')
                    ->label('Pilihan Divisi')
                    ->getStateUsing(function (Application $record): string {
                        $prefs = $record->preferences->sortBy('preference_order');
                        return $prefs->map(fn ($p) => $p->preference_order . '. ' . ($p->division?->division_name ?? '?'))
                            ->implode(' / ');
                    })
                    ->wrap(),
                Tables\Columns\TextColumn::make('application_status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'accepted'     => 'success',
                        'under_review' => 'info',
                        'submitted'    => 'warning',
                        'rejected'     => 'danger',
                        'withdrawn'    => 'gray',
                        default        => 'secondary',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'submitted'    => 'Menunggu',
                        'under_review' => 'Diseleksi',
                        'accepted'     => 'Diterima',
                        'rejected'     => 'Ditolak',
                        'withdrawn'    => 'Mundur',
                        default        => $state,
                    }),
                Tables\Columns\TextColumn::make('final_score')
                    ->label('Nilai')
                    ->sortable()
                    ->numeric(decimalPlaces: 2)
                    ->placeholder('-'),
                Tables\Columns\TextColumn::make('submitted_at')
                    ->label('Tgl Daftar')
                    ->date('d M Y')
                    ->sortable(),
            ])
            ->defaultSort('submitted_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('application_status')
                    ->label('Status')
                    ->options([
                        'submitted'    => 'Menunggu Seleksi',
                        'under_review' => 'Sedang Diseleksi',
                        'accepted'     => 'Diterima',
                        'rejected'     => 'Ditolak',
                        'withdrawn'    => 'Mengundurkan Diri',
                    ]),
                Tables\Filters\SelectFilter::make('recruitment_period_id')
                    ->label('Periode Rekrutmen')
                    ->relationship('recruitmentPeriod', 'recruitment_title'),
            ])
            ->actions([
                // Tombol lihat detail
                ViewAction::make()->label('Detail'),

                // Action: Mulai Seleksi (submitted → under_review)
                Action::make('mulai_seleksi')
                    ->label('Mulai Seleksi')
                    ->icon('heroicon-o-magnifying-glass')
                    ->color('info')
                    ->visible(fn (Application $record) => $record->application_status === 'submitted')
                    ->requiresConfirmation()
                    ->modalHeading('Mulai Seleksi Pendaftar?')
                    ->modalDescription(fn (Application $record) => "Pendaftar: {$record->user?->full_name} ({$record->application_code}) akan ditandai sedang diseleksi.")
                    ->modalSubmitActionLabel('Ya, Mulai Seleksi')
                    ->action(function (Application $record): void {
                        try {
                            DB::statement('CALL sp_update_application_status(?, ?, ?, ?)', [
                                $record->id,
                                'under_review',
                                null,
                                'Seleksi dimulai oleh reviewer.',
                            ]);
                            Notification::make()
                                ->title('Status berhasil diubah ke "Sedang Diseleksi"')
                                ->success()
                                ->send();
                        } catch (\Exception $e) {
                            Notification::make()
                                ->title('Gagal mengubah status')
                                ->body($e->getMessage())
                                ->danger()
                                ->send();
                        }
                    }),

                // Action: Terima (under_review → accepted)
                Action::make('terima')
                    ->label('Terima')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->visible(fn (Application $record) => $record->application_status === 'under_review')
                    ->form([
                        Forms\Components\TextInput::make('final_score')
                            ->label('Nilai Akhir (0–100)')
                            ->numeric()
                            ->minValue(0)
                            ->maxValue(100)
                            ->required()
                            ->step(0.01),
                        Forms\Components\Textarea::make('reviewer_notes')
                            ->label('Catatan (opsional)')
                            ->rows(3)
                            ->maxLength(500),
                    ])
                    ->modalHeading('Terima Pendaftar')
                    ->modalSubmitActionLabel('Konfirmasi Terima')
                    ->action(function (Application $record, array $data): void {
                        try {
                            DB::statement('CALL sp_update_application_status(?, ?, ?, ?)', [
                                $record->id,
                                'accepted',
                                $data['final_score'],
                                $data['reviewer_notes'] ?? null,
                            ]);
                            Notification::make()
                                ->title('Pendaftar berhasil DITERIMA')
                                ->success()
                                ->send();
                        } catch (\Exception $e) {
                            Notification::make()
                                ->title('Gagal menerima pendaftar')
                                ->body($e->getMessage())
                                ->danger()
                                ->send();
                        }
                    }),

                // Action: Tolak (under_review → rejected)
                Action::make('tolak')
                    ->label('Tolak')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->visible(fn (Application $record) => $record->application_status === 'under_review')
                    ->form([
                        Forms\Components\TextInput::make('final_score')
                            ->label('Nilai Akhir (0–100)')
                            ->numeric()
                            ->minValue(0)
                            ->maxValue(100)
                            ->required()
                            ->step(0.01),
                        Forms\Components\Textarea::make('reviewer_notes')
                            ->label('Alasan Penolakan')
                            ->rows(3)
                            ->maxLength(500)
                            ->required(),
                    ])
                    ->modalHeading('Tolak Pendaftar')
                    ->modalSubmitActionLabel('Konfirmasi Tolak')
                    ->action(function (Application $record, array $data): void {
                        try {
                            DB::statement('CALL sp_update_application_status(?, ?, ?, ?)', [
                                $record->id,
                                'rejected',
                                $data['final_score'],
                                $data['reviewer_notes'],
                            ]);
                            Notification::make()
                                ->title('Pendaftar DITOLAK')
                                ->warning()
                                ->send();
                        } catch (\Exception $e) {
                            Notification::make()
                                ->title('Gagal menolak pendaftar')
                                ->body($e->getMessage())
                                ->danger()
                                ->send();
                        }
                    }),

                // Action: Hapus (hanya submitted/withdrawn, via SP)
                Action::make('hapus')
                    ->label('Hapus')
                    ->icon('heroicon-o-trash')
                    ->color('gray')
                    ->visible(fn (Application $record) => in_array($record->application_status, ['submitted', 'withdrawn'])
                        && auth()->user()?->hasRole('super_admin'))
                    ->requiresConfirmation()
                    ->modalHeading('Hapus Pendaftaran?')
                    ->modalDescription('Pendaftaran yang dihapus tidak dapat dikembalikan. Hanya bisa menghapus yang berstatus "Menunggu" atau "Mundur".')
                    ->form([
                        Forms\Components\Textarea::make('delete_reason')
                            ->label('Alasan Penghapusan')
                            ->rows(2)
                            ->maxLength(500),
                    ])
                    ->action(function (Application $record, array $data): void {
                        try {
                            DB::statement('CALL sp_delete_application(?, ?)', [
                                $record->id,
                                $data['delete_reason'] ?? null,
                            ]);
                            Notification::make()
                                ->title('Pendaftaran berhasil dihapus')
                                ->success()
                                ->send();
                        } catch (\Exception $e) {
                            Notification::make()
                                ->title('Gagal menghapus')
                                ->body($e->getMessage())
                                ->danger()
                                ->send();
                        }
                    }),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListApplications::route('/'),
            'view'  => Pages\ViewApplication::route('/{record}'),
        ];
    }
}
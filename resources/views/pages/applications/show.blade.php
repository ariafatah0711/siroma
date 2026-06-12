@extends('layouts.public', ['title' => 'Status Pendaftaran '.$application->application_code.' - SIROMA'])

@section('content')
    <x-comic-panel class="p-6 md:p-8">
        <p class="burst-label mb-5">{{ $application->application_code }}</p>
        <h1 class="text-4xl font-black md:text-6xl">Status Pendaftaran</h1>
        <p class="mt-4 text-lg text-neutral-700">{{ $application->user->full_name }} - {{ $application->recruitmentPeriod->recruitment_title }}</p>
    </x-comic-panel>

    <div class="mt-8 grid gap-4 md:grid-cols-3">
        <div class="comic-panel-soft p-4"><b>Status</b><br><x-status-badge :status="$application->application_status" class="mt-2" /></div>
        <x-stat-card label="Nilai Akhir" :value="$application->final_score ?? '-'" />
        <div class="comic-panel-soft p-4"><b>Dikirim</b><br>{{ $application->submitted_at->translatedFormat('d M Y H:i') }}</div>
    </div>

    <section class="mt-10">
        <x-section-heading title="Pilihan Divisi" class="text-center" />
        <ol class="mt-4 grid gap-3">
            @foreach ($application->preferences as $preference)
                <li class="comic-panel-soft p-4">{{ $preference->preference_order }}. {{ $preference->division->division_name }}</li>
            @endforeach
        </ol>
    </section>

    <section class="mt-10">
        <x-section-heading title="Dokumen" class="text-center" />
        <div class="mt-4 grid gap-3">
            @forelse ($application->documents as $document)
                <a href="{{ asset('storage/'.$document->file_path) }}" target="_blank" class="comic-panel-soft block p-4 hover:bg-neutral-100">
                    <span class="font-black uppercase">{{ $document->document_type }}</span>
                    <span class="ml-2 text-sm text-neutral-700">{{ $document->original_file_name }}</span>
                </a>
            @empty
                <p class="comic-panel-soft p-4 text-sm font-semibold text-neutral-700">Belum ada dokumen yang tercatat.</p>
            @endforelse
        </div>
    </section>

    <section class="mt-10">
        <x-section-heading title="Riwayat Status" class="text-center" />
        <ol class="mt-4 grid gap-3">
            @foreach ($application->statusHistory as $history)
                <li class="comic-panel-soft p-4">
                    <b>{{ $history->new_status }}</b>
                    <p class="text-sm text-neutral-700">{{ $history->change_note }}</p>
                    <p class="mt-1 text-xs">{{ $history->changed_at->translatedFormat('d M Y H:i') }}</p>
                </li>
            @endforeach
        </ol>
    </section>
@endsection

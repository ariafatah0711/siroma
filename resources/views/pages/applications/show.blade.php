@extends('layouts.public', ['title' => 'Status Pendaftaran '.$application->application_code.' - SIROMA'])

@section('content')
    <p class="font-mono text-sm">{{ $application->application_code }}</p>
    <h1 class="text-4xl font-black">Status Pendaftaran</h1>
    <p class="mt-2 text-neutral-700">{{ $application->user->full_name }} - {{ $application->recruitmentPeriod->recruitment_title }}</p>

    <div class="mt-8 grid gap-4 md:grid-cols-3">
        <div class="border-2 border-neutral-950 p-4"><b>Status</b><br>{{ $application->application_status }}</div>
        <div class="border-2 border-neutral-950 p-4"><b>Nilai Akhir</b><br>{{ $application->final_score ?? '-' }}</div>
        <div class="border-2 border-neutral-950 p-4"><b>Dikirim</b><br>{{ $application->submitted_at->translatedFormat('d M Y H:i') }}</div>
    </div>

    <section class="mt-10">
        <h2 class="text-2xl font-black">Pilihan Divisi</h2>
        <ol class="mt-4 grid gap-3">
            @foreach ($application->preferences as $preference)
                <li class="border-2 border-neutral-950 p-4">{{ $preference->preference_order }}. {{ $preference->division->division_name }}</li>
            @endforeach
        </ol>
    </section>

    <section class="mt-10">
        <h2 class="text-2xl font-black">Riwayat Status</h2>
        <ol class="mt-4 grid gap-3">
            @foreach ($application->statusHistory as $history)
                <li class="border-2 border-neutral-950 p-4">
                    <b>{{ $history->new_status }}</b>
                    <p class="text-sm text-neutral-700">{{ $history->change_note }}</p>
                    <p class="mt-1 text-xs">{{ $history->changed_at->translatedFormat('d M Y H:i') }}</p>
                </li>
            @endforeach
        </ol>
    </section>
@endsection

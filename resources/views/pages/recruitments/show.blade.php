@extends('layouts.public', ['title' => $period->recruitment_title.' - SIROMA'])

@section('content')
    <x-comic-panel class="relative overflow-hidden p-6 md:p-8">
        <div class="speed-lines absolute inset-0 opacity-20"></div>
        <div class="relative max-w-4xl">
            <p class="burst-label mb-5">{{ $period->organization->organization_name }}</p>
            <h1 class="text-4xl font-black leading-tight md:text-6xl">{{ $period->recruitment_title }}</h1>
            <p class="mt-4 max-w-3xl text-lg leading-8 text-neutral-700">{{ $period->description }}</p>
            <div class="mt-5"><x-status-badge :status="$period->recruitment_status" /></div>
        </div>
    </x-comic-panel>

    <div class="mt-8 grid gap-4 md:grid-cols-4">
        <x-stat-card label="Tahun" :value="$period->academic_year" />
        <x-stat-card label="Buka" :value="$period->registration_start_date->translatedFormat('d M')" />
        <x-stat-card label="Tutup" :value="$period->registration_end_date->translatedFormat('d M')" />
        <x-stat-card label="Kuota" :value="$period->total_quota" />
    </div>

    <section class="mt-10">
        <x-section-heading title="Divisi Tersedia" description="Pilih prioritas divisi pertama dan, kalau perlu, pilihan kedua saat mengirim pendaftaran." />
        <div class="mt-4 grid gap-4 md:grid-cols-2">
            @foreach ($period->organization->divisions as $division)
                <article class="comic-panel-soft p-4">
                    <h3 class="font-black">{{ $division->division_name }}</h3>
                    <p class="mt-2 text-sm text-neutral-700">{{ $division->description }}</p>
                </article>
            @endforeach
        </div>
    </section>

    @if ($period->recruitment_status === 'open')
        <x-ink-button :href="route('recruitments.apply', $period)" class="mt-8">Daftar Sekarang</x-ink-button>
    @endif
@endsection

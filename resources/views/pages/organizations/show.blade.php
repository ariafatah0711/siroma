@extends('layouts.public', ['title' => $organization->organization_name.' - SIROMA'])

@section('content')
    <x-comic-panel class="relative overflow-hidden p-6 md:p-8">
        <div class="screentone absolute inset-y-0 right-0 w-1/3 opacity-40"></div>
        <div class="relative max-w-3xl">
            <p class="burst-label mb-5">{{ $organization->organization_code }}</p>
            <h1 class="text-4xl font-black leading-tight md:text-6xl">{{ $organization->organization_name }}</h1>
            <p class="mt-4 text-lg leading-8 text-neutral-700">{{ $organization->description }}</p>
        </div>
    </x-comic-panel>

    <section class="mt-10">
        <x-section-heading title="Divisi" description="Setiap divisi punya fokus kerja yang berbeda. Pilih yang paling sesuai saat daftar rekrutmen." />
        <div class="mt-4 grid gap-4 md:grid-cols-2">
            @foreach ($organization->divisions as $division)
                <article class="comic-panel-soft p-4">
                    <h3 class="font-black">{{ $division->division_name }}</h3>
                    <p class="mt-2 text-sm text-neutral-700">{{ $division->description }}</p>
                </article>
            @endforeach
        </div>
    </section>

    <section class="mt-10">
        <x-section-heading title="Periode Rekrutmen" />
        <div class="mt-4 grid gap-4">
            @foreach ($organization->recruitmentPeriods as $period)
                <a href="{{ route('recruitments.show', $period) }}" class="comic-panel-soft block p-4 hover:bg-neutral-100">
                    <span class="font-black">{{ $period->recruitment_title }}</span>
                    <x-status-badge :status="$period->recruitment_status" class="ml-2" />
                </a>
            @endforeach
        </div>
    </section>
@endsection

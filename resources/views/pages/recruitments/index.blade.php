@extends('layouts.public', ['title' => 'Rekrutmen - SIROMA'])

@section('content')
    <h1 class="text-4xl font-black">Rekrutmen</h1>

    <form method="GET" class="mt-6 flex flex-wrap gap-3">
        <select name="organization" class="border-2 border-neutral-950 px-3 py-2">
            <option value="">Semua organisasi</option>
            @foreach ($organizations as $organization)
                <option value="{{ $organization->id }}" @selected($selectedOrganization === $organization->id)>
                    {{ $organization->organization_name }}
                </option>
            @endforeach
        </select>
        <button class="border-2 border-neutral-950 bg-neutral-950 px-4 py-2 font-bold text-white">Filter</button>
        <a href="{{ route('recruitments.index') }}" class="border-2 border-neutral-950 px-4 py-2 font-bold">Reset</a>
    </form>

    <div class="mt-8 grid gap-4 md:grid-cols-2">
        @foreach ($recruitments as $period)
            <article class="border-2 border-neutral-950 p-5">
                <p class="text-sm font-bold uppercase">{{ $period->organization->organization_name }}</p>
                <h2 class="mt-1 text-2xl font-black">{{ $period->recruitment_title }}</h2>
                <p class="mt-2 text-sm text-neutral-700">{{ $period->registration_start_date->translatedFormat('d M Y') }} - {{ $period->registration_end_date->translatedFormat('d M Y') }}</p>
                <p class="mt-2 text-sm font-semibold">{{ $period->applications_count }} pendaftar / kuota {{ $period->total_quota }}</p>
                <p class="mt-4 inline-block border-2 border-neutral-950 px-2 py-1 text-xs font-black uppercase">{{ $period->recruitment_status }}</p>
                <a href="{{ route('recruitments.show', $period) }}" class="ml-3 font-bold underline">Detail</a>
            </article>
        @endforeach
    </div>
@endsection

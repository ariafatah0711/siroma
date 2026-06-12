@extends('layouts.public', ['title' => $organization->organization_name.' - SIROMA'])

@section('content')
    <p class="font-mono text-sm">{{ $organization->organization_code }}</p>
    <h1 class="text-4xl font-black">{{ $organization->organization_name }}</h1>
    <p class="mt-3 max-w-3xl text-neutral-700">{{ $organization->description }}</p>

    <section class="mt-10">
        <h2 class="text-2xl font-black">Divisi</h2>
        <div class="mt-4 grid gap-4 md:grid-cols-2">
            @foreach ($organization->divisions as $division)
                <article class="border-2 border-neutral-950 p-4">
                    <h3 class="font-black">{{ $division->division_name }}</h3>
                    <p class="mt-2 text-sm text-neutral-700">{{ $division->description }}</p>
                </article>
            @endforeach
        </div>
    </section>

    <section class="mt-10">
        <h2 class="text-2xl font-black">Periode Rekrutmen</h2>
        <div class="mt-4 grid gap-4">
            @foreach ($organization->recruitmentPeriods as $period)
                <a href="{{ route('recruitments.show', $period) }}" class="block border-2 border-neutral-950 p-4 hover:bg-neutral-100">
                    <span class="font-black">{{ $period->recruitment_title }}</span>
                    <span class="ml-2 text-sm uppercase">{{ $period->recruitment_status }}</span>
                </a>
            @endforeach
        </div>
    </section>
@endsection

@extends('layouts.public', ['title' => 'Organisasi - SIROMA'])

@section('content')
    <h1 class="text-4xl font-black">Organisasi</h1>
    <div class="mt-8 grid gap-4 md:grid-cols-2">
        @foreach ($organizations as $organization)
            <article class="border-2 border-neutral-950 p-5">
                <p class="font-mono text-sm">{{ $organization->organization_code }}</p>
                <h2 class="mt-1 text-2xl font-black">{{ $organization->organization_name }}</h2>
                <p class="mt-2 text-neutral-700">{{ $organization->description }}</p>
                <p class="mt-4 text-sm font-semibold">{{ $organization->divisions_count }} divisi, {{ $organization->recruitment_periods_count }} periode rekrutmen</p>
                <a href="{{ route('organizations.show', $organization) }}" class="mt-4 inline-block font-bold underline">Detail</a>
            </article>
        @endforeach
    </div>
@endsection

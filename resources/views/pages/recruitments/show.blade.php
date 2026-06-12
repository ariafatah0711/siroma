@extends('layouts.public', ['title' => $period->recruitment_title.' - SIROMA'])

@section('content')
    <p class="text-sm font-bold uppercase">{{ $period->organization->organization_name }}</p>
    <h1 class="mt-1 text-4xl font-black">{{ $period->recruitment_title }}</h1>
    <p class="mt-3 max-w-3xl text-neutral-700">{{ $period->description }}</p>

    <div class="mt-8 grid gap-4 md:grid-cols-4">
        <div class="border-2 border-neutral-950 p-4"><b>Tahun</b><br>{{ $period->academic_year }}</div>
        <div class="border-2 border-neutral-950 p-4"><b>Buka</b><br>{{ $period->registration_start_date->translatedFormat('d M Y') }}</div>
        <div class="border-2 border-neutral-950 p-4"><b>Tutup</b><br>{{ $period->registration_end_date->translatedFormat('d M Y') }}</div>
        <div class="border-2 border-neutral-950 p-4"><b>Kuota</b><br>{{ $period->total_quota }}</div>
    </div>

    <section class="mt-10">
        <h2 class="text-2xl font-black">Divisi Tersedia</h2>
        <div class="mt-4 grid gap-4 md:grid-cols-2">
            @foreach ($period->organization->divisions as $division)
                <article class="border-2 border-neutral-950 p-4">
                    <h3 class="font-black">{{ $division->division_name }}</h3>
                    <p class="mt-2 text-sm text-neutral-700">{{ $division->description }}</p>
                </article>
            @endforeach
        </div>
    </section>

    @if ($period->recruitment_status === 'open')
        <a href="{{ route('recruitments.apply', $period) }}" class="mt-8 inline-block border-2 border-neutral-950 bg-neutral-950 px-5 py-3 font-bold text-white">Daftar Sekarang</a>
    @endif
@endsection

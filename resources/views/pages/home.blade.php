@extends('layouts.public', ['title' => 'SIROMA - Rekrutmen Organisasi Mahasiswa'])

@section('content')
    <section class="grid gap-8 lg:grid-cols-[1.2fr_0.8fr] lg:items-center">
        <div>
            <p class="mb-3 inline-block border-2 border-neutral-950 px-3 py-1 text-sm font-bold">OPEN RECRUITMENT</p>
            <h1 class="text-4xl font-black leading-tight md:text-6xl">Temukan organisasi kampus dan daftar rekrutmen dengan rapi.</h1>
            <p class="mt-4 max-w-2xl text-lg text-neutral-700">SIROMA membantu mahasiswa melihat periode rekrutmen, memilih divisi, mengirim pendaftaran, dan memantau status seleksi.</p>
            <div class="mt-6 flex flex-wrap gap-3">
                <a href="{{ route('recruitments.index') }}" class="border-2 border-neutral-950 bg-neutral-950 px-5 py-3 font-bold text-white">Lihat Rekrutmen</a>
                <a href="{{ route('organizations.index') }}" class="border-2 border-neutral-950 px-5 py-3 font-bold">Lihat Organisasi</a>
            </div>
        </div>
        <div class="border-4 border-neutral-950 p-6 shadow-[8px_8px_0_#111]">
            <h2 class="text-2xl font-black">Statistik</h2>
            <dl class="mt-4 grid grid-cols-2 gap-4">
                @foreach ($stats as $label => $value)
                    <div class="border-2 border-neutral-950 p-4">
                        <dt class="text-xs uppercase tracking-wide text-neutral-600">{{ str($label)->headline() }}</dt>
                        <dd class="text-3xl font-black">{{ $value }}</dd>
                    </div>
                @endforeach
            </dl>
        </div>
    </section>

    <section class="mt-16">
        <h2 class="text-3xl font-black">Rekrutmen Aktif</h2>
        <div class="mt-6 grid gap-4 md:grid-cols-3">
            @forelse ($activeRecruitments as $period)
                <article class="border-2 border-neutral-950 p-5">
                    <p class="text-sm font-bold uppercase">{{ $period->organization->organization_name }}</p>
                    <h3 class="mt-2 text-xl font-black">{{ $period->recruitment_title }}</h3>
                    <p class="mt-2 text-sm text-neutral-700">Tutup {{ $period->registration_end_date->translatedFormat('d M Y') }}</p>
                    <a href="{{ route('recruitments.show', $period) }}" class="mt-4 inline-block font-bold underline">Detail</a>
                </article>
            @empty
                <p>Belum ada rekrutmen aktif.</p>
            @endforelse
        </div>
    </section>

    <section class="mt-16">
        <h2 class="text-3xl font-black">Organisasi</h2>
        <div class="mt-6 grid gap-4 md:grid-cols-2">
            @foreach ($organizations as $organization)
                <article class="border-2 border-neutral-950 p-5">
                    <p class="font-mono text-sm">{{ $organization->organization_code }}</p>
                    <h3 class="text-xl font-black">{{ $organization->organization_name }}</h3>
                    <p class="mt-2 text-sm text-neutral-700">{{ $organization->divisions_count }} divisi tersedia.</p>
                    <a href="{{ route('organizations.show', $organization) }}" class="mt-4 inline-block font-bold underline">Lihat organisasi</a>
                </article>
            @endforeach
        </div>
    </section>
@endsection

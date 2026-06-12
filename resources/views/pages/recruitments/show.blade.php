@extends('layouts.public', ['title' => $period->recruitment_title.' - SIROMA'])

@section('content')
    <x-comic-panel class="relative overflow-hidden p-6 md:p-8">
        <div class="speed-lines absolute inset-0 opacity-20"></div>
        <div class="relative max-w-4xl">
            <p class="burst-label mb-5">{{ $period->organization->organization_name }}</p>
            <h1 class="text-4xl font-black leading-tight md:text-6xl">{{ $period->recruitment_title }}</h1>
            <p class="mt-4 max-w-3xl text-lg leading-8 text-neutral-700">{{ $period->description }}</p>
            <div class="mt-5 flex flex-wrap items-center gap-3">
                <x-status-badge :status="$period->recruitment_status" />
                @auth
                    <span class="border-2 border-neutral-950 bg-white px-3 py-1 text-xs font-black uppercase shadow-[2px_2px_0_#141414]">Akun siap daftar</span>
                @else
                    <span class="border-2 border-neutral-950 bg-white px-3 py-1 text-xs font-black uppercase shadow-[2px_2px_0_#141414]">Login diperlukan</span>
                @endauth
            </div>
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

    <section class="mt-10">
        <x-comic-panel class="relative overflow-hidden p-6">
            <div class="screentone absolute inset-y-0 right-0 w-1/3 opacity-40"></div>
            <div class="relative grid gap-5 md:grid-cols-[1fr_auto] md:items-center">
                <div>
                    <h2 class="text-3xl font-black">Siap kirim aplikasi?</h2>
                    <p class="mt-2 max-w-2xl text-sm leading-6 text-neutral-700">Pastikan profil sudah benar dan CV sudah siap. Aplikasi akan dikirim memakai akun yang sedang login.</p>
                </div>
                @if ($period->recruitment_status === 'open')
                    <x-ink-button :href="route('recruitments.apply', $period)">Daftar Sekarang</x-ink-button>
                @else
                    <span class="font-black uppercase">Pendaftaran belum dibuka</span>
                @endif
            </div>
        </x-comic-panel>
    </section>
@endsection

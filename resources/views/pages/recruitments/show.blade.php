@extends('layouts.public', ['title' => $period->recruitment_title.' - SIROMA'])

@section('content')
    <x-comic-panel class="relative overflow-hidden p-6 md:p-8">
        <div class="speed-lines absolute inset-0 opacity-20"></div>
        <div class="absolute -right-10 -top-10 h-40 w-40 rounded-full border-4 border-neutral-950 bg-white screentone"></div>
        <div class="relative max-w-4xl">
            <p class="burst-label mb-4">{{ $period->organization->organization_name }}</p>
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

    <div class="mt-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
        <x-stat-card label="Tahun Akademik" :value="$period->academic_year" />
        <x-stat-card label="Tanggal Buka" :value="$period->registration_start_date->translatedFormat('d M Y')" />
        <x-stat-card label="Tanggal Tutup" :value="$period->registration_end_date->translatedFormat('d M Y')" />
        <x-stat-card label="Total Kuota" :value="$period->total_quota" />
    </div>

    <section class="mt-12">
        <x-comic-panel class="relative overflow-hidden p-5 md:p-7">
            <div class="screentone absolute inset-y-0 right-0 w-1/3 opacity-30"></div>
            <div class="relative">
                    <x-section-heading title="Divisi Tersedia" description="Setiap divisi punya fokus kerja berbeda. Pilih prioritas pertama dan kedua saat mendaftar." class="text-center" />
                <div class="mt-4 grid gap-4 md:grid-cols-2">
                    @forelse ($period->organization->divisions as $division)
                        <article class="comic-panel-soft p-4 transition-transform hover:-translate-y-0.5">
                            <h3 class="font-black text-lg">{{ $division->division_name }}</h3>
                            <p class="mt-2 text-sm leading-6 text-neutral-700">{{ $division->description }}</p>
                        </article>
                    @empty
                        <p class="comic-panel-soft p-4 text-sm font-semibold text-neutral-700 md:col-span-2">Belum ada divisi yang terdaftar.</p>
                    @endforelse
                </div>
            </div>
        </x-comic-panel>
    </section>

    <section class="mt-10">
        <x-comic-panel class="relative overflow-hidden p-6">
            <div class="speed-lines absolute inset-0 opacity-20"></div>
            <div class="relative grid gap-5 md:grid-cols-[1fr_auto] md:items-center">
                <div>
                    <h2 class="text-3xl font-black">Siap kirim aplikasi?</h2>
                    <p class="mt-2 max-w-2xl text-sm leading-6 text-neutral-700">Pastikan profil sudah benar dan CV sudah siap. Aplikasi akan dikirim memakai akun yang sedang login.</p>
                </div>
                @if ($period->recruitment_status === 'open')
                    <x-ink-button :href="route('recruitments.apply', $period)">Daftar Sekarang</x-ink-button>
                @else
                    <span class="font-black uppercase text-neutral-500">Pendaftaran {{ $period->recruitment_status === 'upcoming' ? 'belum dibuka' : 'sudah ditutup' }}</span>
                @endif
            </div>
        </x-comic-panel>
    </section>
@endsection

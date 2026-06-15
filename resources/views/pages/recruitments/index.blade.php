@extends('layouts.public', ['title' => 'Rekrutmen - SIROMA'])

@section('content')
    <x-comic-panel class="relative overflow-hidden p-6 md:p-8">
        <div class="speed-lines absolute inset-0 opacity-20"></div>
        <div class="absolute -right-6 -top-6 h-36 w-36 rounded-full border-4 border-neutral-950 bg-white screentone"></div>
        <div class="relative">
            <p class="burst-label mb-4">Quest Board</p>
            <h1 class="text-4xl font-black leading-tight md:text-6xl">Rekrutmen</h1>
            <p class="mt-3 max-w-3xl text-lg leading-8 text-neutral-700">Filter periode berdasarkan organisasi, cek status, lalu masuk ke detail untuk daftar dengan akun mahasiswa.</p>
            <div class="mt-5 flex flex-wrap items-center gap-3">
                <span class="border-2 border-neutral-950 bg-white px-3 py-1 text-xs font-black uppercase">{{ $recruitments->total() }} periode</span>
                @auth
                    <span class="border-2 border-neutral-950 bg-white px-3 py-1 text-xs font-black uppercase shadow-[2px_2px_0_#141414]">Login: {{ auth()->user()->full_name }}</span>
                @else
                    <span class="border-2 border-neutral-950 bg-white px-3 py-1 text-xs font-black uppercase shadow-[2px_2px_0_#141414]">Login dulu untuk daftar</span>
                @endauth
            </div>
        </div>
    </x-comic-panel>

    <form method="GET" class="comic-panel-soft mt-8 space-y-4 p-4">
        <div class="grid gap-3 md:grid-cols-2 lg:grid-cols-4">
            <label class="grid gap-2 font-bold text-sm">
                Cari Rekrutmen
                <input type="text" name="search" placeholder="Judul atau organisasi..." value="{{ $searchQuery }}" class="border-2 border-neutral-950 bg-white px-3 py-3">
            </label>

            <label class="grid gap-2 font-bold text-sm">
                Organisasi
                <select name="organization" class="border-2 border-neutral-950 bg-white px-3 py-3">
                    <option value="">Semua organisasi</option>
                    @foreach ($organizations as $organization)
                        <option value="{{ $organization->id }}" @selected($selectedOrganization === $organization->id)>
                            {{ $organization->organization_name }}
                        </option>
                    @endforeach
                </select>
            </label>

            <label class="grid gap-2 font-bold text-sm">
                Status
                <select name="status" class="border-2 border-neutral-950 bg-white px-3 py-3">
                    <option value="">Semua status</option>
                    <option value="open" @selected($selectedStatus === 'open')>Buka Pendaftaran</option>
                    <option value="closed" @selected($selectedStatus === 'closed')>Tutup Pendaftaran</option>
                    <option value="draft" @selected($selectedStatus === 'draft')>Draft</option>
                    <option value="completed" @selected($selectedStatus === 'completed')>Selesai</option>
                </select>
            </label>

            <div class="flex gap-2 items-end">
                <x-ink-button type="submit" class="px-4 py-3 text-sm flex-1">Filter</x-ink-button>
                <x-ink-button :href="route('recruitments.index')" variant="secondary" class="px-4 py-3 text-sm">Reset</x-ink-button>
            </div>
        </div>
    </form>

    <div class="mt-8 grid gap-4 md:grid-cols-2">
        @forelse ($recruitments as $period)
            <x-recruitment-card :period="$period" />
        @empty
            <p class="comic-panel-soft p-5 text-sm font-semibold text-neutral-700 md:col-span-2">Tidak ada rekrutmen yang cocok dengan filter ini.</p>
        @endforelse
    </div>

    @if ($recruitments->hasPages())
        <div class="mt-8">
            {{ $recruitments->links('pagination::tailwind') }}
        </div>
    @endif
@endsection

@extends('layouts.public', ['title' => 'Organisasi - SIROMA'])

@section('content')
    <x-comic-panel class="relative overflow-hidden p-6 md:p-8">
        <div class="speed-lines absolute inset-0 opacity-20"></div>
        <div class="relative">
            <p class="burst-label mb-5">Directory</p>
            <h1 class="text-4xl font-black leading-tight md:text-6xl">Organisasi</h1>
            <p class="mt-4 max-w-3xl text-lg leading-8 text-neutral-700">Daftar organisasi mahasiswa yang membuka dan mengelola periode rekrutmen di SIROMA.</p>
            <p class="mt-3 text-sm font-bold text-neutral-600">{{ $organizations->total() }} organisasi terdaftar</p>
        </div>
    </x-comic-panel>

    <form method="GET" class="comic-panel-soft mt-8 space-y-4 p-4">
        <div class="grid gap-3 md:grid-cols-3 lg:grid-cols-4 items-end">
            <label class="grid gap-2 font-bold text-sm md:col-span-2 lg:col-span-2">
                Cari organisasi
                <input type="text" name="search" placeholder="Nama, kode, atau deskripsi..." value="{{ $searchQuery }}" class="border-2 border-neutral-950 bg-white px-3 py-3">
            </label>

            <label class="grid gap-2 font-bold text-sm">
                Urutkan
                <select name="sort" class="border-2 border-neutral-950 bg-white px-3 py-3">
                    <option value="name" @selected($sortBy === 'name')>Nama (A-Z)</option>
                    <option value="newest" @selected($sortBy === 'newest')>Terbaru</option>
                    <option value="divisions" @selected($sortBy === 'divisions')>Divisi Terbanyak</option>
                    <option value="recruitments" @selected($sortBy === 'recruitments')>Rekrutmen Terbanyak</option>
                </select>
            </label>

            <div class="flex gap-2">
                <x-ink-button type="submit" class="px-4 py-3 text-sm flex-1">Cari</x-ink-button>
                <x-ink-button :href="route('organizations.index')" variant="secondary" class="px-4 py-3 text-sm">Reset</x-ink-button>
            </div>
        </div>
    </form>

    <div class="mt-8 grid gap-4 md:grid-cols-2">
        @forelse ($organizations as $organization)
            <x-organization-card :organization="$organization" />
        @empty
            <p class="comic-panel-soft p-5 text-sm font-semibold text-neutral-700 md:col-span-2">Tidak ada organisasi yang cocok dengan pencarian ini.</p>
        @endforelse
    </div>

    @if ($organizations->hasPages())
        <div class="mt-8">
            {{ $organizations->links('pagination::tailwind') }}
        </div>
    @endif
@endsection

@extends('layouts.public', ['title' => 'Organisasi - SIROMA'])

@section('content')
    <x-comic-panel class="relative overflow-hidden p-6 md:p-8">
        <div class="speed-lines absolute inset-0 opacity-20"></div>
        <div class="relative">
            <p class="burst-label mb-5">Directory</p>
            <h1 class="text-4xl font-black leading-tight md:text-6xl">Organisasi</h1>
            <p class="mt-4 max-w-3xl text-lg leading-8 text-neutral-700">Daftar organisasi mahasiswa yang membuka dan mengelola periode rekrutmen di SIROMA.</p>
            <p class="mt-3 text-sm font-bold text-neutral-600">{{ $organizations->count() }} organisasi terdaftar</p>
        </div>
    </x-comic-panel>

    <form method="GET" class="comic-panel-soft mt-8 flex flex-wrap gap-3 p-4">
        <input type="text" name="search" placeholder="Cari organisasi..." value="{{ request('search') }}" class="flex-1 border-2 border-neutral-950 bg-white px-3 py-3 min-w-[200px]">
        <x-ink-button type="submit" class="px-4 py-2 text-sm">Cari</x-ink-button>
        <x-ink-button :href="route('organizations.index')" variant="secondary" class="px-4 py-2 text-sm">Reset</x-ink-button>
    </form>

    <div class="mt-8 grid gap-4 md:grid-cols-2">
        @forelse ($organizations as $organization)
            <x-organization-card :organization="$organization" />
        @empty
            <p class="comic-panel-soft p-5 text-sm font-semibold text-neutral-700 md:col-span-2">Tidak ada organisasi yang cocok dengan pencarian ini.</p>
        @endforelse
    </div>
@endsection

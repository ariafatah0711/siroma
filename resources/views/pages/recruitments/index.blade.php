@extends('layouts.public', ['title' => 'Rekrutmen - SIROMA'])

@section('content')
    <x-comic-panel class="relative overflow-hidden p-6 md:p-8">
        <div class="speed-lines absolute inset-0 opacity-20"></div>
        <div class="relative grid gap-6 md:grid-cols-[1fr_auto] md:items-end">
            <x-section-heading eyebrow="Quest Board" title="Rekrutmen" description="Filter periode berdasarkan organisasi, cek status, lalu masuk ke detail untuk daftar dengan akun mahasiswa." />
            <div class="comic-panel-soft bg-white p-4 text-sm font-bold text-neutral-700">
                @auth
                    Login sebagai <span class="font-black text-neutral-950">{{ auth()->user()->full_name }}</span>
                @else
                    Login dulu sebelum mengirim pendaftaran.
                @endauth
            </div>
        </div>
    </x-comic-panel>

    <form method="GET" class="comic-panel-soft mt-8 flex flex-wrap gap-3 p-4">
        <select name="organization" class="border-2 border-neutral-950 bg-white px-3 py-3">
            <option value="">Semua organisasi</option>
            @foreach ($organizations as $organization)
                <option value="{{ $organization->id }}" @selected($selectedOrganization === $organization->id)>
                    {{ $organization->organization_name }}
                </option>
            @endforeach
        </select>
        <x-ink-button type="submit" class="px-4 py-2 text-sm">Filter</x-ink-button>
        <x-ink-button :href="route('recruitments.index')" variant="secondary" class="px-4 py-2 text-sm">Reset</x-ink-button>
    </form>

    <div class="mt-8 grid gap-4 md:grid-cols-2">
        @forelse ($recruitments as $period)
            <x-recruitment-card :period="$period" />
        @empty
            <p class="comic-panel-soft p-5 text-sm font-semibold text-neutral-700">Tidak ada rekrutmen yang cocok dengan filter ini.</p>
        @endforelse
    </div>
@endsection

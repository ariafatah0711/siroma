@extends('layouts.public', ['title' => 'Rekrutmen - SIROMA'])

@section('content')
    <x-section-heading eyebrow="Quest Board" title="Rekrutmen" description="Filter periode berdasarkan organisasi, cek status, lalu masuk ke detail untuk daftar." />

    <form method="GET" class="comic-panel-soft mt-8 flex flex-wrap gap-3 p-4">
        <select name="organization" class="border-2 border-neutral-950 px-3 py-2">
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
        @foreach ($recruitments as $period)
            <x-recruitment-card :period="$period" />
        @endforeach
    </div>
@endsection

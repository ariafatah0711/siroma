@props(['period'])

<article {{ $attributes->merge(['class' => 'comic-panel-soft p-5 transition-transform hover:-translate-y-1']) }}>
    <div class="flex flex-wrap items-center justify-between gap-3">
        <p class="text-xs font-black uppercase tracking-[0.16em] text-neutral-600">{{ $period->organization->organization_name }}</p>
        <x-status-badge :status="$period->recruitment_status" />
    </div>
    <h3 class="mt-4 text-2xl font-black leading-tight">{{ $period->recruitment_title }}</h3>
    <p class="mt-3 text-sm leading-6 text-neutral-700">
        {{ $period->registration_start_date->translatedFormat('d M Y') }} - {{ $period->registration_end_date->translatedFormat('d M Y') }}
    </p>
    <div class="mt-4 flex flex-wrap items-center justify-between gap-3 text-sm font-bold">
        <span>Kuota {{ $period->total_quota }}</span>
        <a href="{{ route('recruitments.show', $period) }}" class="underline decoration-2 underline-offset-4">Detail</a>
    </div>
</article>

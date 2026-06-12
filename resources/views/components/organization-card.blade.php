@props(['organization'])

<article {{ $attributes->merge(['class' => 'comic-panel-soft p-5 transition-transform hover:-translate-y-1']) }}>
    <p class="font-mono text-sm font-black">{{ $organization->organization_code }}</p>
    <h3 class="mt-2 text-2xl font-black leading-tight">{{ $organization->organization_name }}</h3>
    <p class="mt-3 line-clamp-3 text-sm leading-6 text-neutral-700">{{ $organization->description }}</p>
    <div class="mt-5 flex flex-wrap items-center justify-between gap-3 text-sm font-bold">
        @isset($organization->divisions_count)
            <span>{{ $organization->divisions_count }} divisi</span>
        @endisset
        <a href="{{ route('organizations.show', $organization) }}" class="underline decoration-2 underline-offset-4">Lihat</a>
    </div>
</article>

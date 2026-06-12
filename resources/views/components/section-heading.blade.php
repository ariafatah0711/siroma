@props(['eyebrow' => null, 'title', 'description' => null])

<div {{ $attributes->merge(['class' => 'mx-auto max-w-3xl']) }}>
    @if ($eyebrow)
        <p class="burst-label mb-4">{{ $eyebrow }}</p>
    @endif
    <h2 class="text-3xl font-black leading-tight md:text-5xl">{{ $title }}</h2>
    @if ($description)
        <p class="mt-4 text-base leading-7 text-neutral-700 md:text-lg">{{ $description }}</p>
    @endif
</div>

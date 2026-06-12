@props(['label', 'value'])

<div {{ $attributes->merge(['class' => 'comic-panel-soft p-4']) }}>
    <p class="text-xs font-black uppercase tracking-[0.16em] text-neutral-600">{{ $label }}</p>
    <p class="mt-2 text-4xl font-black">{{ $value }}</p>
</div>

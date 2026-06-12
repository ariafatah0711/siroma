@props(['status'])

@php
    $label = str($status)->replace('_', ' ')->headline();
@endphp

<span {{ $attributes->merge(['class' => 'inline-flex border-2 border-neutral-950 bg-white px-2.5 py-1 text-xs font-black uppercase tracking-wide shadow-[2px_2px_0_#141414]']) }}>
    {{ $label }}
</span>

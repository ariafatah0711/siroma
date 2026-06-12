@props([
    'href' => null,
    'variant' => 'primary',
    'type' => 'button',
])

@php
    $variantClass = $variant === 'secondary' ? 'ink-button-secondary' : 'ink-button-primary';
@endphp

@if ($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => 'ink-button '.$variantClass]) }}>{{ $slot }}</a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => 'ink-button '.$variantClass]) }}>{{ $slot }}</button>
@endif

@props(['soft' => false])

<div {{ $attributes->merge(['class' => $soft ? 'comic-panel-soft' : 'comic-panel']) }}>
    {{ $slot }}
</div>

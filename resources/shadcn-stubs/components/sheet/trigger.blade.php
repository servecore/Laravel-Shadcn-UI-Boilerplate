@props(['asChild' => false])

<div @click="open = true" {{ $attributes->merge(['class' => 'cursor-pointer inline-block']) }}>
    {{ $slot }}
</div>

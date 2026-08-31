<div class="space-y-2">
    @if($label)
        <x-label for="{{ $name }}">{{ $label }}</x-label>
    @endif

    <x-input
        id="{{ $name }}"
        name="{{ $name }}"
        type="{{ $type }}"
        value="{{ $value ?? old($name) }}"
        placeholder="{{ $placeholder }}"
        @if($required) required @endif
    />

    @error($name)
        <p class="text-sm text-destructive">{{ $message }}</p>
    @enderror
</div>

<div class="space-y-2">
    @if($label)
        <x-label for="{{ $name }}">{{ $label }}</x-label>
    @endif

    <select
        id="{{ $name }}"
        name="{{ $name }}"
        class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
        @if($required) required @endif
    >
        @foreach($options as $key => $option)
            <option value="{{ $key }}" {{ ($value ?? old($name)) === $key ? 'selected' : '' }}>
                {{ $option }}
            </option>
        @endforeach
    </select>

    @error($name)
        <p class="text-sm text-destructive">{{ $message }}</p>
    @enderror
</div>

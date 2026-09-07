@props(['class' => ''])

<div data-slot="table-container" class="relative w-full rounded-md border">
    <table
        data-slot="table"
        {{ $attributes->merge([
            'class' => 'w-full caption-bottom text-sm overflow-x-auto ' . $class
        ]) }}
    >
        {{ $slot }}
    </table>
</div>

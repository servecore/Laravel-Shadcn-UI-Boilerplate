@props(['class' => ''])

<div data-slot="table-container" class="relative w-full overflow-x-auto rounded-md border">
    <table
        data-slot="table"
        {{ $attributes->merge([
            'class' => 'w-full caption-bottom text-sm ' . $class
        ]) }}
    >
        {{ $slot }}
    </table>
</div>

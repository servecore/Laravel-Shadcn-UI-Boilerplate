@props([
    'items' => [],
])

<x-sidebar.menu>
@foreach ($items as $item)
    @if (isset($item['type']) && $item['type'] === 'group')
        <x-sidebar.group>
            <x-sidebar.group-label>
                {{ $item['label'] }}
            </x-sidebar.group-label>

            <x-sidebar.group-content>
                <x-sidebar.menu>
                    @foreach ($item['items'] as $sub)
                        <x-sidebar.menu-item>
                            <x-sidebar.menu-button
                                :active="$sub['active'] ?? false"
                                :tooltip="$sub['tooltip'] ?? null"
                            >
                                {!! $sub['icon'] !!}
                                <span>{{ $sub['label'] }}</span>
                            </x-sidebar.menu-button>
                        </x-sidebar.menu-item>
                    @endforeach
                </x-sidebar.menu>
            </x-sidebar.group-content>
        </x-sidebar.group>

    @elseif (isset($item['type']) && $item['type'] === 'submenu')
        <x-sidebar.menu-item>
            <x-sidebar.menu-button
                :tooltip="$item['tooltip'] ?? null"
            >
                {!! $item['icon'] !!}
                <span>{{ $item['label'] }}</span>
            </x-sidebar.menu-button>

            <x-sidebar.menu-sub>
                @foreach ($item['items'] as $sub)
                    <x-sidebar.menu-sub-item>
                        <x-sidebar.menu-sub-button :active="$sub['active'] ?? false">
                            {!! $sub['icon'] ?? '' !!}
                            <span>{{ $sub['label'] }}</span>
                        </x-sidebar.menu-sub-button>
                    </x-sidebar.menu-sub-item>
                @endforeach
            </x-sidebar.menu-sub>
        </x-sidebar.menu-item>

    @else
        <x-sidebar.menu-item>
            <x-sidebar.menu-button
                :active="$item['active'] ?? false"
                :tooltip="$item['tooltip'] ?? null"
            >
                {!! $item['icon'] !!}
                <span>{{ $item['label'] }}</span>
            </x-sidebar.menu-button>
        </x-sidebar.menu-item>
    @endif
@endforeach
</x-sidebar.menu>

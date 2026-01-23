@props(['inset' => false])

<span data-slot="dropdown-menu-label"
      class="px-2 py-1.5 text-sm font-medium {{ $inset ? 'pl-8' : '' }}">
    {{ $slot }}
</span>

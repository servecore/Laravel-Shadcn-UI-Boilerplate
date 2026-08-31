@extends('layouts.setup')

@section('title', 'Environment Check')

@section('content')
<div class="space-y-6">
    {{-- Server Requirements Card --}}
    <x-card>
        <x-card-header>
            <x-card-title>Environment Requirements</x-card-title>
            <x-card-description>
                Your server must meet the following requirements before continuing.
            </x-card-description>
        </x-card-header>
        <x-card-content>
            <div class="space-y-3">
                @foreach($checks as $key => $check)
                    @php
                        $bgClass = $check['passed'] ? 'bg-green-50 dark:bg-green-950/30' : 'bg-red-50 dark:bg-red-950/30';
                        $iconClass = $check['passed'] ? 'bg-green-100 text-green-600 dark:bg-green-900/50 dark:text-green-400' : 'bg-red-100 text-red-600 dark:bg-red-900/50 dark:text-red-400';
                        $textClass = $check['passed'] ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400';
                    @endphp
                    <div class="flex items-center justify-between py-2 px-3 rounded-lg {{ $bgClass }}">
                        <div class="flex items-center gap-3">
                            <div class="flex size-6 items-center justify-center rounded-full {{ $iconClass }}">
                                @if($check['passed'])
                                    <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                @else
                                    <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                @endif
                            </div>
                            <span class="text-sm font-medium">{{ $check['label'] }}</span>
                        </div>
                        <span class="text-sm {{ $textClass }}">{{ $check['message'] }}</span>
                    </div>
                @endforeach
            </div>
        </x-card-content>
    </x-card>

    {{-- Folder Permissions Card (adopted from InstallerErag) --}}
    @if(isset($permissions) && count($permissions) > 0)
    <x-card>
        <x-card-header>
            <x-card-title>Folder Permissions</x-card-title>
            <x-card-description>
                The following directories must have write permissions.
            </x-card-description>
        </x-card-header>
        <x-card-content>
            <div class="space-y-3">
                @foreach($permissions as $permission)
                    @php
                        $bgClass = $permission['passed'] ? 'bg-green-50 dark:bg-green-950/30' : 'bg-red-50 dark:bg-red-950/30';
                        $iconClass = $permission['passed'] ? 'bg-green-100 text-green-600 dark:bg-green-900/50 dark:text-green-400' : 'bg-red-100 text-red-600 dark:bg-red-900/50 dark:text-red-400';
                        $textClass = $permission['passed'] ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400';
                    @endphp
                    <div class="flex items-center justify-between py-2 px-3 rounded-lg {{ $bgClass }}">
                        <div class="flex items-center gap-3">
                            <div class="flex size-6 items-center justify-center rounded-full {{ $iconClass }}">
                                @if($permission['passed'])
                                    <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                @else
                                    <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                @endif
                            </div>
                            <span class="text-sm font-medium">{{ $permission['label'] }}</span>
                        </div>
                        <span class="text-sm {{ $textClass }}">{{ $permission['message'] }}</span>
                    </div>
                @endforeach
            </div>
        </x-card-content>
    </x-card>
    @endif

    {{-- Continue Button --}}
    <div class="flex justify-end">
        <form action="{{ route('setup.step2') }}" method="GET">
            @php
                $permissionsPassed = !isset($permissions) || collect($permissions)->every(fn($p) => $p['passed']);
            @endphp
            @if($allPassed && $permissionsPassed)
                <x-button type="submit">
                    Continue
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-4 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </x-button>
            @else
                <x-button type="submit" disabled>
                    Continue
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-4 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </x-button>
            @endif
        </form>
    </div>

    @if(! $allPassed)
        <div class="mt-4 text-center">
            <p class="text-sm text-muted-foreground">
                Please fix the failed requirements above, then
                <a href="{{ route('setup.step1') }}" class="text-primary hover:underline font-medium">refresh this page</a>.
            </p>
        </div>
    @endif
</div>
@endsection

@extends('layouts.setup')

@section('title', 'Application Configuration')
@section('subtitle', 'Configure your application settings')

@section('content')
<x-card>
    <x-card-header>
        <x-card-title>Application Settings</x-card-title>
        <x-card-description>
            Set up your application name, URL, and other settings.
        </x-card-description>
    </x-card-header>
    <x-card-content>
        @if ($errors->any())
            <div class="mb-4 p-4 rounded-lg bg-destructive/10 border border-destructive/20 text-destructive text-sm">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('setup.save-app-config') }}" method="POST" class="space-y-6">
            @csrf

            {{-- App Name --}}
            <div class="space-y-2">
                <x-label for="app_name">Application Name</x-label>
                <x-input
                    type="text"
                    id="app_name"
                    name="app_name"
                    value="{{ old('app_name', $appName) }}"
                    placeholder="My Application"
                    required
                />
                <p class="text-xs text-muted-foreground">This will be displayed in the browser tab and throughout the app.</p>
            </div>

            {{-- App URL --}}
            <div class="space-y-2">
                <x-label for="app_url">Application URL</x-label>
                <x-input
                    type="url"
                    id="app_url"
                    name="app_url"
                    value="{{ old('app_url', $appUrl) }}"
                    placeholder="https://example.com"
                    required
                />
                <p class="text-xs text-muted-foreground">The URL where your application will be accessible.</p>
            </div>

            {{-- Timezone & Locale --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="space-y-2">
                    <x-label for="timezone">Timezone</x-label>
                    @php
                        $commonTimezones = [
                            'UTC' => 'UTC (Coordinated Universal Time)',
                            'GMT' => 'GMT (Greenwich Mean Time)',
                            'Asia/Jakarta' => 'Asia/Jakarta (WIB, GMT+7)',
                            'Asia/Makassar' => 'Asia/Makassar (WITA, GMT+8)',
                            'Asia/Jayapura' => 'Asia/Jayapura (WIT, GMT+9)',
                            'Asia/Shanghai' => 'Asia/Shanghai (CST, GMT+8)',
                            'Asia/Tokyo' => 'Asia/Tokyo (JST, GMT+9)',
                            'Asia/Seoul' => 'Asia/Seoul (KST, GMT+9)',
                            'Asia/Singapore' => 'Asia/Singapore (SGT, GMT+8)',
                            'Asia/Kolkata' => 'Asia/Kolkata (IST, GMT+5:30)',
                            'Europe/London' => 'Europe/London (GMT/BST)',
                            'Europe/Paris' => 'Europe/Paris (CET/CEST)',
                            'Europe/Berlin' => 'Europe/Berlin (CET/CEST)',
                            'America/New_York' => 'America/New_York (EST/EDT)',
                            'America/Chicago' => 'America/Chicago (CST/CDT)',
                            'America/Denver' => 'America/Denver (MST/MDT)',
                            'America/Los_Angeles' => 'America/Los_Angeles (PST/PDT)',
                            'Australia/Sydney' => 'Australia/Sydney (AEST/AEDT)',
                        ];
                        $allTimezones = timezone_identifiers_list();
                        $currentTimezone = old('timezone', $timezone);
                    @endphp
                    <select
                        id="timezone"
                        name="timezone"
                        class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
                    >
                        <optgroup label="Common Timezones">
                            @foreach($commonTimezones as $tz => $label)
                                <option value="{{ $tz }}" {{ $currentTimezone === $tz ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </optgroup>
                        <optgroup label="All Timezones">
                            @foreach($allTimezones as $tz)
                                @if(! array_key_exists($tz, $commonTimezones))
                                    <option value="{{ $tz }}" {{ $currentTimezone === $tz ? 'selected' : '' }}>
                                        {{ $tz }}
                                    </option>
                                @endif
                            @endforeach
                        </optgroup>
                    </select>
                    <p class="text-xs text-muted-foreground">Used for scheduling and timestamps.</p>
                </div>

                <div class="space-y-2">
                    <x-label for="locale">Locale</x-label>
                    <select
                        id="locale"
                        name="locale"
                        class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
                    >
                        @foreach(['en' => 'English', 'id' => 'Indonesian', 'ms' => 'Malay', 'es' => 'Spanish', 'fr' => 'French', 'de' => 'German', 'ja' => 'Japanese', 'zh' => 'Chinese'] as $code => $name)
                            <option value="{{ $code }}" {{ old('locale', $locale) === $code ? 'selected' : '' }}>
                                {{ $name }}
                            </option>
                        @endforeach
                    </select>
                    <p class="text-xs text-muted-foreground">Default language for the application.</p>
                </div>
            </div>

            {{-- Debug Mode --}}
            <div class="flex items-center justify-between rounded-lg border p-4">
                <div class="space-y-0.5">
                    <x-label for="debug_mode" class="text-base">Debug Mode</x-label>
                    <p class="text-sm text-muted-foreground">
                        Enable debug mode for development. Disable in production.
                    </p>
                </div>
                <x-switch id="debug_mode" name="debug_mode" value="1" checked="{{ old('debug_mode', true) }}" />
            </div>

            {{-- Navigation --}}
            <div class="flex justify-between pt-4">
                <a href="{{ route('setup.step1') }}">
                    <x-button variant="outline" type="button">
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                        Back
                    </x-button>
                </a>

                <x-button type="submit">
                    Save & Continue
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-4 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </x-button>
            </div>
        </form>
    </x-card-content>
</x-card>
@endsection

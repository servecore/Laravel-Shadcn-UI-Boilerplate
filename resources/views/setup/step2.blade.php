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
                    <x-select id="timezone" name="timezone">
                        @foreach(timezone_identifiers_list() as $tz)
                            <option value="{{ $tz }}" {{ old('timezone', $timezone) === $tz ? 'selected' : '' }}>
                                {{ $tz }}
                            </option>
                        @endforeach
                    </x-select>
                </div>

                <div class="space-y-2">
                    <x-label for="locale">Locale</x-label>
                    <x-select id="locale" name="locale">
                        @foreach(['en' => 'English', 'id' => 'Indonesian', 'ms' => 'Malay', 'es' => 'Spanish', 'fr' => 'French', 'de' => 'German', 'ja' => 'Japanese', 'zh' => 'Chinese'] as $code => $name)
                            <option value="{{ $code }}" {{ old('locale', $locale) === $code ? 'selected' : '' }}>
                                {{ $name }}
                            </option>
                        @endforeach
                    </x-select>
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

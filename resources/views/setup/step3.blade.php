@extends('layouts.setup')

@section('title', 'Database Configuration')
@section('subtitle', 'Configure your database connection')

@section('content')
<x-card>
    <x-card-header>
        <x-card-title>Database Settings</x-card-title>
        <x-card-description>
            Choose and configure your database driver. SQLite is recommended for development.
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

        <form action="{{ route('setup.save-database') }}" method="POST" id="databaseForm" class="space-y-6">
            @csrf

            {{-- Database Driver Selection --}}
            <div class="space-y-3">
                <x-label>Database Driver</x-label>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                    @foreach($databases as $key => $db)
                        <label class="relative cursor-pointer">
                            <input
                                type="radio"
                                name="driver"
                                value="{{ $key }}"
                                class="peer sr-only"
                                {{ $key === $currentDriver ? 'checked' : '' }}
                                onchange="toggleDatabaseFields('{{ $key }}')"
                            />
                            <div class="flex flex-col items-center gap-2 rounded-lg border-2 border-border p-4 transition-all hover:border-primary/50 peer-checked:border-primary peer-checked:bg-primary/5">
                                <div class="flex size-10 items-center justify-center rounded-lg bg-muted peer-checked:bg-primary/10">
                                    @if($key === 'sqlite')
                                        <svg xmlns="http://www.w3.org/2000/svg" class="size-5 text-muted-foreground" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4" />
                                        </svg>
                                    @else
                                        <svg xmlns="http://www.w3.org/2000/svg" class="size-5 text-muted-foreground" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01" />
                                        </svg>
                                    @endif
                                </div>
                                <div class="text-center">
                                    <div class="text-sm font-medium">{{ $db['name'] }}</div>
                                    <div class="text-xs text-muted-foreground mt-0.5">{{ $db['description'] }}</div>
                                </div>
                            </div>
                        </label>
                    @endforeach
                </div>
            </div>

            {{-- SQL Server Config (hidden by default, shown for MySQL/PostgreSQL) --}}
            <div id="sqlConfig" class="space-y-4 {{ in_array($currentDriver, ['mysql', 'pgsql']) ? '' : 'hidden' }}">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    {{-- Host --}}
                    <div class="space-y-2">
                        <x-label for="host">Host</x-label>
                        <x-input
                            type="text"
                            id="host"
                            name="host"
                            value="{{ old('host', '127.0.0.1') }}"
                            placeholder="127.0.0.1"
                        />
                    </div>

                    {{-- Port --}}
                    <div class="space-y-2">
                        <x-label for="port">Port</x-label>
                        <x-input
                            type="number"
                            id="port"
                            name="port"
                            value="{{ old('port', $currentDriver === 'mysql' ? '3306' : '5432') }}"
                            placeholder="3306"
                        />
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    {{-- Database Name --}}
                    <div class="space-y-2">
                        <x-label for="database">Database Name</x-label>
                        <x-input
                            type="text"
                            id="database"
                            name="database"
                            value="{{ old('database') }}"
                            placeholder="my_database"
                        />
                    </div>

                    {{-- Username --}}
                    <div class="space-y-2">
                        <x-label for="username">Username</x-label>
                        <x-input
                            type="text"
                            id="username"
                            name="username"
                            value="{{ old('username') }}"
                            placeholder="root"
                        />
                    </div>
                </div>

                {{-- Password --}}
                <div class="space-y-2">
                    <x-label for="password">Password</x-label>
                    <x-input
                        type="password"
                        id="password"
                        name="password"
                        value="{{ old('password') }}"
                        placeholder="••••••••"
                    />
                </div>

                {{-- Test Connection Button --}}
                <div class="flex items-center gap-3">
                    <x-button type="button" variant="outline" onclick="testConnection()">
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                        Test Connection
                    </x-button>
                    <span id="connectionResult" class="text-sm"></span>
                </div>
            </div>

            {{-- Navigation --}}
            <div class="flex justify-between pt-4">
                <a href="{{ route('setup.step2') }}">
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

@push('scripts')
<script>
    function toggleDatabaseFields(driver) {
        const sqlConfig = document.getElementById('sqlConfig');
        if (driver === 'sqlite') {
            sqlConfig.classList.add('hidden');
        } else {
            sqlConfig.classList.remove('hidden');
        }
    }

    async function testConnection() {
        const resultEl = document.getElementById('connectionResult');
        const btn = event.target;
        btn.disabled = true;
        resultEl.textContent = 'Testing...';
        resultEl.className = 'text-sm text-muted-foreground';

        const formData = new FormData(document.getElementById('databaseForm'));

        try {
            const response = await fetch('{{ route("setup.test-connection") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                },
                body: JSON.stringify(Object.fromEntries(formData)),
            });

            const data = await response.json();

            if (data.success) {
                resultEl.textContent = '✓ ' + data.message;
                resultEl.className = 'text-sm text-green-600 dark:text-green-400';
            } else {
                resultEl.textContent = '✗ ' + data.message;
                resultEl.className = 'text-sm text-red-600 dark:text-red-400';
            }
        } catch (error) {
            resultEl.textContent = '✗ Connection test failed';
            resultEl.className = 'text-sm text-red-600 dark:text-red-400';
        } finally {
            btn.disabled = false;
        }
    }
</script>
@endpush
@endsection

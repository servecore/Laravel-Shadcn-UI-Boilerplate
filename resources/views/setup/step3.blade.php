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

        <form action="{{ route('setup.save-database') }}" method="POST" id="databaseForm" class="space-y-6"
              x-data="{ driver: '{{ old('driver', $currentDriver) }}' }">
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
                                x-model="driver"
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

                {{-- SQL Server Config (shown only for MySQL/PostgreSQL) --}}
                <div x-show="driver !== 'sqlite'" x-cloak class="space-y-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="space-y-2">
                            <x-label for="host">Host</x-label>
                            <x-input type="text" id="host" name="host" value="{{ old('host', '127.0.0.1') }}" placeholder="127.0.0.1" />
                        </div>
                        <div class="space-y-2">
                            <x-label for="port">Port</x-label>
                            <x-input type="number" id="port" name="port" value="{{ old('port', '5432') }}" placeholder="3306" />
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="space-y-2">
                            <x-label for="database">Database Name</x-label>
                            <x-input type="text" id="database" name="database" value="{{ old('database') }}" placeholder="my_database" />
                            @error('database')<p class="text-sm text-destructive">{{ $message }}</p>@enderror
                        </div>
                        <div class="space-y-2">
                            <x-label for="username">Username</x-label>
                            <x-input type="text" id="username" name="username" value="{{ old('username') }}" placeholder="root" />
                            @error('username')<p class="text-sm text-destructive">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <div class="space-y-2">
                        <x-label for="password">Password</x-label>
                        <x-input type="password" id="password" name="password" value="{{ old('password') }}" placeholder="••••••••" />
                    </div>

                    <div class="flex items-center gap-3">
                        <button type="button" id="testBtn" onclick="testDbConnection()" class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium border border-input bg-background hover:bg-accent hover:text-accent-foreground h-9 px-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                            </svg>
                            Test Connection
                        </button>
                        <span id="connectionResult" class="text-sm"></span>
                    </div>
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
    async function testDbConnection() {
        const resultEl = document.getElementById('connectionResult');
        const btn = document.getElementById('testBtn');

        // Validate required fields before testing
        const host = document.getElementById('host').value.trim();
        const port = document.getElementById('port').value.trim();
        const database = document.getElementById('database').value.trim();
        const username = document.getElementById('username').value.trim();

        if (!host || !port || !database || !username) {
            resultEl.textContent = '\u2717 Please fill in all fields (Host, Port, Database, Username)';
            resultEl.className = 'text-sm text-red-600 dark:text-red-400';
            return;
        }

        btn.disabled = true;
        btn.textContent = 'Testing...';
        resultEl.textContent = '';
        resultEl.className = 'text-sm text-muted-foreground';

        const data = { driver: document.querySelector('input[name=driver]:checked').value };
        document.querySelectorAll('#databaseForm input:not([disabled]):not([type=radio])').forEach(el => {
            if (el.name) data[el.name] = el.value;
        });

        try {
            const controller = new AbortController();
            const timeoutId = setTimeout(() => controller.abort(), 10000); // 10s frontend timeout

            const res = await fetch('{{ route("setup.test-connection") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                },
                body: JSON.stringify(data),
                signal: controller.signal,
            });

            clearTimeout(timeoutId);

            if (!res.ok) {
                resultEl.textContent = '\u2717 Server returned HTTP ' + res.status;
                resultEl.className = 'text-sm text-red-600 dark:text-red-400';
                return;
            }

            const json = await res.json();
            if (json.success) {
                if (json.has_data) {
                    resultEl.innerHTML = '\u26A0\uFE0F ' + json.message;
                    resultEl.className = 'text-sm text-amber-600 dark:text-amber-400';
                } else {
                    resultEl.textContent = '\u2713 ' + json.message;
                    resultEl.className = 'text-sm text-green-600 dark:text-green-400';
                }
            } else {
                resultEl.textContent = '\u2717 ' + json.message;
                resultEl.className = 'text-sm text-red-600 dark:text-red-400';
            }
        } catch (e) {
            if (e.name === 'AbortError') {
                resultEl.textContent = '\u2717 Connection timed out (10s). Server may be unreachable.';
            } else {
                resultEl.textContent = '\u2717 Network error: ' + e.message;
            }
            resultEl.className = 'text-sm text-red-600 dark:text-red-400';
        } finally {
            btn.disabled = false;
            btn.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" class="size-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" /></svg> Test Connection';
        }
    }
</script>
@endpush
@endsection

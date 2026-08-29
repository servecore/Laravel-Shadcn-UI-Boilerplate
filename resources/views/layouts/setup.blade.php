<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Setup') - {{ config('app.name', 'Laravel') }}</title>
    <x-theme-script />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-gradient-to-br from-background via-background to-muted/30 flex flex-col">
    {{-- Theme Toggle (Top Right) --}}
    <div class="absolute top-4 right-4">
        <x-theme-toggle />
    </div>

    {{-- Main Content --}}
    <main class="flex-1 flex items-center justify-center p-4">
        <div class="w-full max-w-2xl">
            {{-- Logo & Title --}}
            <div class="text-center mb-8">
                <div class="flex justify-center mb-4">
                    <div class="flex size-14 items-center justify-center rounded-xl bg-primary text-primary-foreground shadow-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                </div>
                <h1 class="text-2xl font-bold tracking-tight">Application Setup</h1>
                <p class="text-muted-foreground mt-1">@yield('subtitle', 'Configure your application')</p>
            </div>

            {{-- Step Indicator --}}
            <div class="flex items-center justify-center gap-2 mb-8">
                @php
                    $method = request()->route()->getActionMethod();
                    $currentStep = 1;
                    if (request()->routeIs('setup.step2') || request()->routeIs('setup.save-app-config')) {
                        $currentStep = 2;
                    } elseif (request()->routeIs('setup.step3') || request()->routeIs('setup.save-database')) {
                        $currentStep = 3;
                    } elseif (request()->routeIs('setup.step4') || request()->routeIs('setup.complete')) {
                        $currentStep = 4;
                    }
                @endphp

                @foreach([1 => 'Environment', 2 => 'Application', 3 => 'Database', 4 => 'Admin'] as $step => $label)
                    <div class="flex items-center gap-2">
                        <div class="flex size-8 items-center justify-center rounded-full text-sm font-medium
                            {{ $step <= $currentStep ? 'bg-primary text-primary-foreground' : 'bg-muted text-muted-foreground' }}">
                            {{ $step }}
                        </div>
                        <span class="hidden sm:inline text-sm {{ $step === $currentStep ? 'text-foreground font-medium' : 'text-muted-foreground' }}">
                            {{ $label }}
                        </span>
                        @if($step < 4)
                            <div class="w-8 h-px bg-border mx-1"></div>
                        @endif
                    </div>
                @endforeach
            </div>

            {{-- Content --}}
            @yield('content')
        </div>
    </main>

    {{-- Footer --}}
    <footer class="py-4 text-center text-sm text-muted-foreground">
        <p>&copy; {{ date('Y') }} {{ config('app.name', 'Laravel') }}. All rights reserved.</p>
    </footer>
</body>
</html>

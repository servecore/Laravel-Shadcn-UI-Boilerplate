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
    <div class="absolute top-4 right-4">
        <x-theme-toggle />
    </div>

    <main class="flex-1 flex items-center justify-center p-4">
        <div class="w-full max-w-2xl">
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

            @yield('content')
        </div>
    </main>

    <footer class="py-4 text-center text-sm text-muted-foreground">
        <p>&copy; {{ date('Y') }} {{ config('app.name', 'Laravel') }}. All rights reserved.</p>
    </footer>
</body>
</html>

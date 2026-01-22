<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Authentication') - {{ config('app.name', 'Laravel') }}</title>
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
        <div class="w-full max-w-md">
            @yield('content')
        </div>
    </main>

    {{-- Footer --}}
    <footer class="py-4 text-center text-sm text-muted-foreground">
        <p>&copy; {{ date('Y') }} {{ config('app.name', 'Laravel') }}. All rights reserved.</p>
    </footer>
</body>
</html>

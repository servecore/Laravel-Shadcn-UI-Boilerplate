<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 Not Found - {{ config('app.name') }}</title>
    <x-theme-script />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-background flex flex-col items-center justify-center text-center p-4">
    <div class="space-y-4">
        <h1 class="text-9xl font-extrabold tracking-tighter text-primary/20">404</h1>
        <h2 class="text-3xl font-bold tracking-tight">Page not found</h2>
        <p class="text-muted-foreground max-w-[500px]">
            Sorry, we couldn't find the page you're looking for. It might have been removed, renamed, or doesn't exist.
        </p>
        <div class="pt-4">
            <x-button href="{{ url('/') }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="size-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to Home
            </x-button>
        </div>
    </div>
</body>
</html>

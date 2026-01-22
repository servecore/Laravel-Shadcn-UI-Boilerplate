<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>500 Server Error - {{ config('app.name') }}</title>
    <x-theme-script />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-background flex flex-col items-center justify-center text-center p-4">
    <div class="space-y-4">
        <h1 class="text-9xl font-extrabold tracking-tighter text-destructive/20">500</h1>
        <h2 class="text-3xl font-bold tracking-tight">Server Error</h2>
        <p class="text-muted-foreground max-w-[500px]">
            Oops! Something went wrong on our servers. We are working to fix the issue. Please try again later.
        </p>
        <div class="pt-4">
            <x-button onclick="window.location.reload()">
                <svg xmlns="http://www.w3.org/2000/svg" class="size-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                </svg>
                Refresh Page
            </x-button>
        </div>
    </div>
</body>
</html>

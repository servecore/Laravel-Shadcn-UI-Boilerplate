@extends('layouts.guest')

@section('title', 'Verify Email')

@section('content')
<div class="space-y-6">
    {{-- Logo & Title --}}
    <div class="text-center space-y-2">
        <div class="flex justify-center">
            <div class="flex size-12 items-center justify-center rounded-xl bg-primary text-primary-foreground shadow-lg">
                <svg xmlns="http://www.w3.org/2000/svg" class="size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
            </div>
        </div>
        <h1 class="text-2xl font-bold tracking-tight">Check your email</h1>
        <p class="text-muted-foreground">We sent a verification link to<br><strong>demo@example.com</strong></p>
    </div>

    {{-- Info Card --}}
    <x-card>
        <x-card-content class="pt-6 space-y-4">
            <x-alert>
                <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <x-alert-title>Verification required</x-alert-title>
                <x-alert-description>
                    Click the link in your email to verify your account. If you don't see it, check your spam folder.
                </x-alert-description>
            </x-alert>

            {{-- Resend Button --}}
            <form action="#" method="POST">
                <x-button type="submit" variant="outline" class="w-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                    Resend verification email
                </x-button>
            </form>

            {{-- Divider --}}
            <div class="relative">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-border"></div>
                </div>
                <div class="relative flex justify-center text-xs uppercase">
                    <span class="bg-card px-2 text-muted-foreground">Or</span>
                </div>
            </div>

            {{-- Open Email --}}
            <x-button variant="secondary" class="w-full" type="button">
                <svg xmlns="http://www.w3.org/2000/svg" class="size-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                </svg>
                Open email app
            </x-button>
        </x-card-content>
    </x-card>

    {{-- Back to Login --}}
    <p class="text-center">
        <a href="{{ route('demo.login') }}" class="inline-flex items-center gap-2 text-sm text-muted-foreground hover:text-foreground">
            <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Back to login
        </a>
    </p>
</div>
@endsection

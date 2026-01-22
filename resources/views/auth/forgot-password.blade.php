@extends('layouts.guest')

@section('title', 'Forgot Password')

@section('content')
<div class="space-y-6">
    {{-- Logo & Title --}}
    <div class="text-center space-y-2">
        <div class="flex justify-center">
            <div class="flex size-12 items-center justify-center rounded-xl bg-primary text-primary-foreground shadow-lg">
                <svg xmlns="http://www.w3.org/2000/svg" class="size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                </svg>
            </div>
        </div>
        <h1 class="text-2xl font-bold tracking-tight">Forgot password?</h1>
        <p class="text-muted-foreground">No worries, we'll send you reset instructions</p>
    </div>

    {{-- Form Card --}}
    <x-card>
        <x-card-content class="pt-6">
            <form class="space-y-4" action="#" method="POST">
                {{-- Email --}}
                <div class="space-y-2">
                    <x-label for="email">Email</x-label>
                    <x-input 
                        type="email" 
                        id="email" 
                        name="email" 
                        placeholder="name@example.com"
                        required
                    />
                </div>

                {{-- Submit --}}
                <x-button type="submit" class="w-full">
                    Send reset link
                </x-button>
            </form>
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

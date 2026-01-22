@extends('layouts.guest')

@section('title', 'Reset Password')

@section('content')
<div class="space-y-6">
    {{-- Logo & Title --}}
    <div class="text-center space-y-2">
        <div class="flex justify-center">
            <div class="flex size-12 items-center justify-center rounded-xl bg-primary text-primary-foreground shadow-lg">
                <svg xmlns="http://www.w3.org/2000/svg" class="size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
            </div>
        </div>
        <h1 class="text-2xl font-bold tracking-tight">Set new password</h1>
        <p class="text-muted-foreground">Your new password must be different from previous passwords</p>
    </div>

    {{-- Form Card --}}
    <x-card>
        <x-card-content class="pt-6">
            <form class="space-y-4" action="#" method="POST">
                {{-- New Password --}}
                <div class="space-y-2">
                    <x-label for="password">New Password</x-label>
                    <x-input 
                        type="password" 
                        id="password" 
                        name="password" 
                        placeholder="••••••••"
                        required
                    />
                    <p class="text-xs text-muted-foreground">Must be at least 8 characters</p>
                </div>

                {{-- Confirm Password --}}
                <div class="space-y-2">
                    <x-label for="password_confirmation">Confirm Password</x-label>
                    <x-input 
                        type="password" 
                        id="password_confirmation" 
                        name="password_confirmation" 
                        placeholder="••••••••"
                        required
                    />
                </div>

                {{-- Submit --}}
                <x-button type="submit" class="w-full">
                    Reset password
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

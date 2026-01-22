@extends('layouts.guest')

@section('title', 'Register')

@section('content')
<div class="space-y-6">
    {{-- Logo & Title --}}
    <div class="text-center space-y-2">
        <div class="flex justify-center">
            <div class="flex size-12 items-center justify-center rounded-xl bg-primary text-primary-foreground shadow-lg">
                <svg xmlns="http://www.w3.org/2000/svg" class="size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                </svg>
            </div>
        </div>
        <h1 class="text-2xl font-bold tracking-tight">Create an account</h1>
        <p class="text-muted-foreground">Enter your details to get started</p>
    </div>

    {{-- Register Form Card --}}
    <x-card>
        <x-card-content class="pt-6">
            <form class="space-y-4" action="#" method="POST">
                {{-- Name --}}
                <div class="space-y-2">
                    <x-label for="name">Full Name</x-label>
                    <x-input 
                        type="text" 
                        id="name" 
                        name="name" 
                        placeholder="John Doe"
                        required
                    />
                </div>

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

                {{-- Password --}}
                <div class="space-y-2">
                    <x-label for="password">Password</x-label>
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

                {{-- Terms --}}
                <div class="flex items-start gap-2">
                    <x-checkbox id="terms" name="terms" class="mt-0.5" required />
                    <x-label for="terms" class="text-sm font-normal cursor-pointer leading-relaxed">
                        I agree to the 
                        <a href="#" class="text-primary hover:underline">Terms of Service</a> 
                        and 
                        <a href="#" class="text-primary hover:underline">Privacy Policy</a>
                    </x-label>
                </div>

                {{-- Submit --}}
                <x-button type="submit" class="w-full">
                    Create account
                </x-button>
            </form>

            {{-- Divider --}}
            <div class="relative my-6">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-border"></div>
                </div>
                <div class="relative flex justify-center text-xs uppercase">
                    <span class="bg-card px-2 text-muted-foreground">Or continue with</span>
                </div>
            </div>

            {{-- Social Login --}}
            <div class="grid grid-cols-2 gap-3">
                <x-button variant="outline" type="button">
                    <svg class="size-4 mr-2" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12.545,10.239v3.821h5.445c-0.712,2.315-2.647,3.972-5.445,3.972c-3.332,0-6.033-2.701-6.033-6.032s2.701-6.032,6.033-6.032c1.498,0,2.866,0.549,3.921,1.453l2.814-2.814C17.503,2.988,15.139,2,12.545,2C7.021,2,2.543,6.477,2.543,12s4.478,10,10.002,10c8.396,0,10.249-7.85,9.426-11.748L12.545,10.239z"/>
                    </svg>
                    Google
                </x-button>
                <x-button variant="outline" type="button">
                    <svg class="size-4 mr-2" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/>
                    </svg>
                    GitHub
                </x-button>
            </div>
        </x-card-content>
    </x-card>

    {{-- Login Link --}}
    <p class="text-center text-sm text-muted-foreground">
        Already have an account?
        <a href="{{ route('demo.login') }}" class="text-primary hover:underline font-medium">
            Sign in
        </a>
    </p>
</div>
@endsection

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
        <p class="text-muted-foreground">Enter your email and we'll send you a link to get started</p>
    </div>

    @if ($invitationSent)
        {{-- Invitation sent --}}
        <div class="rounded-lg border bg-card p-6 text-center space-y-3">
            <div class="flex size-12 items-center justify-center rounded-full bg-primary/10 text-primary mx-auto">
                <svg xmlns="http://www.w3.org/2000/svg" class="size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M22 2 11 13" />
                    <path d="m22 2-7 20-4-9-9-4Z" />
                </svg>
            </div>
            <h2 class="text-lg font-semibold">Check your email</h2>
            <p class="text-sm text-muted-foreground">
                We sent a registration link to <span class="font-medium text-foreground">{{ $invitationSent }}</span>.
                Click the link to set up your account. The link expires in 1 hour.
            </p>
            <p class="text-xs text-muted-foreground">
                Didn't get it? <a href="{{ route('register') }}" class="text-primary hover:underline">Request another link</a>.
            </p>
        </div>
    @else
        {{-- Register Form Card --}}
        <x-card>
            <x-card-content class="pt-6">
                <form class="space-y-4" action="{{ route('register.store') }}" method="POST">
                    @csrf

                    @if ($errors->any())
                        <x-alert variant="destructive">
                            <x-alert-title>Unable to continue</x-alert-title>
                            <x-alert-description>
                                <ul class="list-disc list-inside space-y-1">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </x-alert-description>
                        </x-alert>
                    @endif

                    {{-- Email --}}
                    <div class="space-y-2">
                        <x-label for="email">Email</x-label>
                        <x-input
                            type="email"
                            id="email"
                            name="email"
                            placeholder="name@example.com"
                            :value="old('email')"
                            required
                            autofocus
                        />
                    </div>

                    {{-- Submit --}}
                    <x-button type="submit" class="w-full">
                        Send registration link
                    </x-button>
                </form>
            </x-card-content>
        </x-card>

        {{-- Login Link --}}
        <p class="text-center text-sm text-muted-foreground">
            Already have an account?
            <a href="{{ route('login') }}" class="text-primary hover:underline font-medium">
                Sign in
            </a>
        </p>
    @endif
</div>
@endsection

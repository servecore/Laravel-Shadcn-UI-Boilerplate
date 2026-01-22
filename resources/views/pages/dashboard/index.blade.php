@extends('layouts.app')

@section('header', 'Dashboard')

@section('content')
<div class="space-y-6">
    {{-- Stats Cards --}}
    <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-4">
        {{-- Total Revenue --}}
        <x-card>
            <x-card-header class="flex flex-row items-center justify-between space-y-0 pb-2">
                <x-card-title class="text-sm font-medium">Total Revenue</x-card-title>
                <svg xmlns="http://www.w3.org/2000/svg" class="size-4 text-muted-foreground" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </x-card-header>
            <x-card-content>
                <div class="text-2xl font-bold">$45,231.89</div>
                <p class="text-xs text-muted-foreground">+20.1% from last month</p>
            </x-card-content>
        </x-card>

        {{-- Subscriptions --}}
        <x-card>
            <x-card-header class="flex flex-row items-center justify-between space-y-0 pb-2">
                <x-card-title class="text-sm font-medium">Subscriptions</x-card-title>
                <svg xmlns="http://www.w3.org/2000/svg" class="size-4 text-muted-foreground" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
            </x-card-header>
            <x-card-content>
                <div class="text-2xl font-bold">+2350</div>
                <p class="text-xs text-muted-foreground">+180.1% from last month</p>
            </x-card-content>
        </x-card>

        {{-- Sales --}}
        <x-card>
            <x-card-header class="flex flex-row items-center justify-between space-y-0 pb-2">
                <x-card-title class="text-sm font-medium">Sales</x-card-title>
                <svg xmlns="http://www.w3.org/2000/svg" class="size-4 text-muted-foreground" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                </svg>
            </x-card-header>
            <x-card-content>
                <div class="text-2xl font-bold">+12,234</div>
                <p class="text-xs text-muted-foreground">+19% from last month</p>
            </x-card-content>
        </x-card>

        {{-- Active Now --}}
        <x-card>
            <x-card-header class="flex flex-row items-center justify-between space-y-0 pb-2">
                <x-card-title class="text-sm font-medium">Active Now</x-card-title>
                <svg xmlns="http://www.w3.org/2000/svg" class="size-4 text-muted-foreground" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                </svg>
            </x-card-header>
            <x-card-content>
                <div class="text-2xl font-bold">+573</div>
                <p class="text-xs text-muted-foreground">+201 since last hour</p>
            </x-card-content>
        </x-card>
    </div>

    <div class="grid gap-6 md:grid-cols-7">
        {{-- Overview Chart Placeholder --}}
        <x-card class="col-span-4">
            <x-card-header>
                <x-card-title>Overview</x-card-title>
            </x-card-header>
            <x-card-content class="pl-2">
                <div class="h-[350px] w-full bg-muted/20 rounded-md flex items-center justify-center text-muted-foreground">
                    Chart Placeholder
                </div>
            </x-card-content>
        </x-card>

        {{-- Recent Sales --}}
        <x-card class="col-span-3">
            <x-card-header>
                <x-card-title>Recent Sales</x-card-title>
                <x-card-description>You made 265 sales this month.</x-card-description>
            </x-card-header>
            <x-card-content>
                <div class="space-y-8">
                    <div class="flex items-center">
                        <x-avatar class="h-9 w-9">
                            <x-avatar-image src="https://i.pravatar.cc/150?u=1" alt="Avatar" />
                            <x-avatar-fallback>OM</x-avatar-fallback>
                        </x-avatar>
                        <div class="ml-4 space-y-1">
                            <p class="text-sm font-medium leading-none">Olivia Martin</p>
                            <p class="text-xs text-muted-foreground">olivia.martin@email.com</p>
                        </div>
                        <div class="ml-auto font-medium">+$1,999.00</div>
                    </div>
                    <div class="flex items-center">
                        <x-avatar class="h-9 w-9">
                            <x-avatar-image src="https://i.pravatar.cc/150?u=2" alt="Avatar" />
                            <x-avatar-fallback>JL</x-avatar-fallback>
                        </x-avatar>
                        <div class="ml-4 space-y-1">
                            <p class="text-sm font-medium leading-none">Jackson Lee</p>
                            <p class="text-xs text-muted-foreground">jackson.lee@email.com</p>
                        </div>
                        <div class="ml-auto font-medium">+$39.00</div>
                    </div>
                    <div class="flex items-center">
                        <x-avatar class="h-9 w-9">
                            <x-avatar-image src="https://i.pravatar.cc/150?u=3" alt="Avatar" />
                            <x-avatar-fallback>IN</x-avatar-fallback>
                        </x-avatar>
                        <div class="ml-4 space-y-1">
                            <p class="text-sm font-medium leading-none">Isabella Nguyen</p>
                            <p class="text-xs text-muted-foreground">isabella.nguyen@email.com</p>
                        </div>
                        <div class="ml-auto font-medium">+$299.00</div>
                    </div>
                    <div class="flex items-center">
                        <x-avatar class="h-9 w-9">
                            <x-avatar-image src="https://i.pravatar.cc/150?u=4" alt="Avatar" />
                            <x-avatar-fallback>WK</x-avatar-fallback>
                        </x-avatar>
                        <div class="ml-4 space-y-1">
                            <p class="text-sm font-medium leading-none">William Kim</p>
                            <p class="text-xs text-muted-foreground">will@email.com</p>
                        </div>
                        <div class="ml-auto font-medium">+$99.00</div>
                    </div>
                </div>
            </x-card-content>
        </x-card>
    </div>
</div>
@endsection

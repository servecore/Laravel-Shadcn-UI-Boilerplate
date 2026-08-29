@extends('layouts.app')

@section('header', 'App Settings')

@section('content')
<div class="max-w-4xl space-y-6">
    @if(session('status'))
        <x-alert>
            <x-alert-title>Success</x-alert-title>
            <x-alert-description>{{ session('status') }}</x-alert-description>
        </x-alert>
    @endif

    <div>
        <h3 class="text-lg font-medium">Notifications</h3>
        <p class="text-sm text-muted-foreground">Configure how you receive notifications.</p>
    </div>
    
    <x-separator.separator />

    <form method="POST" action="{{ route('settings.update') }}">
        @csrf
        @method('PUT')

        <div class="space-y-4">
            <h4 class="text-sm font-medium">Email Notifications</h4>
            <div class="grid gap-4">
                <div class="flex items-center justify-between rounded-lg border p-4">
                    <div class="space-y-0.5">
                        <x-label class="text-base" for="comm_emails">Communication emails</x-label>
                        <p class="text-sm text-muted-foreground">Receive emails about your account activity.</p>
                    </div>
                    <x-switch.switch id="comm_emails" name="comm_emails" :checked="session('settings.comm_emails', true)" />
                </div>
                
                <div class="flex items-center justify-between rounded-lg border p-4">
                    <div class="space-y-0.5">
                        <x-label class="text-base" for="marketing_emails">Marketing emails</x-label>
                        <p class="text-sm text-muted-foreground">Receive emails about new products, features, and more.</p>
                    </div>
                    <x-switch.switch id="marketing_emails" name="marketing_emails" :checked="session('settings.marketing_emails', false)" />
                </div>

                <div class="flex items-center justify-between rounded-lg border p-4">
                    <div class="space-y-0.5">
                        <x-label class="text-base" for="social_emails">Social emails</x-label>
                        <p class="text-sm text-muted-foreground">Receive emails for friend requests, follows, and more.</p>
                    </div>
                    <x-switch.switch id="social_emails" name="social_emails" :checked="session('settings.social_emails', true)" />
                </div>

                <div class="flex items-center justify-between rounded-lg border p-4">
                    <div class="space-y-0.5">
                        <x-label class="text-base" for="security_emails">Security emails</x-label>
                        <p class="text-sm text-muted-foreground">Receive emails about your account security.</p>
                    </div>
                    <x-switch.switch id="security_emails" name="security_emails" :checked="true" :disabled="true" />
                </div>
            </div>
        </div>

        <div class="flex justify-end gap-2 mt-6">
             <x-button variant="outline" type="button">Cancel</x-button>
             <x-button type="submit">Save preferences</x-button>
        </div>
    </form>
</div>
@endsection

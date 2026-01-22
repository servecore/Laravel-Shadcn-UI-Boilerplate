@extends('layouts.app')

@section('header', 'App Settings')

@section('content')
<div class="max-w-4xl space-y-6">
    <div>
        <h3 class="text-lg font-medium">Notifications</h3>
        <p class="text-sm text-muted-foreground">Configure how you receive notifications.</p>
    </div>
    
    <x-separator.separator />

    <div class="space-y-4">
        <h4 class="text-sm font-medium">Email Notifications</h4>
        <div class="grid gap-4">
            <div class="flex items-center justify-between rounded-lg border p-4">
                <div class="space-y-0.5">
                    <x-label class="text-base">Communication emails</x-label>
                    <p class="text-sm text-muted-foreground">Receive emails about your account activity.</p>
                </div>
                <x-switch.switch id="comm-emails" checked />
            </div>
            
            <div class="flex items-center justify-between rounded-lg border p-4">
                <div class="space-y-0.5">
                    <x-label class="text-base">Marketing emails</x-label>
                    <p class="text-sm text-muted-foreground">Receive emails about new products, features, and more.</p>
                </div>
                <x-switch.switch id="marketing-emails" />
            </div>

            <div class="flex items-center justify-between rounded-lg border p-4">
                <div class="space-y-0.5">
                    <x-label class="text-base">Social emails</x-label>
                    <p class="text-sm text-muted-foreground">Receive emails for friend requests, follows, and more.</p>
                </div>
                <x-switch.switch id="social-emails" checked />
            </div>

            <div class="flex items-center justify-between rounded-lg border p-4">
                <div class="space-y-0.5">
                    <x-label class="text-base">Security emails</x-label>
                    <p class="text-sm text-muted-foreground">Receive emails about your account security.</p>
                </div>
                <x-switch.switch id="security-emails" checked disabled />
            </div>
        </div>
    </div>

    <div class="flex justify-end gap-2">
         <x-button variant="outline">Cancel</x-button>
         <x-button>Save preferences</x-button>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('header', 'Settings')

@section('content')
<div class="max-w-4xl space-y-6">
    <div class="space-y-0.5">
        <h2 class="text-2xl font-bold tracking-tight">Settings</h2>
        <p class="text-muted-foreground">Manage your account settings and preferences.</p>
    </div>
    
    <x-separator.separator class="my-6" />

    <div class="flex flex-col space-y-8 lg:flex-row lg:space-x-12 lg:space-y-0">
        {{-- Sidebar Navigation --}}
        <aside class="-mx-4 lg:w-1/5">
            <nav class="flex space-x-2 lg:flex-col lg:space-x-0 lg:space-y-1">
                <a href="#" class="inline-flex items-center rounded-md bg-muted px-3 py-2 text-sm font-medium hover:bg-muted">
                    Profile
                </a>
                <a href="#" class="inline-flex items-center rounded-md px-3 py-2 text-sm font-medium hover:bg-transparent hover:underline hover:decoration-primary">
                    Account
                </a>
                <a href="#" class="inline-flex items-center rounded-md px-3 py-2 text-sm font-medium hover:bg-transparent hover:underline hover:decoration-primary">
                    Appearance
                </a>
                <a href="#" class="inline-flex items-center rounded-md px-3 py-2 text-sm font-medium hover:bg-transparent hover:underline hover:decoration-primary">
                    Notifications
                </a>
            </nav>
        </aside>

        {{-- Content --}}
        <div class="flex-1 lg:max-w-2xl">
            <div class="space-y-6">
                <div>
                    <h3 class="text-lg font-medium">Profile</h3>
                    <p class="text-sm text-muted-foreground">This is how others will see you on the site.</p>
                </div>
                
                <x-separator.separator />

                <form class="space-y-8">
                    {{-- Username --}}
                    <div class="space-y-2">
                        <x-label for="username">Username</x-label>
                        <x-input id="username" placeholder="shadcn" value="shadcn" />
                        <p class="text-[0.8rem] text-muted-foreground">This is your public display name.</p>
                    </div>

                    {{-- Email --}}
                    <div class="space-y-2">
                        <x-label for="email">Email</x-label>
                        <x-select.select>
                            <x-select.trigger class="w-[300px]">
                                <x-select.value placeholder="Select a verified email" />
                            </x-select.trigger>
                            <x-select.content>
                                <x-select.item value="m@example.com">m@example.com</x-select.item>
                                <x-select.item value="m@google.com">m@google.com</x-select.item>
                                <x-select.item value="m@support.com">m@support.com</x-select.item>
                            </x-select.content>
                        </x-select.select>
                        <p class="text-[0.8rem] text-muted-foreground">You can manage verified email addresses in your <a href="#" class="text-primary hover:underline">email settings</a>.</p>
                    </div>

                    {{-- Bio --}}
                    <div class="space-y-2">
                        <x-label for="bio">Bio</x-label>
                        <x-textarea.textarea id="bio" placeholder="Tell us a little bit about yourself" class="resize-none" />
                        <p class="text-[0.8rem] text-muted-foreground">You can <span>@mention</span> other users and organizations.</p>
                    </div>

                    {{-- URLs --}}
                    <div class="space-y-2">
                        <x-label for="url">URLs</x-label>
                        <div class="space-y-2">
                            <x-input id="url" value="https://shadcn.com" />
                            <x-input id="url-2" value="http://twitter.com/shadcn" />
                        </div>
                        <p class="text-[0.8rem] text-muted-foreground">Add links to your website, blog, or social media profiles.</p>
                    </div>

                    <x-button type="submit">Update profile</x-button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

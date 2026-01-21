<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Custom Components Test</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="p-10 space-y-10">
    <h1 class="text-3xl font-bold">Custom Components Verification</h1>

    <!-- 1. DIALOG TEST -->
    <section class="space-y-4">
        <h2 class="text-2xl font-semibold border-b pb-2">1. Dialog (Modal)</h2>
        <x-dialog>
            <x-dialog-trigger>
                <x-button>Open Modal</x-button>
            </x-dialog-trigger>
            <x-dialog-content>
                <x-dialog-header>
                    <x-dialog-title>Edit Profile</x-dialog-title>
                    <x-dialog-description>
                        Make changes to your profile here. Click save when you're done.
                    </x-dialog-description>
                </x-dialog-header>
                <div class="py-4">
                    <p>Modal content goes here...</p>
                </div>
                <x-dialog-footer>
                    <x-dialog-close>
                        <x-button variant="outline">Cancel</x-button>
                    </x-dialog-close>
                    <x-button>Save changes</x-button>
                </x-dialog-footer>
            </x-dialog-content>
        </x-dialog>
    </section>

    <!-- 2. TABS TEST -->
    <section class="space-y-4">
        <h2 class="text-2xl font-semibold border-b pb-2">2. Tabs</h2>
        <x-tabs default-value="account" class="w-[400px]">
            <x-tabs-list class="grid w-full grid-cols-2">
                <x-tabs-trigger value="account">Account</x-tabs-trigger>
                <x-tabs-trigger value="password">Password</x-tabs-trigger>
            </x-tabs-list>
            <x-tabs-content value="account">
                <div class="p-4 border rounded-md mt-2">
                    <h3 class="font-bold">Account Tab</h3>
                    <p>Manage your account settings here.</p>
                </div>
            </x-tabs-content>
            <x-tabs-content value="password">
                <div class="p-4 border rounded-md mt-2">
                    <h3 class="font-bold">Password Tab</h3>
                    <p>Change your password here.</p>
                </div>
            </x-tabs-content>
        </x-tabs>
    </section>

    <!-- 3. PROGRESS TEST -->
    <section class="space-y-4">
        <h2 class="text-2xl font-semibold border-b pb-2">3. Progress</h2>
        <div class="w-[60%] space-y-2">
            <p>Progress: 33%</p>
            <x-progress value="33" max="100" />
            
            <p>Progress: 66%</p>
            <x-progress value="66" max="100" />

            <p>Progress: 100%</p>
            <x-progress value="100" max="100" />
        </div>
    </section>

</body>
</html>

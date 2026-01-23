<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ShadCN UI Components Preview</title>
    <x-theme-script />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-background text-foreground p-6">
    <div class="max-w-6xl mx-auto space-y-12">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-4xl font-bold">ShadCN UI Components Preview</h1>
            <x-theme-toggle />
        </div>

        <!-- Jumbotron / Hero Section -->
        <section class="space-y-8">
            <h2 class="text-2xl font-semibold">Jumbotron / Hero Examples</h2>
            
            <!-- Example 1: Simple Centered Hero -->
            <div class="py-12 md:py-24 lg:py-32 text-center rounded-lg border bg-card text-card-foreground shadow-sm">
                <div class="container px-4 md:px-6 mx-auto">
                    <div class="flex flex-col items-center space-y-4 text-center">
                        <div class="space-y-2">
                            <h1 class="text-3xl font-bold tracking-tighter sm:text-4xl md:text-5xl lg:text-6xl/none">
                                Build your next idea
                            </h1>
                            <p class="mx-auto max-w-[700px] text-muted-foreground md:text-xl">
                                Beautifully designed components built with Radix UI and Tailwind CSS. Open source and customizable.
                            </p>
                        </div>
                        <div class="space-x-4">
                            <x-button size="lg">Get Started</x-button>
                            <x-button variant="outline" size="lg">Learn More</x-button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Example 2: Gradient Card Hero -->
            <div class="relative overflow-hidden rounded-lg border bg-background p-8 md:p-12 lg:p-16">
                <div class="absolute inset-0 z-0 bg-gradient-to-br from-purple-500/10 via-pink-500/10 to-blue-500/10 dark:from-purple-900/20 dark:via-pink-900/20 dark:to-blue-900/20"></div>
                <div class="relative z-10 flex flex-col md:flex-row items-center gap-8">
                    <div class="flex-1 space-y-4">
                        <div class="inline-block rounded-lg bg-muted px-3 py-1 text-sm font-medium">
                            New Feature
                        </div>
                        <h2 class="text-3xl font-bold tracking-tighter sm:text-4xl md:text-5xl">
                            Supercharge your workflow
                        </h2>
                        <p class="text-muted-foreground md:text-xl">
                            Unlock the power of automated tools and streamline your development process today.
                        </p>
                        <div class="flex flex-col sm:flex-row gap-3">
                            <x-button size="lg" class="gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                                Start Now
                            </x-button>
                            <x-button variant="ghost" size="lg" class="gap-2">
                                Watch Demo 
                                <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </x-button>
                        </div>
                    </div>
                    <div class="flex-1 w-full max-w-sm lg:max-w-md">
                         <div class="aspect-video rounded-xl bg-muted/50 border flex items-center justify-center p-6 shadow-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-16 text-muted-foreground/50" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                         </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Navbar / Navigation Examples -->
        <section class="space-y-8">
            <h2 class="text-2xl font-semibold">Navbar / Navigation Examples</h2>
            
            <!-- Example 1: Simple Navbar -->
            <div class="rounded-lg border bg-background shadow-sm">
                <x-navbar.simple />
            </div>

            <!-- Example 2: Dashboard Navbar -->
            <div class="rounded-lg border bg-background shadow-sm">
                <x-navbar.dashboard />
            </div>
        </section>

        <!-- Offcanvas / Sheet Examples -->
        <section class="space-y-8">
            <h2 class="text-2xl font-semibold">Offcanvas / Sheet Examples</h2>
            
            <div class="flex flex-wrap gap-4">
                <!-- Right Side (Default) -->
                <x-sheet.sheet>
                    <x-sheet.trigger>
                        <x-button variant="outline">Open Right (Default)</x-button>
                    </x-sheet.trigger>
                    <x-sheet.content>
                        <x-sheet.header>
                            <x-sheet.title>Edit Profile</x-sheet.title>
                            <x-sheet.description>Make changes to your profile here. Click save when you're done.</x-sheet.description>
                        </x-sheet.header>
                        <div class="grid gap-4 py-4">
                            <div class="grid grid-cols-4 items-center gap-4">
                                <label for="sheet-name" class="text-right text-sm">Name</label>
                                <input id="sheet-name" value="Pedro Duarte" class="col-span-3 h-9 rounded-md border border-input bg-transparent px-3 py-1 text-sm shadow-sm transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring" />
                            </div>
                            <div class="grid grid-cols-4 items-center gap-4">
                                <label for="sheet-username" class="text-right text-sm">Username</label>
                                <input id="sheet-username" value="@peduarte" class="col-span-3 h-9 rounded-md border border-input bg-transparent px-3 py-1 text-sm shadow-sm transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring" />
                            </div>
                        </div>
                        <x-sheet.footer>
                            <x-button type="submit">Save changes</x-button>
                        </x-sheet.footer>
                    </x-sheet.content>
                </x-sheet.sheet>

                <!-- Left Side -->
                <x-sheet.sheet>
                    <x-sheet.trigger>
                        <x-button variant="outline">Open Left</x-button>
                    </x-sheet.trigger>
                    <x-sheet.content side="left">
                        <x-sheet.header>
                            <x-sheet.title>Sidebar Menu</x-sheet.title>
                            <x-sheet.description>This is ideal for mobile navigation.</x-sheet.description>
                        </x-sheet.header>
                        <div class="py-4">
                            <ul class="space-y-2">
                                <li><a href="#" class="block p-2 hover:bg-muted rounded-md">Home</a></li>
                                <li><a href="#" class="block p-2 hover:bg-muted rounded-md">Settings</a></li>
                                <li><a href="#" class="block p-2 hover:bg-muted rounded-md">Logout</a></li>
                            </ul>
                        </div>
                    </x-sheet.content>
                </x-sheet.sheet>

                <!-- Top Side -->
                <x-sheet.sheet>
                    <x-sheet.trigger>
                        <x-button variant="outline">Open Top</x-button>
                    </x-sheet.trigger>
                    <x-sheet.content side="top">
                        <x-sheet.header>
                            <x-sheet.title>Top Notification</x-sheet.title>
                            <x-sheet.description>A quick message from the top.</x-sheet.description>
                        </x-sheet.header>
                    </x-sheet.content>
                </x-sheet.sheet>

                <!-- Bottom Side -->
                <x-sheet.sheet>
                    <x-sheet.trigger>
                        <x-button variant="outline">Open Bottom</x-button>
                    </x-sheet.trigger>
                    <x-sheet.content side="bottom">
                        <x-sheet.header>
                            <x-sheet.title>Bottom Sheet</x-sheet.title>
                            <x-sheet.description>Useful for mobile actions.</x-sheet.description>
                        </x-sheet.header>
                        <div class="py-4 flex justify-center gap-4">
                            <x-button variant="secondary" class="w-full">Cancel</x-button>
                            <x-button class="w-full">Confirm</x-button>
                        </div>
                    </x-sheet.content>
                </x-sheet.sheet>
            </div>
        </section>

        <!-- Button -->
        <section class="space-y-4">
            <h2 class="text-2xl font-semibold">Button</h2>
            
            <!-- Variants -->
            <div>
                <h3 class="text-lg font-medium mb-2 text-muted-foreground">Variants</h3>
                <div class="flex flex-wrap gap-4">
                    <x-button variant="default">Default</x-button>
                    <x-button variant="destructive">Destructive</x-button>
                    <x-button variant="outline">Outline</x-button>
                    <x-button variant="secondary">Secondary</x-button>
                    <x-button variant="ghost">Ghost</x-button>
                    <x-button variant="link">Link</x-button>
                </div>
            </div>
            
            <!-- Sizes -->
            <div>
                <h3 class="text-lg font-medium mb-2 text-muted-foreground">Sizes</h3>
                <div class="flex flex-wrap items-center gap-4">
                    <x-button size="sm">Small</x-button>
                    <x-button size="default">Default</x-button>
                    <x-button size="lg">Large</x-button>
                    <x-button size="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                    </x-button>
                </div>
            </div>
            
            <!-- With Icons -->
            <div>
                <h3 class="text-lg font-medium mb-2 text-muted-foreground">With Icons</h3>
                <div class="flex flex-wrap gap-4">
                    <x-button>
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Add New
                    </x-button>
                    <x-button variant="secondary">
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                        </svg>
                        Upload
                    </x-button>
                    <x-button variant="outline">
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                        </svg>
                        Download
                    </x-button>
                    <x-button variant="destructive">
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        Delete
                    </x-button>
                </div>
            </div>
            
            <!-- Custom Colors (using class override) -->
            <div>
                <h3 class="text-lg font-medium mb-2 text-muted-foreground">Custom Colors</h3>
                <div class="flex flex-wrap gap-4">
                    <x-button class="!bg-green-600 hover:!bg-green-700 text-white">Success</x-button>
                    <x-button class="!bg-yellow-500 hover:!bg-yellow-600 text-black">Warning</x-button>
                    <x-button class="!bg-blue-500 hover:!bg-blue-600 text-white">Info</x-button>
                    <x-button class="!bg-purple-600 hover:!bg-purple-700 text-white">Purple</x-button>
                    <x-button class="!bg-pink-500 hover:!bg-pink-600 text-white">Pink</x-button>
                    <x-button class="!bg-orange-500 hover:!bg-orange-600 text-white">Orange</x-button>
                    <x-button class="!bg-teal-500 hover:!bg-teal-600 text-white">Teal</x-button>
                    <x-button class="bg-gradient-to-r from-purple-500 to-pink-500 hover:from-purple-600 hover:to-pink-600 text-white border-none">Gradient</x-button>
                </div>
            </div>
            
            <!-- States -->
            <div>
                <h3 class="text-lg font-medium mb-2 text-muted-foreground">States</h3>
                <div class="flex flex-wrap gap-4">
                    <x-button disabled>Disabled</x-button>
                    <x-button loading="true">Loading</x-button>
                </div>
            </div>
        </section>

        <!-- Badge -->
        <section class="space-y-4">
            <h2 class="text-2xl font-semibold">Badge</h2>
            <div class="flex flex-wrap gap-4">
                <x-badge>Default</x-badge>
                <x-badge variant="secondary">Secondary</x-badge>
                <x-badge variant="destructive">Destructive</x-badge>
                <x-badge variant="outline">Outline</x-badge>
            </div>
        </section>

        <!-- Card -->
        <section class="space-y-4">
            <h2 class="text-2xl font-semibold">Card</h2>
            <x-card class="w-full max-w-md">
                <x-card-header>
                    <x-card-title>Card Title</x-card-title>
                    <x-card-description>Card description goes here.</x-card-description>
                </x-card-header>
                <x-card-content>
                    <p>This is the card content.</p>
                </x-card-content>
                <x-card-footer>
                    <x-button>Action</x-button>
                </x-card-footer>
            </x-card>
        </section>

        <!-- Alert -->
        <section class="space-y-4">
            <h2 class="text-2xl font-semibold">Alert</h2>
            <x-alert>
                <x-alert-title>Alert Title</x-alert-title>
                <x-alert-description>This is an alert description.</x-alert-description>
            </x-alert>
            <x-alert variant="destructive">
                <x-alert-title>Error</x-alert-title>
                <x-alert-description>Something went wrong!</x-alert-description>
            </x-alert>
        </section>

        <!-- Input -->
        <section class="space-y-4">
            <h2 class="text-2xl font-semibold">Input</h2>
            <div class="space-y-2">
                <x-label for="email">Email</x-label>
                <x-input id="email" type="email" placeholder="Enter your email" />
            </div>
            <div class="space-y-2">
                <x-label for="password">Password</x-label>
                <x-input id="password" type="password" placeholder="Enter your password" />
            </div>
        </section>

        <!-- Label -->
        <section class="space-y-4">
            <h2 class="text-2xl font-semibold">Label</h2>
            <x-label>Label Example</x-label>
        </section>

        <!-- Checkbox -->
        <section class="space-y-4">
            <h2 class="text-2xl font-semibold">Checkbox</h2>
            <div class="flex items-center space-x-2">
                <x-checkbox id="terms" />
                <x-label for="terms">Accept terms and conditions</x-label>
            </div>
            <div class="flex items-center space-x-2">
                <x-checkbox id="newsletter" checked />
                <x-label for="newsletter">Subscribe to newsletter</x-label>
            </div>
        </section>

        <!-- Radio Group -->
        <section class="space-y-4">
            <h2 class="text-2xl font-semibold">Radio Group</h2>
            <x-radio-group value="option1">
                <div class="flex items-center space-x-2">
                    <x-radio-group-item value="option1" id="option1" />
                    <x-label for="option1">Option 1</x-label>
                </div>
                <div class="flex items-center space-x-2">
                    <x-radio-group-item value="option2" id="option2" />
                    <x-label for="option2">Option 2</x-label>
                </div>
                <div class="flex items-center space-x-2">
                    <x-radio-group-item value="option3" id="option3" />
                    <x-label for="option3">Option 3</x-label>
                </div>
            </x-radio-group>
        </section>

        <!-- Avatar -->
        <section class="space-y-4">
            <h2 class="text-2xl font-semibold">Avatar</h2>
            <x-avatar>
                <x-avatar-image src="https://github.com/shadcn.png" alt="Avatar" />
                <x-avatar-fallback>CN</x-avatar-fallback>
            </x-avatar>
        </section>

        <!-- Breadcrumb -->
        <section class="space-y-4">
            <h2 class="text-2xl font-semibold">Breadcrumb</h2>
            <x-breadcrumb>
                <x-breadcrumb-list>
                    <x-breadcrumb-item>
                        <x-breadcrumb-link href="/">Home</x-breadcrumb-link>
                    </x-breadcrumb-item>
                    <x-breadcrumb-separator />
                    <x-breadcrumb-item>
                        <x-breadcrumb-link href="/components">Components</x-breadcrumb-link>
                    </x-breadcrumb-item>
                    <x-breadcrumb-separator />
                    <x-breadcrumb-item>
                        <x-breadcrumb-page>Breadcrumb</x-breadcrumb-page>
                    </x-breadcrumb-item>
                </x-breadcrumb-list>
            </x-breadcrumb>
        </section>

        <!-- Accordion -->
        <section class="space-y-4">
            <h2 class="text-2xl font-semibold">Accordion</h2>
            <x-accordion type="single" collapsible>
                <x-accordion-item value="item-1">
                    <x-accordion-trigger>Is it accessible?</x-accordion-trigger>
                    <x-accordion-content>
                        Yes. It adheres to the WAI-ARIA design pattern.
                    </x-accordion-content>
                </x-accordion-item>
                <x-accordion-item value="item-2">
                    <x-accordion-trigger>Is it styled?</x-accordion-trigger>
                    <x-accordion-content>
                        Yes. It comes with default styles that match the other components' aesthetic.
                    </x-accordion-content>
                </x-accordion-item>
                <x-accordion-item value="item-3">
                    <x-accordion-trigger>Is it animated?</x-accordion-trigger>
                    <x-accordion-content>
                        Yes. It's animated by default, but you can disable it if you prefer.
                    </x-accordion-content>
                </x-accordion-item>
            </x-accordion>
        </section>

        <!-- Collapsible -->
        <section class="space-y-4">
            <h2 class="text-2xl font-semibold">Collapsible</h2>
            <x-collapsible>
                <x-collapsible-trigger>Can I use this in my project?</x-collapsible-trigger>
                <x-collapsible-content>
                    Yes. Free to use for personal and commercial projects. No attribution required.
                </x-collapsible-content>
            </x-collapsible>
        </section>

        <!-- Aspect Ratio -->
        <section class="space-y-4">
            <h2 class="text-2xl font-semibold">Aspect Ratio</h2>
            <x-aspect-ratio :ratio="16/9" class="bg-muted">
                <img src="https://images.unsplash.com/photo-1588345921523-c2dcdb7f1dcd?w=800&dpr=2&q=80" alt="Photo by Drew Beamer" class="rounded-md object-cover w-full h-full" />
            </x-aspect-ratio>
        </section>

        <!-- Carousel -->
        <section class="space-y-4">
            <h2 class="text-2xl font-semibold">Carousel</h2>
            <x-carousel class="w-full max-w-xs">
                <x-carousel-content>
                    <x-carousel-item>Slide 1</x-carousel-item>
                    <x-carousel-item>Slide 2</x-carousel-item>
                    <x-carousel-item>Slide 3</x-carousel-item>
                </x-carousel-content>
                <x-carousel-previous />
                <x-carousel-next />
            </x-carousel>
        </section>

        <!-- Dialog -->
        <section class="space-y-4">
            <h2 class="text-2xl font-semibold">Dialog</h2>
            <x-dialog>
                <x-dialog-trigger>
                    <x-button>Open Dialog</x-button>
                </x-dialog-trigger>
                <x-dialog-content>
                    <x-dialog-header>
                        <x-dialog-title>Are you sure absolutely sure?</x-dialog-title>
                        <x-dialog-description>
                            This action cannot be undone. This will permanently delete your account
                            and remove your data from our servers.
                        </x-dialog-description>
                    </x-dialog-header>
                    <x-dialog-footer>
                        <x-dialog-close>
                            <x-button variant="outline">Cancel</x-button>
                        </x-dialog-close>
                        <x-dialog-close>
                            <x-button variant="destructive">Delete Account</x-button>
                        </x-dialog-close>
                    </x-dialog-footer>
                </x-dialog-content>
            </x-dialog>
        </section>

        <!-- Select -->
        <section class="space-y-4">
            <h2 class="text-2xl font-semibold">Select</h2>
            <x-select.select>
                <x-select.trigger class="w-[180px]">
                    <x-select.value placeholder="Select a fruit" />
                </x-select.trigger>
                <x-select.content>
                    <x-select.item value="apple">Apple</x-select.item>
                    <x-select.item value="banana">Banana</x-select.item>
                    <x-select.item value="blueberry">Blueberry</x-select.item>
                    <x-select.item value="grapes">Grapes</x-select.item>
                    <x-select.item value="pineapple">Pineapple</x-select.item>
                </x-select.content>
            </x-select.select>
        </section>

        <!-- Progress -->
        <section class="space-y-4">
            <h2 class="text-2xl font-semibold">Progress</h2>
            <x-progress :value="33" class="w-[60%]" />
            <x-progress :value="66" class="w-[60%]" />
            <x-progress :value="100" class="w-[60%]" />
        </section>

        <!-- Tabs -->
        <section class="space-y-4">
            <h2 class="text-2xl font-semibold">Tabs</h2>
            <x-tabs default-value="account" class="w-[400px]">
                <x-tabs-list class="grid w-full grid-cols-2">
                    <x-tabs-trigger value="account">Account</x-tabs-trigger>
                    <x-tabs-trigger value="password">Password</x-tabs-trigger>
                </x-tabs-list>
                <x-tabs-content value="account">
                    <x-card>
                        <x-card-header>
                            <x-card-title>Account</x-card-title>
                            <x-card-description>
                                Make changes to your account here. Click save when you're done.
                            </x-card-description>
                        </x-card-header>
                        <x-card-content class="space-y-2">
                            <div class="space-y-1">
                                <x-label for="account-name">Name</x-label>
                                <x-input id="account-name" default-value="Pedro Duarte" />
                            </div>
                            <div class="space-y-1">
                                <x-label for="account-username">Username</x-label>
                                <x-input id="account-username" default-value="@peduarte" />
                            </div>
                        </x-card-content>
                        <x-card-footer>
                            <x-button>Save changes</x-button>
                        </x-card-footer>
                    </x-card>
                </x-tabs-content>
                <x-tabs-content value="password">
                    <x-card>
                        <x-card-header>
                            <x-card-title>Password</x-card-title>
                            <x-card-description>
                                Change your password here. After saving, you'll be logged out.
                            </x-card-description>
                        </x-card-header>
                        <x-card-content class="space-y-2">
                            <div class="space-y-1">
                                <x-label for="current">Current password</x-label>
                                <x-input id="current" type="password" />
                            </div>
                            <div class="space-y-1">
                                <x-label for="new">New password</x-label>
                                <x-input id="new" type="password" />
                            </div>
                        </x-card-content>
                        <x-card-footer>
                            <x-button>Save password</x-button>
                        </x-card-footer>
                    </x-card>
                </x-tabs-content>
            </x-tabs>
        </section>

        <!-- ============================================= -->
        <!-- NEW COMPONENTS added 22 Januari 2026 -->
        <!-- ============================================= -->

        <div class="border-t border-border pt-8 mt-8">
            <h2 class="text-3xl font-bold mb-8 text-primary">✨ New Components (22 Januari 2026)</h2>
        </div>

        <!-- Table -->
        <section class="space-y-4">
            <h2 class="text-2xl font-semibold">Table</h2>
            <x-table.table>
                <x-table.caption>A list of your recent invoices.</x-table.caption>
                <x-table.header>
                    <x-table.row>
                        <x-table.head class="w-[100px]">Invoice</x-table.head>
                        <x-table.head>Status</x-table.head>
                        <x-table.head>Method</x-table.head>
                        <x-table.head class="text-right">Amount</x-table.head>
                    </x-table.row>
                </x-table.header>
                <x-table.body>
                    <x-table.row>
                        <x-table.cell class="font-medium">INV001</x-table.cell>
                        <x-table.cell><x-badge variant="secondary">Paid</x-badge></x-table.cell>
                        <x-table.cell>Credit Card</x-table.cell>
                        <x-table.cell class="text-right">$250.00</x-table.cell>
                    </x-table.row>
                    <x-table.row>
                        <x-table.cell class="font-medium">INV002</x-table.cell>
                        <x-table.cell><x-badge>Pending</x-badge></x-table.cell>
                        <x-table.cell>PayPal</x-table.cell>
                        <x-table.cell class="text-right">$150.00</x-table.cell>
                    </x-table.row>
                    <x-table.row>
                        <x-table.cell class="font-medium">INV003</x-table.cell>
                        <x-table.cell><x-badge variant="destructive">Unpaid</x-badge></x-table.cell>
                        <x-table.cell>Bank Transfer</x-table.cell>
                        <x-table.cell class="text-right">$350.00</x-table.cell>
                    </x-table.row>
                </x-table.body>
                <x-table.footer>
                    <x-table.row>
                        <x-table.cell colspan="3">Total</x-table.cell>
                        <x-table.cell class="text-right font-bold">$750.00</x-table.cell>
                    </x-table.row>
                </x-table.footer>
            </x-table.table>
        </section>

        <!-- Skeleton -->
        <section class="space-y-4">
            <h2 class="text-2xl font-semibold">Skeleton</h2>
            <div class="flex items-center space-x-4">
                <x-skeleton.skeleton class="h-12 w-12 rounded-full" />
                <div class="space-y-2">
                    <x-skeleton.skeleton class="h-4 w-[250px]" />
                    <x-skeleton.skeleton class="h-4 w-[200px]" />
                </div>
            </div>
            <div class="space-y-2">
                <x-skeleton.skeleton class="h-4 w-full" />
                <x-skeleton.skeleton class="h-4 w-3/4" />
                <x-skeleton.skeleton class="h-4 w-1/2" />
            </div>
        </section>

        <!-- Switch -->
        <section class="space-y-4">
            <h2 class="text-2xl font-semibold">Switch</h2>
            <div class="flex flex-col gap-4">
                <div class="flex items-center space-x-2">
                    <x-switch.switch name="airplane" />
                    <x-label>Airplane Mode</x-label>
                </div>
                <div class="flex items-center space-x-2">
                    <x-switch.switch name="notifications" :checked="true" />
                    <x-label>Enable Notifications</x-label>
                </div>
                <div class="flex items-center space-x-2">
                    <x-switch.switch name="disabled" :disabled="true" />
                    <x-label>Disabled Switch</x-label>
                </div>
            </div>
        </section>

        <!-- Textarea -->
        <section class="space-y-4">
            <h2 class="text-2xl font-semibold">Textarea</h2>
            <div class="space-y-2 max-w-md">
                <x-label for="bio">Your Bio</x-label>
                <x-textarea.textarea id="bio" placeholder="Tell us about yourself..." rows="4" />
            </div>
        </section>

        <!-- Tooltip -->
        <section class="space-y-4">
            <h2 class="text-2xl font-semibold">Tooltip</h2>
            <div class="flex flex-wrap gap-4">
                <x-tooltip.tooltip side="top">
                    <x-slot:trigger>
                        <x-button variant="outline">Hover (Top)</x-button>
                    </x-slot:trigger>
                    Add to library
                </x-tooltip.tooltip>

                <x-tooltip.tooltip side="bottom">
                    <x-slot:trigger>
                        <x-button variant="outline">Hover (Bottom)</x-button>
                    </x-slot:trigger>
                    Tooltip on bottom
                </x-tooltip.tooltip>

                <x-tooltip.tooltip side="left">
                    <x-slot:trigger>
                        <x-button variant="outline">Hover (Left)</x-button>
                    </x-slot:trigger>
                    Tooltip on left
                </x-tooltip.tooltip>

                <x-tooltip.tooltip side="right">
                    <x-slot:trigger>
                        <x-button variant="outline">Hover (Right)</x-button>
                    </x-slot:trigger>
                    Tooltip on right
                </x-tooltip.tooltip>
            </div>
        </section>

        <!-- Pagination -->
        <section class="space-y-4">
            <h2 class="text-2xl font-semibold">Pagination</h2>
            <x-pagination.pagination>
                <x-pagination.content>
                    <x-pagination.item>
                        <x-pagination.previous href="#" />
                    </x-pagination.item>
                    <x-pagination.item>
                        <x-pagination.link href="#" :isActive="true">1</x-pagination.link>
                    </x-pagination.item>
                    <x-pagination.item>
                        <x-pagination.link href="#">2</x-pagination.link>
                    </x-pagination.item>
                    <x-pagination.item>
                        <x-pagination.link href="#">3</x-pagination.link>
                    </x-pagination.item>
                    <x-pagination.item>
                        <x-pagination.ellipsis />
                    </x-pagination.item>
                    <x-pagination.item>
                        <x-pagination.next href="#" />
                    </x-pagination.item>
                </x-pagination.content>
            </x-pagination.pagination>
        </section>

        <!-- Dropdown Menu -->
        <section class="space-y-4">
            <h2 class="text-2xl font-semibold">Dropdown Menu</h2>
            <div class="flex gap-4">
                <x-dropdown.dropdown>
                    <x-slot:trigger>
                        <x-button variant="outline">Open Menu</x-button>
                    </x-slot:trigger>
                    <x-dropdown.label>My Account</x-dropdown.label>
                    <x-dropdown.separator />
                    <x-dropdown.item>
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        Profile
                        <x-dropdown.shortcut>⇧⌘P</x-dropdown.shortcut>
                    </x-dropdown.item>
                    <x-dropdown.item>
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        Settings
                        <x-dropdown.shortcut>⌘S</x-dropdown.shortcut>
                    </x-dropdown.item>
                    <x-dropdown.separator />
                    <x-dropdown.item variant="destructive">
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        Logout
                        <x-dropdown.shortcut>⇧⌘Q</x-dropdown.shortcut>
                    </x-dropdown.item>
                </x-dropdown.dropdown>
            </div>
        </section>

        <!-- Toggle -->
        <section class="space-y-4">
            <h2 class="text-2xl font-semibold">Toggle</h2>
            <div class="flex flex-wrap gap-4">
                <x-toggle.toggle>
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" />
                    </svg>
                </x-toggle.toggle>
                <x-toggle.toggle variant="outline">
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                    </svg>
                </x-toggle.toggle>
                <x-toggle.toggle :pressed="true">
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                    </svg>
                </x-toggle.toggle>
            </div>
        </section>

        <!-- Button Group -->
        <section class="space-y-4">
            <h2 class="text-2xl font-semibold">Button Group</h2>
            <div class="space-y-4">
                <x-button-group.group>
                    <x-button variant="outline">Left</x-button>
                    <x-button variant="outline">Center</x-button>
                    <x-button variant="outline">Right</x-button>
                </x-button-group.group>

                <x-button-group.group orientation="vertical">
                    <x-button variant="outline">Top</x-button>
                    <x-button variant="outline">Middle</x-button>
                    <x-button variant="outline">Bottom</x-button>
                </x-button-group.group>
            </div>
        </section>

        <!-- Scroll Area -->
        <section class="space-y-4">
            <h2 class="text-2xl font-semibold">Scroll Area</h2>
            <x-scroll-area.scroll-area class="h-72 w-48 rounded-md border">
                <div class="p-4">
                    <h4 class="mb-4 text-sm font-medium leading-none">Tags</h4>
                    @foreach(range(1, 50) as $i)
                        <div class="text-sm">Tag {{ $i }}</div>
                        @if($i < 50)
                            <div class="my-2 h-px bg-border"></div>
                        @endif
                    @endforeach
                </div>
            </x-scroll-area.scroll-area>
        </section>

        <!-- Toast -->
        <section class="space-y-4">
            <h2 class="text-2xl font-semibold">Toast</h2>
            <div class="flex flex-wrap gap-4">
                <x-button x-data @click="$dispatch('notify', { title: 'Default Toast', description: 'This is a default toast message.' })">
                    Default
                </x-button>
                <x-button variant="destructive" x-data @click="$dispatch('notify', { variant: 'destructive', title: 'Error', description: 'Something went wrong.' })">
                    Destructive
                </x-button>
                <x-button class="!bg-green-600 hover:!bg-green-700 text-white" x-data @click="$dispatch('notify', { variant: 'success', title: 'Success', description: 'Operation completed successfully.' })">
                    Success
                </x-button>
                <x-button class="!bg-yellow-500 hover:!bg-yellow-600 text-black" x-data @click="$dispatch('notify', { variant: 'warning', title: 'Warning', description: 'Please check your input.' })">
                    Warning
                </x-button>
                <x-button variant="outline" x-data @click="$dispatch('notify', { title: 'Long Duration', description: 'This toast stays for 8 seconds.', duration: 8000 })">
                    Long Duration
                </x-button>
            </div>
        </section>

    </div>
    <x-toast.toaster />
</body>
</html>
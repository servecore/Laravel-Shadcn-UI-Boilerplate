<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ShadCN UI Components Preview</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-background text-foreground p-6">
    <div class="max-w-6xl mx-auto space-y-12">
        <h1 class="text-4xl font-bold text-center mb-8">ShadCN UI Components Preview</h1>

        <!-- Button -->
        <section class="space-y-4">
            <h2 class="text-2xl font-semibold">Button</h2>
            <div class="flex flex-wrap gap-4">
                <x-button variant="default">Default</x-button>
                <x-button variant="destructive">Destructive</x-button>
                <x-button variant="outline">Outline</x-button>
                <x-button variant="secondary">Secondary</x-button>
                <x-button variant="ghost">Ghost</x-button>
                <x-button variant="link">Link</x-button>
                <x-button size="sm">Small</x-button>
                <x-button size="lg">Large</x-button>
                <x-button disabled>Disabled</x-button>
                <x-button loading="true">Loading</x-button>
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
            </x-dialog>
        </section>

        <!-- Select -->
        <section class="space-y-4">
            <h2 class="text-2xl font-semibold">Select</h2>
            <x-select>
                <x-select-trigger class="w-[180px]">
                    <x-select-value placeholder="Select a fruit" />
                </x-select-trigger>
                <x-select-content>
                    <x-select-item value="apple">Apple</x-select-item>
                    <x-select-item value="banana">Banana</x-select-item>
                    <x-select-item value="blueberry">Blueberry</x-select-item>
                    <x-select-item value="grapes">Grapes</x-select-item>
                    <x-select-item value="pineapple">Pineapple</x-select-item>
                </x-select-content>
            </x-select>
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
                                <x-label for="name">Name</x-label>
                                <x-input id="name" default-value="Pedro Duarte" />
                            </div>
                            <div class="space-y-1">
                                <x-label for="username">Username</x-label>
                                <x-input id="username" default-value="@peduarte" />
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

    </div>
</body>
</html>
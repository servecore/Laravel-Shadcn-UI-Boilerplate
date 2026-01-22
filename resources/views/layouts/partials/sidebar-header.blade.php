{{-- 
    Sidebar Brand/Logo Header
    Edit this file to customize your app branding in the sidebar
--}}
<div class="flex items-center gap-2 px-2">
    <div class="flex size-8 items-center justify-center rounded-lg bg-primary text-primary-foreground shrink-0">
        <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
        </svg>
    </div>
    <div class="flex flex-col gap-0.5 group-data-[collapsible=icon]:hidden">
        <span class="font-semibold">{{ config('app.name', 'Laravel') }}</span>
        <span class="text-xs text-muted-foreground">Boilerplate</span>
    </div>
</div>

<div
    x-data="{
        show: false,
        init() {
            setTimeout(() => {
                this.show = true;
            }, 10);

            if (toast.duration > 0) {
                setTimeout(() => {
                    this.close();
                }, toast.duration);
            }
        },
        close() {
            this.show = false;
            setTimeout(() => {
                this.remove(toast.id);
            }, 300); // Wait for transition
        }
    }"
    x-show="show"
    x-transition:enter="transform ease-out duration-300 transition"
    x-transition:enter-start="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
    x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
    x-transition:leave="transition ease-in duration-100"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0 scale-95"
    class="group pointer-events-auto relative flex w-full items-center justify-between space-x-4 overflow-hidden rounded-md border p-6 pr-8 shadow-lg transition-all"
    :class="{
        'bg-background text-foreground border-border': toast.variant === 'default',
        'destructive group border-destructive bg-destructive text-destructive-foreground': toast.variant === 'destructive',
        'bg-green-600 text-white border-green-600': toast.variant === 'success',
        'bg-yellow-500 text-white border-yellow-500': toast.variant === 'warning'
    }"
>
    <div class="grid gap-1">
        <template x-if="toast.title">
            <div class="text-sm font-semibold" x-text="toast.title"></div>
        </template>
        <template x-if="toast.description">
            <div class="text-sm opacity-90" x-text="toast.description"></div>
        </template>
    </div>
    
    <!-- Close Button -->
    <button
        @click="close()"
        class="absolute right-2 top-2 rounded-md p-1 text-foreground/50 opacity-0 transition-opacity hover:text-foreground focus:opacity-100 focus:outline-none focus:ring-2 group-hover:opacity-100"
        :class="{
            'text-red-50 hover:text-red-50 focus:ring-red-400': toast.variant === 'destructive',
            'text-white/50 hover:text-white': toast.variant === 'success' || toast.variant === 'warning'
        }"
    >
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4"><line x1="18" x2="6" y1="6" y2="18"/><line x1="6" x2="18" y1="6" y2="18"/></svg>
    </button>
</div>

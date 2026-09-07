/**
 * Toast notification service.
 * Dispatches Alpine.js 'notify' window event consumed by <x-toast.toaster />.
 *
 * Alpine x-on:notify.window="add($event)" in toaster.blade.php expects:
 *   { title, description, variant, duration }
 */

const VARIANT_MAP = {
    success: 'success',
    error: 'destructive',
    warning: 'warning',
    info: 'default',
};

function dispatch(type, description, title = '') {
    const variant = VARIANT_MAP[type] ?? 'default';
    window.dispatchEvent(new CustomEvent('notify', {
        detail: { title, description, variant },
    }));
}

export function success(description, title = '') {
    dispatch('success', description, title);
}

export function error(description, title = '') {
    dispatch('error', description, title);
}

export function warning(description, title = '') {
    dispatch('warning', description, title);
}

export function info(description, title = '') {
    dispatch('info', description, title);
}

export const toast = { success, error, warning, info };

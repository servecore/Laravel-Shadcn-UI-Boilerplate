/**
 * Toast notification service.
 * Reads position from window.appConfig and dispatches toast events
 * consumed by the Blade-toast component.
 */

/**
 * Resolve toast position from appConfig.
 * Tries appConfig.settings.toast.position first, then appConfig.toastPosition,
 * then falls back to 'top-right'.
 */
function getToastPosition() {
    return (
        window.appConfig?.settings?.toast?.position ||
        window.appConfig?.toastPosition ||
        'top-right'
    );
}

const position = getToastPosition();

/**
 * Map a toast type to the corresponding CSS class and icon.
 */
const TYPE_MAP = {
    success: { icon: '✓', cls: 'bg-green-500' },
    error:   { icon: '✕', cls: 'bg-red-500' },
    warning: { icon: '⚠', cls: 'bg-yellow-500' },
    info:    { icon: 'ℹ', cls: 'bg-blue-500' },
};

/**
 * Dispatch a toast event to the DOM.
 *
 * @param {'success'|'error'|'warning'|'info'} type
 * @param {string} message
 * @param {string} [title]
 */
function emitToast(type, message, title = '') {
    const event = new CustomEvent(`toast:${type}`, {
        detail: { message, title, position },
    });

    window.dispatchEvent(event);
}

/**
 * Show a success toast.
 */
export function success(message, title = '') {
    emitToast('success', message, title);
}

/**
 * Show an error toast.
 */
export function error(message, title = '') {
    emitToast('error', message, title);
}

/**
 * Show a warning toast.
 */
export function warning(message, title = '') {
    emitToast('warning', message, title);
}

/**
 * Show an info toast.
 */
export function info(message, title = '') {
    emitToast('info', message, title);
}

/**
 * Named export object so consumers can `import { toast } from '...'`.
 */
export const toast = { success, error, warning, info };

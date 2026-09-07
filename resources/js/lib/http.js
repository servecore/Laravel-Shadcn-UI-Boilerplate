import axios from 'axios';

/**
 * Centralized HTTP client with CSRF injection and uniform error handling.
 *
 * @type {import('axios').AxiosInstance}
 */
const http = axios.create({
    baseURL: window.appConfig?.baseUrl || '',
    timeout: 30000,
    withCredentials: true,
});

// ---------------------------------------------------------------
// Request interceptor: inject CSRF token
// ---------------------------------------------------------------
http.interceptors.request.use(
    (config) => {
        const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

        if (token) {
            config.headers['X-CSRF-TOKEN'] = token;
        }

        config.headers['Accept'] = 'application/json';

        return config;
    },
    (error) => Promise.reject(error),
);

// ---------------------------------------------------------------
// Response interceptor: uniform error handling
// ---------------------------------------------------------------
http.interceptors.response.use(
    (response) => response,
    (error) => {
        const { status, data } = error.response || {};

        switch (status) {
            case 422:
                // Validation errors: extract messages and dispatch event
                const messages = (data?.errors || {});
                const firstError = Object.values(messages)[0]?.[0] || data?.message || 'Validation failed.';

                window.dispatchEvent(new CustomEvent('toast:error', {
                    detail: { message: firstError, title: 'Validation Error' },
                }));
                break;

            case 403:
                window.dispatchEvent(new CustomEvent('toast:error', {
                    detail: { message: 'Anda tidak punya akses.', title: 'Unauthorized' },
                }));
                break;

            case 419:
                // CSRF expired — reload to get fresh token
                window.dispatchEvent(new CustomEvent('toast:warning', {
                    detail: { message: 'Sesi kedaluwarsa. Halaman akan dimuat ulang.', title: 'Session Expired' },
                }));
                setTimeout(() => window.location.reload(), 1500);
                break;

            case 500:
                window.dispatchEvent(new CustomEvent('toast:error', {
                    detail: { message: 'Terjadi kesalahan server. Silakan coba lagi.', title: 'Server Error' },
                }));
                break;

            default:
                if (error.message) {
                    window.dispatchEvent(new CustomEvent('toast:error', {
                        detail: { message: error.message, title: 'Error' },
                    }));
                }
        }

        return Promise.reject(error);
    },
);

export { http };

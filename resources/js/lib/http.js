import axios from 'axios';
import { toast } from './toast.js';

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
                // Validation errors: extract messages and show toast
                const messages = (data?.errors || {});
                const firstError = Object.values(messages)[0]?.[0] || data?.message || 'Validation failed.';

                toast.error(firstError, 'Validation Error');
                break;

            case 403:
                toast.error(data?.message || 'Anda tidak punya akses.', 'Unauthorized');
                break;

            case 419:
                // CSRF expired — reload to get fresh token
                toast.warning(data?.message || 'Sesi kedaluwarsa. Halaman akan dimuat ulang.', 'Session Expired');
                setTimeout(() => window.location.reload(), 1500);
                break;

            case 500:
                toast.error(data?.message || 'Terjadi kesalahan server. Silakan coba lagi.', 'Server Error');
                break;

            default:
                toast.error(data?.message || error.message || 'Terjadi kesalahan.');
        }

        return Promise.reject(error);
    },
);

export { http };

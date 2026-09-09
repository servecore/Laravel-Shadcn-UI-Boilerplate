/**
 * AJAX pagination + partial DOM swap helpers.
 *
 * Shared by list modules so paging doesn't trigger a full page reload:
 * only the list body and the pagination container are replaced.
 */
import { http } from './http.js';

/**
 * Fetch a page and parse it into a Document, or null when the request fails.
 * @param {string} url
 * @returns {Promise<Document|null>}
 */
export async function loadHtml(url) {
    try {
        const response = await http.get(url);
        const html = typeof response.data === 'string' ? response.data : '';
        return new DOMParser().parseFromString(html, 'text/html');
    } catch {
        return null;
    }
}

/**
 * Swap the innerHTML of a container from a fetched Document.
 * @param {Document} doc
 * @param {string} selector
 */
export function swapContainer(doc, selector) {
    const current = document.querySelector(selector);
    const fresh = doc.querySelector(selector);
    if (current && fresh) {
        current.innerHTML = fresh.innerHTML;
    }
}

/**
 * Bind click handlers on pagination links so they load the target page
 * via AJAX and swap only the list body + pagination container.
 *
 * @param {object} options
 * @param {string} options.containerSelector - wraps the pagination nav
 * @param {string} options.listSelector - the list/table body to refresh
 * @param {string} options.fetchUrl - the base index URL used for path matching
 */
export function bindAjaxPagination({ containerSelector, listSelector, fetchUrl }) {
    const container = document.querySelector(containerSelector);
    if (!container) return;

    if (fetchUrl) {
        const basePath = new URL(fetchUrl, window.location.origin).pathname;

        container.addEventListener('click', async (e) => {
            const link = e.target.closest('a[href]');
            if (!link) return;

            const href = new URL(link.href, window.location.origin);
            if (href.pathname !== basePath) return;

            e.preventDefault();

            const doc = await loadHtml(href.toString());
            if (!doc) return;

            swapContainer(doc, listSelector);
            swapContainer(doc, containerSelector);
        });
    }
}
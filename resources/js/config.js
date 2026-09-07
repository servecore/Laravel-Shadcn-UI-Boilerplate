/**
 * Application-wide configuration loaded from the server.
 * Populated by the <script id="app-config"> tag in the Blade layout.
 */
window.appConfig = window.appConfig || {};

/**
 * Resolve a named route path from the server config or fallback.
 *
 * @param {string} name - Route name key in config
 * @param {...string} params - Substitution parameters (e.g. id)
 * @returns {string}
 */
window.route = function route(name, ...params) {
    const paths = window.appConfig.routes || {};
    let path = paths[name] || `/${name}`;

    for (const param of params) {
        path = path.replace(/:\w+/, param);
    }

    return path;
};

/**
 * Get a public application setting.
 *
 * @param {string} key
 * @param {*} fallback
 * @returns {*}
 */
window.getSetting = function getSetting(key, fallback) {
    const value = key.split('.').reduce((acc, part) => (acc && acc[part] !== undefined ? acc[part] : undefined), window.appConfig);

    return value ?? fallback;
};

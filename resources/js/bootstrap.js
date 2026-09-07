/**
 * Bootstrap the application.
 *
 * This file is loaded before the main application script.
 * Add any global initialization logic here.
 */
import './config';
// import './init-theme';

// Parse the <script id="app-config"> tag injected by the Blade layout
// and merge its contents into window.appConfig.
(function bootstrapAppConfig() {
    const tag = document.getElementById('app-config');
    if (!tag) return;

    try {
        const serverConfig = JSON.parse(tag.textContent || '{}');
        window.appConfig = { ...window.appConfig, ...serverConfig };
    } catch (error) {
        console.error('Failed to parse app-config:', error);
    }
})();

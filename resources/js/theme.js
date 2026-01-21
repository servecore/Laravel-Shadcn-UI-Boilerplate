const getTheme = () => localStorage.getItem('theme') || 'system';

const applyTheme = (theme) => {
    const isDark = theme === 'dark' ||
        (theme === 'system' && window.matchMedia('(prefers-color-scheme: dark)').matches);

    if (isDark) {
        document.documentElement.classList.add('dark');
    } else {
        document.documentElement.classList.remove('dark');
    }
};

// Global initializer
export function initializeTheme() {
    applyTheme(getTheme());

    // System listener
    window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', () => {
        if (getTheme() === 'system') {
            applyTheme('system');
        }
    });
}

export default () => ({
    theme: getTheme(),

    init() {
        // Watch for changes
        this.$watch('theme', (value) => {
            localStorage.setItem('theme', value);
            applyTheme(value);
        });
    },

    setTheme(value) {
        this.theme = value;
    },

    cycleTheme() {
        if (this.theme === 'light') {
            this.setTheme('dark');
        } else if (this.theme === 'dark') {
            this.setTheme('system');
        } else {
            this.setTheme('light');
        }
    }
});

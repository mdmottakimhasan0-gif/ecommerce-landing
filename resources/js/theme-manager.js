/**
 * Universal 3-Mode Theme Manager (Light, Dark, System)
 * Used across Storefront, Landing Pages, Elementor Builder, and Admin Panel
 */

const STORAGE_KEY = 'theme_preference';
const LEGACY_KEY = 'admin_theme';

export function getThemePreference() {
    return localStorage.getItem(STORAGE_KEY) || localStorage.getItem(LEGACY_KEY) || 'system';
}

export function isSystemDark() {
    return window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
}

export function isDarkActive() {
    const pref = getThemePreference();
    if (pref === 'dark') return true;
    if (pref === 'light') return false;
    return isSystemDark();
}

export function applyTheme(pref = null) {
    const theme = pref || getThemePreference();
    localStorage.setItem(STORAGE_KEY, theme);
    
    const isDark = theme === 'dark' || (theme === 'system' && isSystemDark());
    localStorage.setItem(LEGACY_KEY, isDark ? 'dark' : 'light');

    if (isDark) {
        document.documentElement.classList.add('dark');
    } else {
        document.documentElement.classList.remove('dark');
    }

    // Update any UI switchers present in the DOM
    updateThemeSwitchers(theme, isDark);

    // Dispatch event so any custom widgets / canvas / chart can react
    window.dispatchEvent(new CustomEvent('theme-changed', {
        detail: { theme, isDark }
    }));
}

export function setThemePreference(theme) {
    if (!['light', 'dark', 'system'].includes(theme)) {
        theme = 'system';
    }
    applyTheme(theme);
}

export function updateThemeSwitchers(theme, isDark) {
    // 1. Admin Header Switcher
    const adminIcon = document.getElementById('adminThemeIcon');
    const adminLabel = document.getElementById('adminThemeLabel');
    if (adminIcon) {
        adminIcon.textContent = theme === 'system' ? '💻' : (theme === 'dark' ? '🌙' : '☀️');
    }
    if (adminLabel) {
        const lang = localStorage.getItem('admin_lang') || 'en';
        const labelText = theme === 'system' 
            ? (lang === 'bn' ? 'সিস্টেম' : 'System')
            : (theme === 'dark' ? (lang === 'bn' ? 'ডার্ক' : 'Dark') : (lang === 'bn' ? 'লাইট' : 'Light'));
        adminLabel.textContent = labelText;
    }

    // 2. Storefront Navbar Switcher
    const sfIcon = document.getElementById('storefrontThemeIcon');
    const sfLabel = document.getElementById('storefrontThemeLabel');
    if (sfIcon) {
        sfIcon.textContent = theme === 'system' ? '💻' : (theme === 'dark' ? '🌙' : '☀️');
    }
    if (sfLabel) {
        const lang = localStorage.getItem('demandhat_lang') || 'bn';
        sfLabel.textContent = theme === 'system' 
            ? (lang === 'bn' ? 'সিস্টেম' : 'System')
            : (theme === 'dark' ? (lang === 'bn' ? 'ডার্ক' : 'Dark') : (lang === 'bn' ? 'লাইট' : 'Light'));
    }

    // 3. Mark active pill/button in any 3-option segmented control
    document.querySelectorAll('[data-theme-option]').forEach(btn => {
        const opt = btn.getAttribute('data-theme-option');
        if (opt === theme) {
            btn.classList.add('bg-emerald-600', 'text-white', 'shadow-xs');
            btn.classList.remove('text-slate-400', 'text-slate-600', 'hover:bg-slate-800', 'hover:bg-slate-100');
        } else {
            btn.classList.remove('bg-emerald-600', 'text-white', 'shadow-xs');
            btn.classList.add(document.documentElement.classList.contains('dark') ? 'text-slate-400' : 'text-slate-600');
        }
    });
}

// Global window exposure for inline onclick handlers
if (typeof window !== 'undefined') {
    window.ThemeManager = {
        get: getThemePreference,
        set: setThemePreference,
        apply: applyTheme,
        isDark: isDarkActive
    };

    window.setSiteTheme = setThemePreference;

    // Listen for OS system theme changes
    if (window.matchMedia) {
        window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', (e) => {
            if (getThemePreference() === 'system') {
                applyTheme('system');
            }
        });
    }

    // Apply immediately and on DOMContentLoaded
    applyTheme();
    document.addEventListener('DOMContentLoaded', () => {
        applyTheme();
    });
}

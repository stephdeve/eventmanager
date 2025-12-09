<button type="button" x-data="{ isDark: document.documentElement.classList.contains('dark') }" x-init="document.addEventListener('themechange', (e) => { isDark = e.detail === 'dark' });" @click="window.toggleTheme(); isDark = !isDark;"
    class="p-2.5 rounded-full border border-neutral-200 bg-white text-neutral-600 hover:bg-neutral-100 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:border-neutral-700 dark:bg-neutral-900 dark:text-neutral-300 dark:hover:bg-neutral-800 dark:focus:ring-offset-neutral-950"
    :aria-pressed="isDark" aria-label="Basculer thème">
    <svg x-show="!isDark" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
        stroke="currentColor" style="display: none;">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M12 3v2m0 14v2m9-9h-2M5 12H3m15.364 6.364l-1.414-1.414M7.05 7.05L5.636 5.636m12.728 0l-1.414 1.414M7.05 16.95l-1.414 1.414M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
    </svg>
    <svg x-show="isDark" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24"
        style="display: none;">
        <path d="M21.64 13.64A9 9 0 1110.36 2.36a7 7 0 0011.28 11.28z" />
    </svg>
</button>

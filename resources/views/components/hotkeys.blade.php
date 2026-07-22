<div class="fixed bottom-6 right-6 z-50 group">
    <!-- Tooltip Panel -->
    <div class="absolute bottom-full right-0 mb-4 w-72 bg-gray-800 border border-gray-700 text-gray-200 text-sm rounded-xl shadow-2xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 transform translate-y-2 group-hover:translate-y-0 p-4">
        <h4 class="font-bold text-emerald-400 mb-2 uppercase tracking-wide text-xs">Keyboard Shortcuts</h4>
        <ul class="space-y-2">
            <li class="flex justify-between items-center">
                <span class="text-gray-400">Search / Filter</span>
                <kbd class="bg-gray-900 border border-gray-700 px-2 py-1 rounded text-[10px] font-mono">/</kbd>
            </li>
            <li class="flex justify-between items-center">
                <span class="text-gray-400">Submit Form</span>
                <kbd class="bg-gray-900 border border-gray-700 px-2 py-1 rounded text-[10px] font-mono">Ctrl + Enter</kbd>
            </li>
            <li class="flex justify-between items-center">
                <span class="text-gray-400">Maju (Next Input)</span>
                <kbd class="bg-gray-900 border border-gray-700 px-2 py-1 rounded text-[10px] font-mono">Tab</kbd>
            </li>
            <li class="flex justify-between items-center">
                <span class="text-gray-400">Mundur (Prev Input)</span>
                <kbd class="bg-gray-900 border border-gray-700 px-2 py-1 rounded text-[10px] font-mono">Shift + Tab</kbd>
            </li>
            <li class="flex justify-between items-center border-t border-gray-700 pt-2 mt-2">
                <span class="text-gray-400">Navigasi Arah</span>
                <span class="flex gap-1">
                    <kbd class="bg-gray-900 border border-gray-700 px-1.5 py-1 rounded text-[10px] font-mono">Alt</kbd> +
                    <kbd class="bg-gray-900 border border-gray-700 px-1.5 py-1 rounded text-[10px] font-mono">↑↓←→</kbd>
                </span>
            </li>
            <li class="flex justify-between items-center">
                <span class="text-gray-400">Toggle Checkbox</span>
                <kbd class="bg-gray-900 border border-gray-700 px-2 py-1 rounded text-[10px] font-mono">Space</kbd>
            </li>
        </ul>
        <div class="mt-3 pt-2 border-t border-gray-700 text-[9px] text-gray-500 text-center leading-tight">
            Gunakan Alt + Arah Panah untuk berpindah secara paksa tanpa mengganggu fungsi ketik text/angka.
        </div>
    </div>

    <!-- Button -->
    <div class="w-12 h-12 bg-gray-700 hover:bg-emerald-600 rounded-full flex items-center justify-center cursor-help shadow-lg border border-gray-600 transition-colors">
        <svg class="w-6 h-6 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
    </div>
</div>

<script>
    // Ambil semua elemen yang bisa difokuskan di halaman
    function getFocusableElements() {
        return Array.from(document.querySelectorAll(
            'input:not([readonly]):not([type="hidden"]), select, textarea, button, [tabindex]:not([tabindex="-1"])'
        )).filter(el => {
            // Pastikan elemen tersebut terlihat (tidak disembunyikan oleh CSS)
            return !!(el.offsetWidth || el.offsetHeight || el.getClientRects().length) && !el.disabled;
        });
    }

    document.addEventListener('keydown', function(e) {
        // Abaikan shortcut '/' jika sedang mengetik di dalam input teks/textarea normal
        const isInput = ['INPUT', 'TEXTAREA', 'SELECT'].includes(e.target.tagName);
        const isNotCheckbox = e.target.type !== 'checkbox' && e.target.type !== 'radio' && e.target.type !== 'button' && e.target.type !== 'submit';

        if (e.key === '/' && (!isInput || !isNotCheckbox)) {
            e.preventDefault();
            const searchInput = document.querySelector('input[name="search"], input[id="global-plant-search"]');
            if (searchInput) searchInput.focus();
        }

        // Ctrl + Enter untuk submit form
        if ((e.ctrlKey || e.metaKey) && e.key === 'Enter') {
            const form = e.target.closest('form');
            if (form) {
                e.preventDefault();
                form.submit();
            } else {
                const mainForm = document.querySelector('form');
                if (mainForm) mainForm.submit();
            }
        }

        // --- Custom Arrow Navigation (ALT + Panah) ---
        // Kenapa pakai ALT? Karena jika kita hanya memakai panah, saat user mengetik teks
        // / menaikkan nilai angka (0 -> 1), navigasi akan menabrak perilaku default browser.
        if (e.altKey && ['ArrowUp', 'ArrowDown', 'ArrowLeft', 'ArrowRight'].includes(e.key)) {
            e.preventDefault(); // Matikan default scrolling agar tidak loncat layarnya

            const focusables = getFocusableElements();
            if (focusables.length === 0) return;

            const currentIndex = focusables.indexOf(document.activeElement);
            let nextIndex = 0;

            if (e.key === 'ArrowDown' || e.key === 'ArrowRight') {
                // Maju (seperti Tab)
                nextIndex = currentIndex > -1 ? (currentIndex + 1) % focusables.length : 0;
            } else if (e.key === 'ArrowUp' || e.key === 'ArrowLeft') {
                // Mundur (seperti Shift + Tab)
                nextIndex = currentIndex > 0 ? currentIndex - 1 : focusables.length - 1;
            }

            focusables[nextIndex].focus();
        }
    });

    // Indikator visual custom agar Tab Navigation terlihat sangat jelas dengan garis emerald bercahaya
    document.addEventListener('DOMContentLoaded', () => {
        const style = document.createElement('style');
        style.textContent = `
            /* Matikan outline default browser lalu ganti yang lebih mencolok untuk keyboard nav */
            *:focus-visible {
                outline: 2px solid #10b981 !important;
                outline-offset: 2px !important;
                border-radius: 4px;
            }
            .ts-control.focus {
                border-color: #10b981 !important;
                box-shadow: 0 0 0 1px #10b981 !important;
            }
            .form-checkbox:focus-visible {
                outline: 2px solid #10b981 !important;
                outline-offset: 4px !important;
            }
            a:focus:not(:focus-visible), button:focus:not(:focus-visible) {
                outline: none !important;
            }
        `;
        document.head.appendChild(style);
    });
</script>
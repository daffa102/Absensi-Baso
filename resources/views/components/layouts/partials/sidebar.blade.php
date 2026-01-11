<!-- Overlay for mobile -->
<div x-show="mobileMenu" 
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    @click="mobileMenu = false"
    class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-40 lg:hidden"></div>

<aside :class="mobileMenu ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
    class="w-72 fixed inset-y-0 left-0 glass-sidebar z-50 flex flex-col p-6 transition-transform duration-300 ease-in-out">
    
    <!-- Close button for mobile -->
    <button @click="mobileMenu = false" class="lg:hidden absolute right-4 top-4 p-2 text-slate-400 hover:text-slate-600">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
    </button>

    <!-- Logo -->
    <div class="flex items-center gap-3 px-2 mb-10">
        <div
            class="w-10 h-10 bg-blue-600 rounded-xl flex items-center justify-center text-white font-bold text-xl shadow-lg">
            L
        </div>
        <span class="text-xl font-black tracking-tight text-slate-900">Logo</span>
    </div>

    <!-- Navigation Menu -->
    <nav class="flex-1 space-y-2">
        <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] px-3 mb-4">
            Menu Utama
        </p>

        <a href="{{ route('admin.dashboard') }}" wire:navigate
            class="{{ Route::is('admin.dashboard') ? 'sidebar-item-active' : '' }} flex items-center gap-3 px-4 py-3.5 rounded-2xl font-bold transition-all group">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <rect x="3" y="3" width="7" height="7" />
                <rect x="14" y="3" width="7" height="7" />
                <rect x="14" y="14" width="7" height="7" />
                <rect x="3" y="14" width="7" height="7" />
            </svg>
            Dashboard
        </a>

        <a href="{{ route('admin.data-siswa.index') }}" wire:navigate
            class="{{ Route::is('admin.data-siswa.*') ? 'sidebar-item-active' : '' }} flex items-center gap-3 px-4 py-3.5 rounded-2xl font-bold transition-all group">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                <circle cx="9" cy="7" r="4" />
                <path d="M22 21v-2a4 4 0 0 0-3-3.87" />
                <path d="M16 3.13a4 4 0 0 1 0 7.75" />
            </svg>
            Data Siswa
        </a>

        <a href="{{ route('admin.data-kelas.index') }}" wire:navigate
            class="{{ Route::is('admin.data-kelas.*') ? 'sidebar-item-active' : '' }} flex items-center gap-3 px-4 py-3.5 rounded-2xl font-bold transition-all group">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <path d="M3 9h18v10a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V9Z" />
                <path d="M3 9V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v4" />
                <path d="M13 13h4" />
                <path d="M13 17h4" />
            </svg>
            Data Kelas
        </a>

        <a href="{{ route('admin.tahun-ajar.index') }}" wire:navigate
            class="{{ Route::is('admin.tahun-ajar.*') ? 'sidebar-item-active' : '' }} flex items-center gap-3 px-4 py-3.5 rounded-2xl font-bold transition-all group">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <path d="M3 9h18v10a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V9Z" />
                <path d="M3 9V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v4" />
                <path d="M13 13h4" />
                <path d="M13 17h4" />
            </svg>
            Tahun Ajaran
        </a>
    </nav>

    <!-- Bottom Profile -->
    <div class="mt-auto pt-6 border-t border-slate-100">
        <button type="button" @click="logoutModal = true"
            class="w-full flex items-center justify-center gap-2 py-3 px-4 rounded-xl font-bold text-red-500 hover:bg-red-50 transition-all">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                <polyline points="16 17 21 12 16 7" />
                <line x1="21" y1="12" x2="9" y2="12" />
            </svg>
            Keluar
        </button>
    </div>
</aside>

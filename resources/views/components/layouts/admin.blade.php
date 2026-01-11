<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard Admin - Hadirin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="globals.css" rel="stylesheet" />
    <style>
        .sidebar-item-active {
            background-color: #3b82f6;
            color: white;
            box-shadow: 0 10px 15px -3px rgba(59, 130, 246, 0.3);
        }

        .glass-sidebar {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-right: 1px solid rgba(226, 232, 240, 0.8);
        }
    </style>
</head>

<body class="bg-slate-50 text-slate-900 font-sans antialiased" 
    x-data="{ 
        mobileMenu: false, 
        logoutModal: false,
        deleteModal: {
            open: false,
            id: null,
            title: '',
            message: '',
            action: null
        }
    }"
    @open-delete-modal.window="
        deleteModal.id = $event.detail.id;
        deleteModal.title = $event.detail.title || 'Hapus Data?';
        deleteModal.message = $event.detail.message || 'Apakah Anda yakin ingin menghapus data ini?';
        deleteModal.action = $event.detail.action || 'delete';
        deleteModal.open = true;
    ">
    
    <!-- Logout Confirmation Modal (Global & Centered) -->
    <div x-show="logoutModal" 
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 bg-slate-900/60 backdrop-blur-md z-[100] flex items-center justify-center p-4"
        style="display: none;">
        
        <div @click.away="logoutModal = false"
            x-show="logoutModal"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-95 translate-y-4"
            x-transition:enter-end="opacity-100 scale-100 translate-y-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 scale-100 translate-y-0"
            x-transition:leave-end="opacity-0 scale-95 translate-y-4"
            class="bg-white rounded-[2.5rem] shadow-2xl max-w-sm w-full overflow-hidden">
            
            <div class="p-10 text-center">
                <div class="w-20 h-20 bg-red-100 text-red-600 rounded-3xl flex items-center justify-center mx-auto mb-6 transform -rotate-6 shadow-inner">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                </div>
                
                <h3 class="text-2xl font-black text-slate-900 mb-2">Mau Keluar?</h3>
                <p class="text-slate-500 font-bold mb-8">Apakah Anda yakin ingin mengakhiri sesi ini?</p>
                
                <div class="grid grid-cols-2 gap-3">
                    <button type="button" @click="logoutModal = false"
                        class="bg-slate-100 text-slate-700 py-3.5 rounded-2xl font-black text-sm hover:bg-slate-200 transition-all">
                        Batal
                    </button>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="w-full bg-red-600 text-white py-3.5 rounded-2xl font-black text-sm shadow-lg shadow-red-500/30 hover:bg-red-700 transition-all">
                            Ya, Keluar
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal (Global & Centered) -->
    <div x-show="deleteModal.open" 
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 bg-slate-900/60 backdrop-blur-md z-[100] flex items-center justify-center p-4"
        style="display: none;">
        
        <div @click.away="deleteModal.open = false"
            x-show="deleteModal.open"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-95 translate-y-4"
            x-transition:enter-end="opacity-100 scale-100 translate-y-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 scale-100 translate-y-0"
            x-transition:leave-end="opacity-0 scale-95 translate-y-4"
            class="bg-white rounded-[2.5rem] shadow-2xl max-w-sm w-full overflow-hidden">
            
            <div class="p-10 text-center">
                <div class="w-20 h-20 bg-red-50 text-red-500 rounded-3xl flex items-center justify-center mx-auto mb-6 transform rotate-6 shadow-inner">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/><line x1="10" y1="11" x2="10" y2="17"/><line x1="14" y1="11" x2="14" y2="17"/></svg>
                </div>
                
                <h3 class="text-2xl font-black text-slate-900 mb-2" x-text="deleteModal.title"></h3>
                <p class="text-slate-500 font-bold mb-8" x-text="deleteModal.message"></p>
                
                <div class="grid grid-cols-2 gap-3">
                    <button type="button" @click="deleteModal.open = false"
                        class="bg-slate-100 text-slate-700 py-3.5 rounded-2xl font-black text-sm hover:bg-slate-200 transition-all">
                        Batal
                    </button>
                    <button type="button" 
                        @click="Livewire.dispatch(deleteModal.action, { id: deleteModal.id }); deleteModal.open = false"
                        class="bg-red-600 text-white py-3.5 rounded-2xl font-black text-sm shadow-lg shadow-red-500/30 hover:bg-red-700 transition-all">
                        Ya, Hapus
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        @include('components.layouts.partials.sidebar')

        <div class="flex-1 flex flex-col min-w-0 overflow-hidden">
            <!-- Mobile Header -->
            <header class="lg:hidden bg-white/80 backdrop-blur-md border-b border-slate-100 sticky top-0 z-40 px-6 py-4 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center text-white font-bold text-sm shadow-md">
                        L
                    </div>
                    <span class="text-lg font-black tracking-tight text-slate-900">Logo</span>
                </div>
                <button @click="mobileMenu = true" class="p-2 text-slate-600 hover:bg-slate-50 rounded-xl transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
                </button>
            </header>

            <!-- Main Content -->
            {{ $slot }}
        </div>
    </div>
</body>

</html>
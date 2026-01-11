<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Guru - Hadirin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="globals.css" rel="stylesheet">
    <style>
        .glass-header {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(226, 232, 240, 0.8);
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-900 font-sans antialiased" x-data="{ logoutModal: false }">

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
                <p class="text-slate-500 font-bold mb-8">Apakah Anda yakin ingin mengakhiri sesi ini bosku?</p>
                
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

    {{ $slot }}
    

</body>

</html>

<main class="flex-1 lg:ml-72 min-h-screen p-6 md:p-10" x-data="signatureManager()">
    <!-- Header -->
    <header class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-10">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight">
                Tanda Tangan
            </h1>
            <p class="text-slate-500 font-bold mt-1">
                Kelola tanda tangan untuk dokumen export
            </p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.signature.create') }}" wire:navigate
                class="bg-blue-600 text-white px-6 py-3 rounded-xl font-black text-sm shadow-lg shadow-blue-500/30 hover:bg-blue-700 transition-all flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="12" y1="5" x2="12" y2="19" />
                    <line x1="5" y1="12" x2="19" y2="12" />
                </svg>
                Tambah Tanda Tangan
            </a>
        </div>
    </header>

    <!-- Flash Messages -->
    @if (session()->has('message'))
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show" 
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-2"
            x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="mb-6 bg-green-50 border border-green-200 text-green-800 px-6 py-4 rounded-2xl flex items-center justify-between gap-3 shadow-sm shadow-green-100">
            <div class="flex items-center gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />
                    <polyline points="22 4 12 14.01 9 11.01" />
                </svg>
                <span class="font-bold">{{ session('message') }}</span>
            </div>
            <button @click="show = false" class="text-green-600 hover:text-green-800 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="18" y1="6" x2="6" y2="18" />
                    <line x1="6" y1="6" x2="18" y2="18" />
                </svg>
            </button>
        </div>
    @endif

    <!-- Signatures Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @forelse ($signatures as $signature)
            <div x-data="{ 
                isActive: @js($signature->is_active),
                isHovered: false
            }" 
            @mouseenter="isHovered = true"
            @mouseleave="isHovered = false"
            :class="isHovered ? 'shadow-lg scale-[1.02]' : 'shadow-sm'"
            class="bg-white rounded-[2rem] border border-slate-100 overflow-hidden transform transition-all duration-300">
                <div class="p-8">
                    <!-- Header with Role Badge -->
                    <div class="flex items-start justify-between mb-6">
                        <div>
                            <h3 class="text-xl font-black text-slate-900 mt-3">{{ $signature->name }}</h3>
                            @if($signature->nip)
                                <p class="text-sm font-bold text-slate-500 mt-1">NIP: {{ $signature->nip }}</p>
                            @endif
                        </div>
                        <button @click="toggleActive({{ $signature->id }}); isActive = !isActive"
                            :class="isActive ? 'bg-green-500 text-white hover:bg-green-600 shadow-md shadow-green-500/20' : 'bg-slate-100 text-slate-400 hover:bg-slate-200'"
                            class="p-2 rounded-lg transition-all duration-200 transform hover:scale-110"
                            :title="isActive ? 'Aktif' : 'Nonaktif'">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <template x-if="isActive">
                                    <g>
                                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />
                                        <polyline points="22 4 12 14.01 9 11.01" />
                                    </g>
                                </template>
                                <template x-if="!isActive">
                                    <g>
                                        <circle cx="12" cy="12" r="10" />
                                        <line x1="15" y1="9" x2="9" y2="15" />
                                        <line x1="9" y1="9" x2="15" y2="15" />
                                    </g>
                                </template>
                            </svg>
                        </button>
                    </div>

                    <!-- Signature Preview -->
                    <div class="bg-slate-50 rounded-2xl p-6 mb-6 flex items-center justify-center min-h-[200px] transition-all hover:bg-slate-100">
                        <img src="{{ $signature->signature_url }}" alt="Tanda tangan {{ $signature->name }}"
                            class="max-h-40 max-w-full object-contain transition-transform duration-300"
                            :class="isHovered ? 'scale-105' : 'scale-100'">
                    </div>

                    <!-- Actions -->
                    <div class="flex items-center gap-3">
                        <a href="{{ route('admin.signature.edit', $signature->id) }}" wire:navigate
                            class="flex-1 bg-blue-50 text-blue-600 px-6 py-3 rounded-xl font-black text-sm hover:bg-blue-100 transition-all flex items-center justify-center gap-2 hover:shadow-md">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z" />
                                <path d="m15 5 4 4" />
                            </svg>
                            Edit
                        </a>
                        <button @click="confirmDelete({{ $signature->id }})"
                            class="flex-1 bg-red-50 text-red-600 px-6 py-3 rounded-xl font-black text-sm hover:bg-red-100 transition-all flex items-center justify-center gap-2 hover:shadow-md">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M3 6h18" />
                                <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6" />
                                <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2" />
                            </svg>
                            Hapus
                        </button>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-2 bg-white rounded-[2rem] shadow-sm border border-slate-100 p-12">
                <div class="flex flex-col items-center gap-4 text-center">
                    <div class="w-20 h-20 bg-slate-100 rounded-2xl flex items-center justify-center text-slate-400 animate-pulse">
                        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z" />
                            <path d="m15 5 4 4" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-slate-900 font-black text-lg">Belum ada tanda tangan</p>
                        <p class="text-slate-500 font-bold text-sm mt-1">
                            Mulai tambahkan tanda tangan untuk Kepala Sekolah dan Wali Kelas
                        </p>
                    </div>
                    <a href="{{ route('admin.signature.create') }}" wire:navigate
                        class="mt-4 bg-blue-600 text-white px-8 py-3 rounded-xl font-black text-sm shadow-lg shadow-blue-500/30 hover:bg-blue-700 hover:shadow-xl transition-all transform hover:scale-105 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="12" y1="5" x2="12" y2="19" />
                            <line x1="5" y1="12" x2="19" y2="12" />
                        </svg>
                        Tambah Tanda Tangan
                    </a>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Delete Confirmation Modal -->
    <div x-show="deleteModal" 
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        @keydown.escape.window="cancelDelete()"
        class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4"
        style="display: none;">
        
        <div @click.away="cancelDelete()"
            x-show="deleteModal"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-90 -translate-y-4"
            x-transition:enter-end="opacity-100 scale-100 translate-y-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 scale-100 translate-y-0"
            x-transition:leave-end="opacity-0 scale-90 -translate-y-4"
            class="bg-white rounded-[2rem] shadow-2xl max-w-md w-full p-8">
            
            <div class="flex items-center justify-center w-16 h-16 bg-red-100 rounded-2xl mx-auto mb-6 animate-bounce">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"
                    class="text-red-600">
                    <path d="M3 6h18" />
                    <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6" />
                    <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2" />
                </svg>
            </div>
            
            <h3 class="text-2xl font-black text-slate-900 text-center mb-3">Hapus Tanda Tangan?</h3>
            <p class="text-slate-600 font-bold text-center mb-8">
                Apakah Anda yakin ingin menghapus tanda tangan ini? Tindakan ini tidak dapat dibatalkan.
            </p>
            
            <div class="flex items-center gap-3">
                <button @click="executeDelete()"
                    class="flex-1 bg-red-600 text-white px-6 py-3.5 rounded-xl font-black text-sm shadow-lg shadow-red-500/30 hover:bg-red-700 hover:shadow-xl transition-all transform hover:scale-105">
                    Ya, Hapus
                </button>
                <button @click="cancelDelete()"
                    class="flex-1 bg-slate-100 text-slate-700 px-6 py-3.5 rounded-xl font-black text-sm hover:bg-slate-200 transition-all transform hover:scale-105">
                    Batal
                </button>
            </div>
        </div>
    </div>

    <script>
        function signatureManager() {
            return {
                deleteModal: false,
                deleteId: null,
                
                confirmDelete(id) {
                    this.deleteId = id;
                    this.deleteModal = true;
                },
                
                cancelDelete() {
                    this.deleteModal = false;
                    this.deleteId = null;
                },
                
                executeDelete() {
                    if (this.deleteId) {
                        @this.call('delete').then(() => {
                            this.cancelDelete();
                        });
                    }
                },
                
                toggleActive(id) {
                    @this.call('toggleActive', id);
                }
            }
        }
    </script>
</main>

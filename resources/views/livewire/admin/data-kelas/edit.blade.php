<main class="flex-1 lg:ml-72 min-h-screen p-6 md:p-10" x-data="formAutoSave('kelas_edit_form', ['nama_kelas'])">
    <!-- Header -->
    <header class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight">
                Edit Kelas
            </h1>
            <p class="text-slate-500 font-bold mt-1">
                Perbarui informasi kelas
            </p>
        </div>
        <a href="{{ route('admin.data-kelas.index') }}" wire:navigate
            class="bg-slate-100 text-slate-700 px-6 py-3 rounded-xl font-black text-sm hover:bg-slate-200 transition-all flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <line x1="19" y1="12" x2="5" y2="12" />
                <polyline points="12 19 5 12 12 5" />
            </svg>
            Kembali
        </a>
    </header>

    <!-- Auto-save Indicator -->
    <div x-show="hasData()"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 -translate-y-2"
        x-transition:enter-end="opacity-100 translate-y-0"
        class="mb-6 bg-blue-50 border border-blue-200 text-blue-800 px-4 py-3 rounded-xl flex items-center gap-3">
        <svg class="animate-pulse" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
            stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z" />
            <polyline points="17 21 17 13 7 13 7 21" />
            <polyline points="7 3 7 8 15 8" />
        </svg>
        <div class="flex-1">
            <p class="font-bold text-sm">Perubahan belum disimpan</p>
            <p class="text-xs font-medium text-blue-600">Perubahan Anda tersimpan otomatis di browser</p>
        </div>
        <button @click="clearFormData()" type="button"
            class="text-xs font-bold text-blue-600 hover:text-blue-800 underline transition-colors">
            Reset Perubahan
        </button>
    </div>

    <!-- Form Card -->
    <div class="max-w-2xl">
        <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden">
            <div class="p-8 border-b border-slate-50">
                <h3 class="text-xl font-black text-slate-900">Informasi Kelas</h3>
                <p class="text-slate-400 text-sm font-bold mt-1">
                    Ubah data kelas sesuai kebutuhan
                </p>
            </div>

            <form wire:submit.prevent="update" class="p-8 space-y-6">
                <!-- Nama Kelas -->
                <div>
                    <label for="nama_kelas" class="block text-sm font-black text-slate-700 mb-2">
                        Nama Kelas <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="nama_kelas" wire:model="nama_kelas" x-model="formData.nama_kelas"
                        class="w-full bg-slate-50 border @error('nama_kelas') border-red-300 @else border-slate-200 @enderror rounded-xl px-4 py-3.5 font-bold text-slate-700 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none transition-all"
                        placeholder="Contoh: XII IPA 1">
                    @error('nama_kelas')
                        <p class="mt-2 text-sm font-bold text-red-600 flex items-center gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
                                stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10" />
                                <line x1="12" y1="8" x2="12" y2="12" />
                                <line x1="12" y1="16" x2="12.01" y2="16" />
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Submit Button -->
                <div class="flex items-center gap-3 pt-4">
                    <button type="submit"
                        class="bg-blue-600 text-white px-8 py-3.5 rounded-xl font-black text-sm shadow-lg shadow-blue-500/30 hover:bg-blue-700 transition-all flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z" />
                            <polyline points="17 21 17 13 7 13 7 21" />
                            <polyline points="7 3 7 8 15 8" />
                        </svg>
                        Update Data
                    </button>
                    <a href="{{ route('admin.data-kelas.index') }}" wire:navigate
                        class="bg-slate-100 text-slate-700 px-8 py-3.5 rounded-xl font-black text-sm hover:bg-slate-200 transition-all">
                        Batal
                    </a>
                </div>
            </form>
        </div>

        <!-- Info Card -->
        <div class="mt-6 bg-amber-50 border border-amber-200 rounded-2xl p-6">
            <div class="flex gap-4">
                <div class="flex-shrink-0">
                    <div class="w-10 h-10 bg-amber-600 rounded-xl flex items-center justify-center text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z" />
                            <line x1="12" y1="9" x2="12" y2="13" />
                            <line x1="12" y1="17" x2="12.01" y2="17" />
                        </svg>
                    </div>
                </div>
                <div>
                    <h4 class="font-black text-amber-900 mb-1">Perhatian</h4>
                    <ul class="text-sm font-bold text-amber-800 space-y-1">
                        <li>• Mengubah nama kelas akan mempengaruhi data siswa yang terkait</li>
                        <li>• Pastikan nama kelas yang baru belum terdaftar</li>
                        <li>• Perubahan akan langsung tersimpan setelah klik Update Data</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</main>

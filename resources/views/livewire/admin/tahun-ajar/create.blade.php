<main class="flex-1 lg:ml-72 min-h-screen p-6 md:p-10">
    <!-- Header -->
    <header class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-10">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight">
                Tambah Tahun Ajaran Baru
            </h1>
            <p class="text-slate-500 font-bold mt-1">
                Isi form di bawah untuk menambahkan tahun ajaran baru
            </p>
        </div>
        <a href="{{ route('admin.tahun-ajar.index') }}" wire:navigate
            class="bg-slate-100 text-slate-700 px-6 py-3 rounded-xl font-black text-sm hover:bg-slate-200 transition-all flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <line x1="19" y1="12" x2="5" y2="12" />
                <polyline points="12 19 5 12 12 5" />
            </svg>
            Kembali
        </a>
    </header>

    <!-- Form Card -->
    <div class="max-w-2xl">
        <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden">
            <div class="p-8 border-b border-slate-50">
                <h3 class="text-xl font-black text-slate-900">Informasi Tahun Ajaran</h3>
                <p class="text-slate-400 text-sm font-bold mt-1">
                    Masukkan data tahun ajaran dengan lengkap
                </p>
            </div>

            <form wire:submit.prevent="save" class="p-8 space-y-6">
                <!-- Nama Tahun Ajaran -->
                <div>
                    <label for="nama" class="block text-sm font-black text-slate-700 mb-2">
                        Tahun Ajaran <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="nama" wire:model="nama"
                        class="w-full bg-slate-50 border @error('nama') border-red-300 @else border-slate-200 @enderror rounded-xl px-4 py-3.5 font-bold text-slate-700 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none transition-all"
                        placeholder="Contoh: 2024/2025">
                    @error('nama')
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

                <!-- Status Aktif -->
                <div>
                    <label class="block text-sm font-black text-slate-700 mb-3">
                        Status Tahun Ajaran
                    </label>
                    <div class="flex items-center gap-3">
                        <label
                            class="relative inline-flex items-center cursor-pointer bg-slate-50 rounded-xl px-4 py-3 border border-slate-200 hover:border-blue-500 transition-all">
                            <input type="checkbox" wire:model="aktif" class="sr-only peer">
                            <div
                                class="w-11 h-6 bg-slate-300 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-blue-500/20 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[14px] after:left-[18px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-green-600">
                            </div>
                            <span class="ml-3 text-sm font-bold text-slate-700">
                                Jadikan tahun ajaran aktif
                            </span>
                        </label>
                    </div>
                    <p class="mt-2 text-xs font-bold text-slate-500">
                        Jika diaktifkan, tahun ajaran lain akan otomatis dinonaktifkan
                    </p>
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
                        Simpan Data
                    </button>
                    <a href="{{ route('admin.tahun-ajar.index') }}" wire:navigate
                        class="bg-slate-100 text-slate-700 px-8 py-3.5 rounded-xl font-black text-sm hover:bg-slate-200 transition-all">
                        Batal
                    </a>
                </div>
            </form>
        </div>

        <!-- Info Card -->
        <div class="mt-6 bg-blue-50 border border-blue-200 rounded-2xl p-6">
            <div class="flex gap-4">
                <div class="flex-shrink-0">
                    <div class="w-10 h-10 bg-blue-600 rounded-xl flex items-center justify-center text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
                            stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10" />
                            <line x1="12" y1="16" x2="12" y2="12" />
                            <line x1="12" y1="8" x2="12.01" y2="8" />
                        </svg>
                    </div>
                </div>
                <div>
                    <h4 class="font-black text-blue-900 mb-1">Petunjuk Pengisian</h4>
                    <ul class="text-sm font-bold text-blue-800 space-y-1">
                        <li>• Tahun ajaran harus unik dan belum terdaftar</li>
                        <li>• Gunakan format YYYY/YYYY, contoh: 2024/2025</li>
                        <li>• Hanya satu tahun ajaran yang dapat aktif dalam satu waktu</li>
                        <li>• Tahun ajaran aktif akan digunakan untuk data siswa baru</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</main>

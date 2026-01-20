<main class="flex-1 lg:ml-72 min-h-screen p-6 md:p-10" x-data="formAutoSave('siswa_create_form', ['nis', 'nama', 'kelas_id', 'tahun_ajar_id'])">
    <!-- Header -->
    <header class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight">
                Tambah Siswa Baru
            </h1>
            <p class="text-slate-500 font-bold mt-1">
                Isi form di bawah untuk menambahkan siswa baru
            </p>
        </div>
        <a href="{{ route('admin.data-siswa.index') }}" wire:navigate
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
            <p class="font-bold text-sm">Data tersimpan otomatis</p>
            <p class="text-xs font-medium text-blue-600">Form Anda aman meskipun halaman di-refresh</p>
        </div>
        <button @click="clearFormData()" type="button"
            class="text-xs font-bold text-blue-600 hover:text-blue-800 underline transition-colors">
            Hapus Data
        </button>
    </div>

    <!-- Form Card -->
    <div class="max-w-3xl">
        <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden">
            <div class="p-8 border-b border-slate-50">
                <h3 class="text-xl font-black text-slate-900">Informasi Siswa</h3>
                <p class="text-slate-400 text-sm font-bold mt-1">
                    Masukkan data siswa dengan lengkap
                </p>
            </div>

            <form wire:submit.prevent="save" class="p-8 space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- NIS -->
                    <div>
                        <label for="nis" class="block text-sm font-black text-slate-700 mb-2">
                            NIS <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="nis" wire:model="nis" x-model="formData.nis"
                            class="w-full bg-slate-50 border @error('nis') border-red-300 @else border-slate-200 @enderror rounded-xl px-4 py-3.5 font-bold text-slate-700 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none transition-all"
                            placeholder="Contoh: 2025001">
                        @error('nis')
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

                    <!-- Nama -->
                    <div>
                        <label for="nama" class="block text-sm font-black text-slate-700 mb-2">
                            Nama Lengkap <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="nama" wire:model="nama" x-model="formData.nama"
                            class="w-full bg-slate-50 border @error('nama') border-red-300 @else border-slate-200 @enderror rounded-xl px-4 py-3.5 font-bold text-slate-700 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none transition-all"
                            placeholder="Contoh: Aditya Rahman">
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
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Kelas -->
                    <div>
                        <label for="kelas_id" class="block text-sm font-black text-slate-700 mb-2">
                            Kelas <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <select id="kelas_id" wire:model="kelas_id" x-model="formData.kelas_id"
                                class="w-full bg-slate-50 border @error('kelas_id') border-red-300 @else border-slate-200 @enderror rounded-xl px-4 py-3.5 font-bold text-slate-700 appearance-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none cursor-pointer transition-all">
                                <option value="">Pilih Kelas</option>
                                @foreach ($kelass as $kelas)
                                    <option value="{{ $kelas->id }}">{{ $kelas->nama_kelas }}</option>
                                @endforeach
                            </select>
                            <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path d="m6 9 6 6 6-6" />
                                </svg>
                            </div>
                        </div>
                        @error('kelas_id')
                            <p class="mt-2 text-sm font-bold text-red-600 flex items-center gap-1">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="10" />
                                    <line x1="12" y1="8" x2="12" y2="12" />
                                    <line x1="12" y1="16" x2="12.01" y2="16" />
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Tahun Ajaran -->
                    <div>
                        <label for="tahun_ajar_id" class="block text-sm font-black text-slate-700 mb-2">
                            Tahun Ajaran <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <select id="tahun_ajar_id" wire:model="tahun_ajar_id" x-model="formData.tahun_ajar_id"
                                class="w-full bg-slate-50 border @error('tahun_ajar_id') border-red-300 @else border-slate-200 @enderror rounded-xl px-4 py-3.5 font-bold text-slate-700 appearance-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none cursor-pointer transition-all">
                                <option value="">Pilih Tahun Ajaran</option>
                                @foreach ($tahunAjars as $tahun)
                                    <option value="{{ $tahun->id }}">{{ $tahun->nama }}</option>
                                @endforeach
                            </select>
                            <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path d="m6 9 6 6 6-6" />
                                </svg>
                            </div>
                        </div>
                        @error('tahun_ajar_id')
                            <p class="mt-2 text-sm font-bold text-red-600 flex items-center gap-1">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="10" />
                                    <line x1="12" y1="8" x2="12" y2="12" />
                                    <line x1="12" y1="16" x2="12.01" y2="16" />
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
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
                    <a href="{{ route('admin.data-siswa.index') }}" wire:navigate
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
                        <li>• NIS harus unik dan belum terdaftar</li>
                        <li>• Nama lengkap siswa sesuai dokumen resmi</li>
                        <li>• Pilih kelas yang sesuai dengan tingkat siswa</li>
                        <li>• Pilih tahun ajaran yang sedang aktif</li>
                        <li>• Pastikan semua data terisi dengan benar sebelum menyimpan</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <script>
    function formAutoSave(formName, fields) {
        return {
            uploading: false,
            
            formData: Alpine.$persist(
                fields.reduce((acc, field) => {
                    acc[field] = '';
                    return acc;
                }, {})
            ).as(formName),
            
            init() {
                Object.keys(this.formData).forEach(field => {
                    if (this.formData[field]) {
                        @this.set(field, this.formData[field]);
                    }
                });
                
                this.$watch('formData', value => {
                    console.log(`[${formName}] Auto-saved`);
                });
                
                Livewire.on('form-saved', () => {
                    this.clearFormData();
                });
            },
            
            clearFormData() {
                this.formData = fields.reduce((acc, field) => {
                    acc[field] = '';
                    return acc;
                }, {});
                localStorage.removeItem(formName);
            },
            
            hasData() {
                return Object.values(this.formData).some(val => val !== '');
            }
        }
    }
    </script>
</main>

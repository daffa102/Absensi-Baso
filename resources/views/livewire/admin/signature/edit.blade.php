<main class="flex-1 lg:ml-72 min-h-screen p-6 md:p-10" x-data="signatureEdit()">
    <!-- Header -->
    <header class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-10">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight">
                Edit Tanda Tangan
            </h1>
            <p class="text-slate-500 font-bold mt-1">
                Perbarui informasi tanda tangan Kepala Sekolah
            </p>
        </div>
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

    <!-- Form -->
    <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden"
        x-transition:enter="transition ease-out duration-500"
        x-transition:enter-start="opacity-0 translate-y-4"
        x-transition:enter-end="opacity-100 translate-y-0">
        <form wire:submit.prevent="update" class="p-8 md:p-10">
            <div class="max-w-2xl space-y-6">
                <!-- Role Selection -->
                <!-- Role Removed (Hardcoded to kepala_sekolah) -->

                <!-- Name -->
                <div x-data="{ focused: false }">
                    <label class="block text-sm font-black text-slate-700 mb-3">
                        Nama Lengkap <span class="text-red-500">*</span>
                    </label>
                    <input type="text" wire:model="name" x-model="formData.name" placeholder="Masukkan nama lengkap"
                        @focus="focused = true"
                        @blur="focused = false"
                        :class="focused ? 'ring-2 ring-blue-500/20 border-blue-500' : ''"
                        class="w-full bg-white border @error('name') border-red-300 @else border-slate-200 @enderror rounded-xl px-4 py-3.5 font-bold text-slate-700 placeholder:text-slate-400 focus:outline-none transition-all">
                    @error('name')
                        <p class="mt-2 text-sm font-bold text-red-600 flex items-center gap-1"
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 -translate-y-1"
                            x-transition:enter-end="opacity-100 translate-y-0">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10" />
                                <line x1="12" y1="8" x2="12" y2="12" />
                                <line x1="12" y1="16" x2="12.01" y2="16" />
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- NIP -->
                <div x-data="{ focused: false }">
                    <label class="block text-sm font-black text-slate-700 mb-3">
                        NIP <span class="text-slate-400 font-normal">(Opsional)</span>
                    </label>
                    <input type="text" wire:model="nip" x-model="formData.nip" placeholder="Masukkan NIP"
                        @focus="focused = true"
                        @blur="focused = false"
                        :class="focused ? 'ring-2 ring-blue-500/20 border-blue-500' : ''"
                        class="w-full bg-white border @error('nip') border-red-300 @else border-slate-200 @enderror rounded-xl px-4 py-3.5 font-bold text-slate-700 placeholder:text-slate-400 focus:outline-none transition-all">
                    @error('nip')
                        <p class="mt-2 text-sm font-bold text-red-600 flex items-center gap-1"
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 -translate-y-1"
                            x-transition:enter-end="opacity-100 translate-y-0">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10" />
                                <line x1="12" y1="8" x2="12" y2="12" />
                                <line x1="12" y1="16" x2="12.01" y2="16" />
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Active Status -->
                <!-- Removed nested x-data to use parent formData -->
                <div>
                    <label class="flex items-center gap-3 cursor-pointer group">
                        <div class="relative">
                            <input type="checkbox" x-model="formData.is_active" wire:model="is_active"
                                class="w-5 h-5 rounded border-slate-300 text-blue-600 focus:ring-2 focus:ring-blue-500/20 transition-all cursor-pointer">
                            <div x-show="formData.is_active"
                                x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="opacity-0 scale-50"
                                x-transition:enter-end="opacity-100 scale-100"
                                class="absolute inset-0 pointer-events-none flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none"
                                    stroke="white" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="20 6 9 17 4 12" />
                                </svg>
                            </div>
                        </div>
                        <span class="text-sm font-black text-slate-700 group-hover:text-blue-600 transition-colors">
                            Aktifkan tanda tangan ini
                        </span>
                    </label>
                    <p class="mt-2 text-xs font-bold ml-8 transition-all"
                        :class="formData.is_active ? 'text-green-600' : 'text-slate-500'">
                        <span x-show="formData.is_active">✓ Tanda tangan akan muncul pada dokumen export</span>
                        <span x-show="!formData.is_active">○ Tanda tangan tidak akan muncul pada dokumen export</span>
                    </p>
                </div>

                <!-- Current Signature Preview -->
                <div x-data="{ showCurrent: true }">
                    <label class="block text-sm font-black text-slate-700 mb-3 flex items-center justify-between">
                        <span>Tanda Tangan Saat Ini</span>
                        <button type="button" @click="showCurrent = !showCurrent"
                            class="text-xs font-bold text-blue-600 hover:text-blue-700 transition-colors">
                            <span x-show="showCurrent">Sembunyikan</span>
                            <span x-show="!showCurrent">Tampilkan</span>
                        </button>
                    </label>
                    <div x-show="showCurrent"
                        x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 max-h-0"
                        x-transition:enter-end="opacity-100 max-h-96"
                        x-transition:leave="transition ease-in duration-200"
                        x-transition:leave-start="opacity-100 max-h-96"
                        x-transition:leave-end="opacity-0 max-h-0"
                        class="bg-slate-50 rounded-2xl p-6 flex items-center justify-center overflow-hidden">
                        <img src="{{ Storage::url($currentSignaturePath) }}" alt="Tanda tangan saat ini"
                            class="max-h-40 max-w-full object-contain">
                    </div>
                </div>

                <!-- New Signature File Upload -->
                <div>
                    <label class="block text-sm font-black text-slate-700 mb-3">
                        Ganti File Tanda Tangan <span class="text-slate-400 font-normal">(Opsional)</span>
                    </label>
                    <div class="relative">
                        <input type="file" wire:model="signatureFile" accept="image/png,image/jpg,image/jpeg"
                            @change="fileSelected = true"
                            class="w-full bg-slate-50 border @error('signatureFile') border-red-300 @else border-slate-200 @enderror rounded-xl px-4 py-3.5 font-bold text-slate-700 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none transition-all file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-bold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 file:transition-all file:cursor-pointer">
                    </div>
                    @error('signatureFile')
                        <p class="mt-2 text-sm font-bold text-red-600 flex items-center gap-1"
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 -translate-y-1"
                            x-transition:enter-end="opacity-100 translate-y-0">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10" />
                                <line x1="12" y1="8" x2="12" y2="12" />
                                <line x1="12" y1="16" x2="12.01" y2="16" />
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                    
                    <!-- Loading Indicator -->
                    <div wire:loading wire:target="signatureFile" class="mt-3"
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0"
                        x-transition:enter-end="opacity-100">
                        <p class="text-sm font-bold text-blue-600 flex items-center gap-2">
                            <svg class="animate-spin" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M21 12a9 9 0 1 1-6.219-8.56"/>
                            </svg>
                            Mengupload file...
                        </p>
                    </div>

                    <!-- New Preview -->
                    @if ($previewUrl)
                        <div class="mt-4"
                            x-transition:enter="transition ease-out duration-300"
                            x-transition:enter-start="opacity-0 scale-95"
                            x-transition:enter-end="opacity-100 scale-100">
                            <p class="text-sm font-black text-slate-700 mb-2 flex items-center gap-2">
                                <span class="inline-block w-2 h-2 bg-green-500 rounded-full animate-pulse"></span>
                                Preview File Baru:
                            </p>
                            <div class="bg-slate-50 rounded-2xl p-6 flex items-center justify-center border-2 border-blue-200">
                                <img src="{{ $previewUrl }}" alt="Preview tanda tangan baru" class="max-h-40 max-w-full object-contain">
                            </div>
                        </div>
                    @endif

                    <!-- Info -->
                    <div class="mt-3 bg-blue-50 border border-blue-200 rounded-xl p-4"
                        x-transition:enter="transition ease-out duration-300 delay-100"
                        x-transition:enter-start="opacity-0 translate-y-2"
                        x-transition:enter-end="opacity-100 translate-y-0">
                        <div class="flex gap-3">
                            <div class="flex-shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"
                                    class="text-blue-600">
                                    <circle cx="12" cy="12" r="10" />
                                    <line x1="12" y1="16" x2="12" y2="12" />
                                    <line x1="12" y1="8" x2="12.01" y2="8" />
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-black text-blue-900 text-sm mb-1">Ketentuan File</h4>
                                <ul class="text-xs font-bold text-blue-800 space-y-1">
                                    <li>• Format: PNG, JPG, atau JPEG</li>
                                    <li>• Ukuran maksimal: 2MB</li>
                                    <li>• Kosongkan jika tidak ingin mengganti file</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Buttons -->
                <div class="flex items-center gap-3 pt-4">
                    <button type="submit"
                        :disabled="uploading"
                        :class="uploading ? 'opacity-50 cursor-not-allowed' : 'hover:bg-blue-700 hover:shadow-xl transform hover:scale-105'"
                        class="bg-blue-600 text-white px-8 py-3.5 rounded-xl font-black text-sm shadow-lg shadow-blue-500/30 transition-all flex items-center gap-2"
                        wire:loading.attr="disabled" wire:target="update">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z" />
                            <polyline points="17 21 17 13 7 13 7 21" />
                            <polyline points="7 3 7 8 15 8" />
                        </svg>
                        <span wire:loading.remove wire:target="update">Perbarui</span>
                        <span wire:loading wire:target="update" class="flex items-center gap-2">
                            <svg class="animate-spin" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M21 12a9 9 0 1 1-6.219-8.56"/>
                            </svg>
                            Memperbarui...
                        </span>
                    </button>
                    <a href="{{ route('admin.signature.index') }}" wire:navigate
                        class="bg-slate-100 text-slate-700 px-8 py-3.5 rounded-xl font-black text-sm hover:bg-slate-200 transition-all transform hover:scale-105">
                        Batal
                    </a>
                </div>
            </div>
        </form>
    </div>

    <script>
        function signatureEdit() {
            return {
                fileSelected: false,
                uploading: false,
                formData: Alpine.$persist({
                    role: '',
                    name: '',
                    nip: '',
                    is_active: true
                }).as('signature_edit_form_{{ $signatureId }}'),

                init() {
                    Livewire.on('upload-start', () => {
                        this.uploading = true;
                    });
                    
                    Livewire.on('upload-finish', () => {
                        this.uploading = false;
                    });

                    // Restore data if available and valid
                    if (this.formData.role) @this.set('role', this.formData.role);
                    if (this.formData.name) @this.set('name', this.formData.name);
                    if (this.formData.nip) @this.set('nip', this.formData.nip);
                    if (this.formData.is_active !== undefined) @this.set('is_active', this.formData.is_active);

                    // Clear storage on successful save
                    Livewire.on('form-saved', () => {
                        this.clearFormData(false);
                    });
                },

                hasData() {
                    // Check if there is meaningful unsaved data
                    // This is a simple check; for edit, we might want to check diff, 
                    // but for now existence of data in localstorage (implied by this.formData values) is enough logic
                    // However, Alpine.$persist always returns the object.
                    // We can check if it differs from empty? No, we should check if it's not default.
                    // But init loads it.
                    // Actually, simplicity: check if we have role or name.
                    return this.formData.name.length > 0 || this.formData.role.length > 0;
                },

                clearFormData(reload = true) {
                    localStorage.removeItem('_x_signature_edit_form_{{ $signatureId }}');
                    this.formData = {
                        role: '',
                        name: '',
                        nip: '',
                        is_active: true
                    };
                    if (reload) window.location.reload();
                }
            }
        }
    </script>
</main>

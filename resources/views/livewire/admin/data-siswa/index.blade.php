<main class="flex-1 lg:ml-72 min-h-screen p-6 md:p-10">
    <!-- Header -->
    <header class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-10">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight">
                Data Siswa
            </h1>
            <p class="text-slate-500 font-bold mt-1">
                Kelola data siswa di sekolah
            </p>
        </div>
        <div class="flex items-center gap-3">
            <button wire:click="openImportModal"
                class="bg-green-600 text-white px-6 py-3 rounded-xl font-black text-sm shadow-lg shadow-green-500/30 hover:bg-green-700 transition-all flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                    <polyline points="7 10 12 15 17 10" />
                    <line x1="12" y1="15" x2="12" y2="3" />
                </svg>
                Import Excel
            </button>
            <a href="{{ route('admin.data-siswa.create') }}" wire:navigate
                class="bg-blue-600 text-white px-6 py-3 rounded-xl font-black text-sm shadow-lg shadow-blue-500/30 hover:bg-blue-700 transition-all flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="12" y1="5" x2="12" y2="19" />
                    <line x1="5" y1="12" x2="19" y2="12" />
                </svg>
                Tambah Siswa
            </a>
        </div>
    </header>

    <!-- Flash Messages -->
    @if (session()->has('success'))
        <div
            class="mb-6 bg-green-50 border border-green-200 text-green-800 px-6 py-4 rounded-2xl flex items-center gap-3">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />
                <polyline points="22 4 12 14.01 9 11.01" />
            </svg>
            <span class="font-bold">{{ session('success') }}</span>
        </div>
    @endif

    @if (session()->has('warning'))
        <div
            class="mb-6 bg-amber-50 border border-amber-200 text-amber-800 px-6 py-4 rounded-2xl flex items-center gap-3">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z" />
                <line x1="12" y1="9" x2="12" y2="13" />
                <line x1="12" y1="17" x2="12.01" y2="17" />
            </svg>
            <span class="font-bold">{{ session('warning') }}</span>
        </div>
    @endif

    @if (session()->has('error'))
        <div class="mb-6 bg-red-50 border border-red-200 text-red-800 px-6 py-4 rounded-2xl flex items-center gap-3">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10" />
                <line x1="15" y1="9" x2="9" y2="15" />
                <line x1="9" y1="9" x2="15" y2="15" />
            </svg>
            <span class="font-bold">{{ session('error') }}</span>
        </div>
    @endif

    <!-- Search Bar -->
    <div class="mb-6">
        <div class="relative max-w-md">
            <input type="text" wire:model.live="search" placeholder="Cari nama atau NIS siswa..."
                class="w-full bg-white border border-slate-200 rounded-xl pl-12 pr-4 py-3.5 text-sm font-bold focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none shadow-sm">
            <svg class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400" xmlns="http://www.w3.org/2000/svg"
                width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="11" cy="11" r="8" />
                <path d="m21 21-4.3-4.3" />
            </svg>
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-slate-50/50">
                        <th class="px-8 py-5 text-xs font-black text-slate-400 uppercase tracking-wider">No</th>
                        <th class="px-8 py-5 text-xs font-black text-slate-400 uppercase tracking-wider">NIS</th>
                        <th class="px-8 py-5 text-xs font-black text-slate-400 uppercase tracking-wider">Nama Siswa
                        </th>
                        <th class="px-8 py-5 text-xs font-black text-slate-400 uppercase tracking-wider">Kelas</th>
                        <th class="px-8 py-5 text-xs font-black text-slate-400 uppercase tracking-wider">Tahun Ajaran
                        </th>
                        <th class="px-8 py-5 text-xs font-black text-slate-400 uppercase tracking-wider text-center">
                            Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse ($siswas as $index => $siswa)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-8 py-5">
                                <span class="text-sm font-bold text-slate-600">
                                    {{ $siswas->firstItem() + $index }}
                                </span>
                            </td>
                            <td class="px-8 py-5">
                                <span class="text-sm font-bold text-slate-900">{{ $siswa->nis }}</span>
                            </td>
                            <td class="px-8 py-5">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center text-blue-600 font-bold text-sm">
                                        {{ strtoupper(substr($siswa->nama, 0, 2)) }}
                                    </div>
                                    <div>
                                        <p class="text-sm font-black text-slate-900">{{ $siswa->nama }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-8 py-5">
                                <span class="text-sm font-bold text-slate-600">
                                    {{ $siswa->kelas->nama_kelas ?? '-' }}
                                </span>
                            </td>
                            <td class="px-8 py-5">
                                <span class="text-sm font-bold text-slate-600">
                                    {{ $siswa->tahun_ajar->nama ?? '-' }}
                                </span>
                            </td>
                            <td class="px-8 py-5">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('admin.data-siswa.edit', $siswa->id) }}" wire:navigate
                                        class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors"
                                        title="Edit">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z" />
                                            <path d="m15 5 4 4" />
                                        </svg>
                                    </a>
                                    <button wire:click="delete({{ $siswa->id }})"
                                        wire:confirm="Apakah Anda yakin ingin menghapus siswa {{ $siswa->nama }}?"
                                        class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors"
                                        title="Hapus">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M3 6h18" />
                                            <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6" />
                                            <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2" />
                                            <line x1="10" y1="11" x2="10" y2="17" />
                                            <line x1="14" y1="11" x2="14" y2="17" />
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-8 py-12 text-center">
                                <div class="flex flex-col items-center gap-3">
                                    <div
                                        class="w-16 h-16 bg-slate-100 rounded-2xl flex items-center justify-center text-slate-400">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                                            <circle cx="9" cy="7" r="4" />
                                            <path d="M22 21v-2a4 4 0 0 0-3-3.87" />
                                            <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-slate-900 font-black text-lg">Tidak ada data siswa</p>
                                        <p class="text-slate-500 font-bold text-sm mt-1">
                                            @if ($search)
                                                Tidak ditemukan siswa dengan kata kunci "{{ $search }}"
                                            @else
                                                Mulai tambahkan data siswa baru atau import dari Excel
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if ($siswas->hasPages())
            <div class="px-8 py-6 border-t border-slate-100">
                {{ $siswas->links() }}
            </div>
        @endif
    </div>

    <!-- Import Modal -->
    @if ($showImportModal)
        <div class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4"
            wire:click="closeImportModal">
            <div class="bg-white rounded-[2rem] shadow-2xl max-w-2xl w-full" wire:click.stop>
                <!-- Modal Header -->
                <div class="p-8 border-b border-slate-100 flex items-center justify-between">
                    <div>
                        <h3 class="text-2xl font-black text-slate-900">Import Data Siswa</h3>
                        <p class="text-slate-500 font-bold text-sm mt-1">Upload file Excel untuk import data siswa</p>
                    </div>
                    <button wire:click="closeImportModal"
                        class="text-slate-400 hover:text-slate-600 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
                            stroke-linejoin="round">
                            <line x1="18" y1="6" x2="6" y2="18" />
                            <line x1="6" y1="6" x2="18" y2="18" />
                        </svg>
                    </button>
                </div>

                <!-- Modal Body -->
                <form wire:submit.prevent="importExcel" class="p-8 space-y-6">
                    <!-- File Upload -->
                    <div>
                        <label class="block text-sm font-black text-slate-700 mb-3">
                            File Excel <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input type="file" wire:model="importFile" accept=".xlsx,.xls"
                                class="w-full bg-slate-50 border @error('importFile') border-red-300 @else border-slate-200 @enderror rounded-xl px-4 py-3.5 font-bold text-slate-700 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none transition-all file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-bold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                        </div>
                        @error('importFile')
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
                        @if ($importFile)
                            <p class="mt-2 text-sm font-bold text-green-600 flex items-center gap-1">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="20 6 9 17 4 12" />
                                </svg>
                                File dipilih: {{ $importFile->getClientOriginalName() }}
                            </p>
                        @endif
                    </div>

                    <!-- Info Card -->
                    <div class="bg-blue-50 border border-blue-200 rounded-xl p-4">
                        <div class="flex gap-3">
                            <div class="flex-shrink-0">
                                <div
                                    class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center text-white">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <circle cx="12" cy="12" r="10" />
                                        <line x1="12" y1="16" x2="12" y2="12" />
                                        <line x1="12" y1="8" x2="12.01" y2="8" />
                                    </svg>
                                </div>
                            </div>
                            <div>
                                <h4 class="font-black text-blue-900 text-sm mb-1">Format File Excel</h4>
                                <ul class="text-xs font-bold text-blue-800 space-y-1 mb-2">
                                    <li>• Kolom 1: NIS (wajib)</li>
                                    <li>• Kolom 2: Nama Siswa (wajib)</li>
                                    <li>• Kolom 3: Nama Kelas (opsional)</li>
                                    <li>• Kolom 4: Tahun Ajaran (opsional)</li>
                                    <li>• Baris pertama adalah header (akan dilewati)</li>
                                </ul>
                                <button type="button" wire:click="downloadTemplate" 
                                    class="text-xs font-black text-blue-600 hover:text-blue-800 underline transition-colors flex items-center gap-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                                    Download Template Excel
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Buttons -->
                    <div class="flex items-center gap-3 pt-4">
                        <button type="submit"
                            class="bg-green-600 text-white px-8 py-3.5 rounded-xl font-black text-sm shadow-lg shadow-green-500/30 hover:bg-green-700 transition-all flex items-center gap-2"
                            wire:loading.attr="disabled" wire:target="importExcel">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                                <polyline points="7 10 12 15 17 10" />
                                <line x1="12" y1="15" x2="12" y2="3" />
                            </svg>
                            <span wire:loading.remove wire:target="importExcel">Import Data</span>
                            <span wire:loading wire:target="importExcel">Mengimport...</span>
                        </button>
                        <button type="button" wire:click="closeImportModal"
                            class="bg-slate-100 text-slate-700 px-8 py-3.5 rounded-xl font-black text-sm hover:bg-slate-200 transition-all">
                            Batal
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</main>

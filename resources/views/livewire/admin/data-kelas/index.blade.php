<main class="flex-1 lg:ml-72 min-h-screen p-6 md:p-10">
    <!-- Header -->
    <header class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-10">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight">
                Data Kelas
            </h1>
            <p class="text-slate-500 font-bold mt-1">
                Kelola data kelas di sekolah
            </p>
        </div>
        <a href="{{ route('admin.data-kelas.create') }}" wire:navigate
            class="bg-blue-600 text-white px-6 py-3 rounded-xl font-black text-sm shadow-lg shadow-blue-500/30 hover:bg-blue-700 transition-all flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <line x1="12" y1="5" x2="12" y2="19" />
                <line x1="5" y1="12" x2="19" y2="12" />
            </svg>
            Tambah Kelas
        </a>
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

    <!-- Search Bar -->
    <div class="mb-6">
        <div class="relative max-w-md">
            <input type="text" wire:model.live="search" placeholder="Cari nama kelas..."
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
                        <th class="px-8 py-5 text-xs font-black text-slate-400 uppercase tracking-wider">
                            No
                        </th>
                        <th class="px-8 py-5 text-xs font-black text-slate-400 uppercase tracking-wider">
                            Nama Kelas
                        </th>
                        <th class="px-8 py-5 text-xs font-black text-slate-400 uppercase tracking-wider">
                            Jumlah Siswa
                        </th>
                        <th class="px-8 py-5 text-xs font-black text-slate-400 uppercase tracking-wider">
                            Dibuat
                        </th>
                        <th class="px-8 py-5 text-xs font-black text-slate-400 uppercase tracking-wider text-center">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse ($kelass as $index => $kelas)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-8 py-5">
                                <span class="text-sm font-bold text-slate-600">
                                    {{ $kelass->firstItem() + $index }}
                                </span>
                            </td>
                            <td class="px-8 py-5">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center text-blue-600 font-bold text-sm">
                                        {{ substr($kelas->nama_kelas, 0, 2) }}
                                    </div>
                                    <div>
                                        <p class="text-sm font-black text-slate-900">
                                            {{ $kelas->nama_kelas }}
                                        </p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-8 py-5">
                                <span class="text-sm font-bold text-slate-600">
                                    {{ $kelas->siswas->count() }} siswa
                                </span>
                            </td>
                            <td class="px-8 py-5">
                                <span class="text-sm font-bold text-slate-600">
                                    {{ $kelas->created_at->format('d M Y') }}
                                </span>
                            </td>
                            <td class="px-8 py-5">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('admin.data-kelas.edit', $kelas->id) }}" wire:navigate
                                        class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors"
                                        title="Edit">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z" />
                                            <path d="m15 5 4 4" />
                                        </svg>
                                    </a>
                                    <button wire:click="delete({{ $kelas->id }})"
                                        wire:confirm="Apakah Anda yakin ingin menghapus kelas {{ $kelas->nama_kelas }}?"
                                        class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors"
                                        title="Hapus">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
                                            stroke-linecap="round" stroke-linejoin="round">
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
                            <td colspan="5" class="px-8 py-12 text-center">
                                <div class="flex flex-col items-center gap-3">
                                    <div
                                        class="w-16 h-16 bg-slate-100 rounded-2xl flex items-center justify-center text-slate-400">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M3 9h18v10a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V9Z" />
                                            <path d="M3 9V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v4" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-slate-900 font-black text-lg">Tidak ada data kelas</p>
                                        <p class="text-slate-500 font-bold text-sm mt-1">
                                            @if ($search)
                                                Tidak ditemukan kelas dengan kata kunci "{{ $search }}"
                                            @else
                                                Mulai tambahkan data kelas baru
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
        @if ($kelass->hasPages())
            <div class="px-8 py-6 border-t border-slate-100">
                {{ $kelass->links() }}
            </div>
        @endif
    </div>
</main>

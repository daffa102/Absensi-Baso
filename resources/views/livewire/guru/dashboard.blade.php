<main class="flex-1 min-h-screen p-6 md:p-10">
    <!-- Header with Logout -->
    <header class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-10">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight">
                Dashboard Guru
            </h1>
            <p class="text-slate-500 font-bold mt-1">
                Kelola absensi siswa hari ini - {{ date('d M Y') }}
            </p>
        </div>
        <div class="flex items-center gap-3">
            <form action="{{ route('logout') }}" method="POST"
                onsubmit="return confirm('Apakah Anda yakin ingin keluar?')">
                @csrf
                <button type="submit"
                    class="bg-red-50 text-red-600 px-6 py-3 rounded-xl font-black text-sm hover:bg-red-100 transition-all flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                        <polyline points="16 17 21 12 16 7" />
                        <line x1="21" y1="12" x2="9" y2="12" />
                    </svg>
                    Logout
                </button>
            </form>
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

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-10">
        <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-slate-100 flex items-center gap-5">
            <div class="w-14 h-14 bg-blue-100 text-blue-600 rounded-2xl flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                    <circle cx="9" cy="7" r="4" />
                    <path d="M22 21v-2a4 4 0 0 0-3-3.87" />
                    <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                </svg>
            </div>
            <div>
                <p class="text-xs font-black text-slate-400 uppercase">Total Siswa</p>
                <h4 class="text-2xl font-black text-slate-900">{{ number_format($totalSiswa) }}</h4>
            </div>
        </div>

        <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-slate-100 flex items-center gap-5">
            <div class="w-14 h-14 bg-green-100 text-green-600 rounded-2xl flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M20 6 9 17l-5-5" />
                </svg>
            </div>
            <div>
                <p class="text-xs font-black text-slate-400 uppercase">Hadir Hari Ini</p>
                <h4 class="text-2xl font-black text-slate-900">{{ number_format($totalHadir) }}</h4>
            </div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
        <!-- Filter Kelas -->
        <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-slate-100">
            <label class="text-xs font-black text-slate-400 uppercase block mb-3">Pilih Kelas</label>
            <div class="relative">
                <select wire:model.live="selectedKelas"
                    class="w-full bg-slate-50 border-none rounded-xl px-4 py-3.5 font-bold text-slate-700 appearance-none focus:ring-2 focus:ring-blue-500/20 outline-none cursor-pointer">
                    <option value="">Pilih Kelas</option>
                    @foreach ($kelasList as $kelas)
                        <option value="{{ $kelas->id }}">{{ $kelas->nama_kelas }}</option>
                    @endforeach
                </select>
                <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path d="m6 9 6 6 6-6" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Search -->
        <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-slate-100">
            <label class="text-xs font-black text-slate-400 uppercase block mb-3">Cari Siswa</label>
            <div class="relative">
                <input type="text" wire:model.live="search" placeholder="Nama siswa..."
                    class="w-full bg-slate-50 border-none rounded-xl pl-12 pr-4 py-3.5 font-bold text-slate-700 focus:ring-2 focus:ring-blue-500/20 outline-none">
                <svg class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"
                    xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                    fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
                    stroke-linejoin="round">
                    <circle cx="11" cy="11" r="8" />
                    <path d="m21 21-4.3-4.3" />
                </svg>
            </div>
        </div>
    </div>

    <!-- Absensi Table -->
    @if ($selectedKelas)
        <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden">
            <div class="p-8 border-b border-slate-50">
                <h3 class="text-xl font-black text-slate-900">Input Absensi</h3>
                <p class="text-slate-400 text-sm font-bold mt-1">
                    Tandai kehadiran siswa untuk hari ini
                </p>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-slate-50/50">
                            <th class="px-8 py-5 text-xs font-black text-slate-400 uppercase">No</th>
                            <th class="px-8 py-5 text-xs font-black text-slate-400 uppercase">NIS</th>
                            <th class="px-8 py-5 text-xs font-black text-slate-400 uppercase">Nama Siswa</th>
                            <th class="px-8 py-5 text-xs font-black text-slate-400 uppercase">Status Kehadiran</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse ($siswas as $index => $siswa)
                            @php
                                $existing = $existingAbsensi->get($siswa->id);
                                $currentStatus =
                                    $absensiData[$siswa->id]['status'] ?? ($existing ? $existing->status : '');
                            @endphp
                            <tr wire:key="siswa-{{ $siswa->id }}" class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-8 py-5">
                                    <span class="text-sm font-bold text-slate-600">{{ $index + 1 }}</span>
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
                                        <p class="text-sm font-black text-slate-900">{{ $siswa->nama }}</p>
                                    </div>
                                </td>
                                <!-- Status Multiple Choice -->
                                <td class="px-8 py-5" x-data="{ localStatus: '{{ $currentStatus }}' }">
                                    <div class="flex items-center gap-2">
                                        <!-- Hadir -->
                                        <button type="button"
                                            @click="localStatus = 'Hadir'; $wire.setStatus({{ $siswa->id }}, 'Hadir')"
                                            :class="localStatus === 'Hadir' ?
                                                'bg-green-600 text-white shadow-lg shadow-green-500/30' :
                                                'bg-slate-100 text-slate-600 hover:bg-green-100 hover:text-green-600'"
                                            class="px-4 py-2 rounded-lg text-xs font-black uppercase transition-all">
                                            Hadir
                                        </button>
                                        <!-- Sakit -->
                                        <button type="button"
                                            @click="localStatus = 'Sakit'; $wire.setStatus({{ $siswa->id }}, 'Sakit')"
                                            :class="localStatus === 'Sakit' ?
                                                'bg-amber-600 text-white shadow-lg shadow-amber-500/30' :
                                                'bg-slate-100 text-slate-600 hover:bg-amber-100 hover:text-amber-600'"
                                            class="px-4 py-2 rounded-lg text-xs font-black uppercase transition-all">
                                            Sakit
                                        </button>
                                        <!-- Izin -->
                                        <button type="button"
                                            @click="localStatus = 'Izin'; $wire.setStatus({{ $siswa->id }}, 'Izin')"
                                            :class="localStatus === 'Izin' ?
                                                'bg-blue-600 text-white shadow-lg shadow-blue-500/30' :
                                                'bg-slate-100 text-slate-600 hover:bg-blue-100 hover:text-blue-600'"
                                            class="px-4 py-2 rounded-lg text-xs font-black uppercase transition-all">
                                            Izin
                                        </button>
                                        <!-- Alpa -->
                                        <button type="button"
                                            @click="localStatus = 'Alpa'; $wire.setStatus({{ $siswa->id }}, 'Alpa')"
                                            :class="localStatus === 'Alpa' ?
                                                'bg-red-600 text-white shadow-lg shadow-red-500/30' :
                                                'bg-slate-100 text-slate-600 hover:bg-red-100 hover:text-red-600'"
                                            class="px-4 py-2 rounded-lg text-xs font-black uppercase transition-all">
                                            Alpa
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-8 py-12 text-center">
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
                                                    Tidak ada siswa di kelas ini
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

            @if ($siswas->count() > 0)
                <div class="p-8 border-t border-slate-50 flex justify-between items-center">
                    <p class="text-sm font-bold text-slate-500">
                        Total: {{ $siswas->count() }} siswa
                    </p>
                    <button wire:click="saveAbsensi"
                        class="bg-blue-600 text-white px-8 py-3.5 rounded-xl font-black text-sm shadow-lg shadow-blue-500/30 hover:bg-blue-700 transition-all flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z" />
                            <polyline points="17 21 17 13 7 13 7 21" />
                            <polyline points="7 3 7 8 15 8" />
                        </svg>
                        @if ($existingAbsensi->count() > 0)
                            Update Absensi
                        @else
                            Simpan Absensi
                        @endif
                    </button>
                </div>
            @endif
        </div>
    @else
        <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 p-12 text-center">
            <div class="flex flex-col items-center gap-3">
                <div class="w-16 h-16 bg-blue-100 rounded-2xl flex items-center justify-center text-blue-600">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path d="M3 9h18v10a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V9Z" />
                        <path d="M3 9V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v4" />
                    </svg>
                </div>
                <div>
                    <p class="text-slate-900 font-black text-lg">Pilih Kelas</p>
                    <p class="text-slate-500 font-bold text-sm mt-1">
                        Silakan pilih kelas terlebih dahulu untuk input absensi
                    </p>
                </div>
            </div>
        </div>
    @endif
</main>

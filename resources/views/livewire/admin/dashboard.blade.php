<main class="flex-1 lg:ml-72 min-h-screen p-6 md:p-10">
    <!-- Header -->
    <header class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-10">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight">
                Overview Dashboard
            </h1>
            <p class="text-slate-500 font-bold mt-1">
                Selamat datang kembali, Admin!
            </p>
        </div>
    </header>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
        <!-- Total Siswa -->
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

        <!-- Total Kelas -->
        <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-slate-100 flex items-center gap-5">
            <div class="w-14 h-14 bg-amber-100 text-amber-600 rounded-2xl flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M3 9h18v10a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V9Z" />
                    <path d="M3 9V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v4" />
                </svg>
            </div>
            <div>
                <p class="text-xs font-black text-slate-400 uppercase">Total Kelas</p>
                <h4 class="text-2xl font-black text-slate-900">{{ \App\Models\Kelas::count() }}</h4>
            </div>
        </div>

        <!-- Siswa Hadir Hari Ini -->
        <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-slate-100 flex items-center gap-5">
            <div class="w-14 h-14 bg-green-100 text-green-600 rounded-2xl flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M20 6 9 17l-5-5" />
                </svg>
            </div>
            <div>
                <p class="text-xs font-black text-slate-400 uppercase">Hadir Hari Ini</p>
                <h4 class="text-2xl font-black text-slate-900">{{ number_format($hadirToday) }}</h4>
            </div>
        </div>

        <!-- Siswa Tidak Hadir Hari Ini -->
        <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-slate-100 flex items-center gap-5">
            <div class="w-14 h-14 bg-red-100 text-red-600 rounded-2xl flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="18" y1="6" x2="6" y2="18" />
                    <line x1="6" y1="6" x2="18" y2="18" />
                </svg>
            </div>
            <div>
                <p class="text-xs font-black text-slate-400 uppercase">Tidak Hadir</p>
                <h4 class="text-2xl font-black text-slate-900">
                    {{ number_format($sakitToday + $izinToday + $alpaToday) }}
                </h4>
            </div>
        </div>
    </div>

    <!-- Recent Activity / Table -->
    <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden">
        <div class="p-8 border-b border-slate-50">
            <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 mb-6">
                <div>
                    <h3 class="text-xl font-black text-slate-900">Absensi Terbaru</h3>
                    <p class="text-slate-400 text-sm font-bold">
                        Data siswa yang tidak hadir hari ini
                    </p>
                </div>

                <!-- Export Buttons -->
                <div class="flex items-center gap-3">
                    <button wire:click="exportExcel"
                        class="bg-green-600 text-white px-5 py-2.5 rounded-xl font-black text-sm shadow-lg shadow-green-500/30 hover:bg-green-700 transition-all flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z" />
                            <polyline points="14 2 14 8 20 8" />
                        </svg>
                        Export Excel
                    </button>
                    <button wire:click="exportPdf"
                        class="bg-red-600 text-white px-5 py-2.5 rounded-xl font-black text-sm shadow-lg shadow-red-500/30 hover:bg-red-700 transition-all flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z" />
                            <polyline points="14 2 14 8 20 8" />
                        </svg>
                        Export PDF
                    </button>
                </div>
            </div>

            <!-- Filter Kelas -->
            <div class="bg-slate-50 p-4 rounded-2xl">
                <label class="text-xs font-black text-slate-400 uppercase block mb-2">Filter Kelas</label>
                <div class="relative">
                    <select wire:model.live="selectedKelas"
                        class="w-full bg-white border-none rounded-xl px-4 py-3 font-bold text-slate-700 appearance-none focus:ring-2 focus:ring-blue-500/20 outline-none cursor-pointer">
                        <option value="">Semua Kelas</option>
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
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-slate-50/50">
                        <th class="px-8 py-5 text-xs font-black text-slate-400 uppercase">
                            Siswa
                        </th>
                        <th class="px-8 py-5 text-xs font-black text-slate-400 uppercase">
                            Kelas
                        </th>
                        <th class="px-8 py-5 text-xs font-black text-slate-400 uppercase">
                            Status
                        </th>
                        <th class="px-8 py-5 text-xs font-black text-slate-400 uppercase">
                            Keterangan
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse ($absentList as $absensi)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-8 py-5">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-9 h-9 {{ $absensi->status === 'Sakit' ? 'bg-amber-100 text-amber-600' : ($absensi->status === 'Izin' ? 'bg-blue-100 text-blue-600' : 'bg-red-100 text-red-600') }} rounded-lg flex items-center justify-center font-bold text-sm">
                                        {{ strtoupper(substr($absensi->siswa->nama ?? 'N/A', 0, 2)) }}
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold text-slate-900">
                                            {{ $absensi->siswa->nama ?? 'N/A' }}
                                        </p>
                                        <p class="text-[11px] font-bold text-slate-400 uppercase tracking-tighter">
                                            NIS: {{ $absensi->siswa->nis ?? '-' }}
                                        </p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-8 py-5 text-sm font-bold text-slate-600">
                                {{ $absensi->kelas->nama_kelas ?? '-' }}
                            </td>
                            <td class="px-8 py-5">
                                @if ($absensi->status === 'Sakit')
                                    <span
                                        class="inline-flex px-3 py-1 rounded-full bg-amber-100 text-amber-600 text-[11px] font-black uppercase">Sakit</span>
                                @elseif($absensi->status === 'Izin')
                                    <span
                                        class="inline-flex px-3 py-1 rounded-full bg-blue-100 text-blue-600 text-[11px] font-black uppercase">Izin</span>
                                @else
                                    <span
                                        class="inline-flex px-3 py-1 rounded-full bg-red-100 text-red-600 text-[11px] font-black uppercase">Alpa</span>
                                @endif
                            </td>
                            <td class="px-8 py-5 text-sm font-bold text-slate-600">
                                {{ $absensi->keterangan ?? '-' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-8 py-12 text-center">
                                <div class="flex flex-col items-center gap-3">
                                    <div
                                        class="w-16 h-16 bg-green-100 rounded-2xl flex items-center justify-center text-green-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M20 6 9 17l-5-5" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-slate-900 font-black text-lg">Semua Siswa Hadir!</p>
                                        <p class="text-slate-500 font-bold text-sm mt-1">
                                            Tidak ada siswa yang sakit, izin, atau alpa hari ini
                                        </p>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</main>

<div class="card" x-data="formAutoSave('guru_edit_filters', ['tanggal', 'tahun_ajar_id', 'kelas_id'])">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
        <h2>Edit Absensi Siswa</h2>
    </div>

    @if (session()->has('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Auto-save Indicator -->
    <div x-show="hasData()"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 -translate-y-2"
        x-transition:enter-end="opacity-100 translate-y-0"
        class="alert alert-info" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
        <div>
            <strong>Filter Tersimpan Otomatis</strong>
            <div style="font-size: 0.9em;">Pilihan filter Anda tersimpan di browser.</div>
        </div>
        <button @click="clearFormData()" type="button" class="btn btn-sm btn-light">
            Reset Filter
        </button>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 1rem; margin-bottom: 1.5rem;">
        <div class="form-group">
            <label>Tanggal Absensi</label>
            <input type="date" wire:model.live="tanggal" x-model="formData.tanggal" class="form-control">
        </div>
        <div class="form-group">
            <label>Pilih Tahun Ajar</label>
            <select wire:model.live="tahun_ajar_id" x-model="formData.tahun_ajar_id" class="form-control">
                <option value="">-- Pilih Tahun --</option>
                @foreach($tahunAjars as $ta)
                    <option value="{{ $ta->id }}">{{ $ta->nama }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label>Pilih Kelas</label>
            <select wire:model.live="kelas_id" x-model="formData.kelas_id" class="form-control">
                <option value="">-- Pilih Kelas --</option>
                @foreach($kelass as $kelas)
                    <option value="{{ $kelas->id }}">{{ $kelas->nama_kelas }}</option>
                @endforeach
            </select>
        </div>
    </div>

    @if($kelas_id && $tahun_ajar_id && $tanggal)
        @if(count($siswas) > 0)
            <form wire:submit.prevent="save">
                <table>
                    <thead>
                        <tr>
                            <th>NIS</th>
                            <th>Nama Siswa</th>
                            <th style="width: 300px;">Status Kehadiran</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($siswas as $siswa)
                        <tr wire:key="siswa-{{ $siswa->id }}">
                            <td>{{ $siswa->nis }}</td>
                            <td>{{ $siswa->nama }}</td>
                            <td>
                                <div class="radio-group">
                                    <label class="radio-label">
                                        <input type="radio" wire:model="attendanceData.{{ $siswa->id }}" value="Hadir"> Hadir
                                    </label>
                                    <label class="radio-label">
                                        <input type="radio" wire:model="attendanceData.{{ $siswa->id }}" value="Sakit"> Sakit
                                    </label>
                                    <label class="radio-label">
                                        <input type="radio" wire:model="attendanceData.{{ $siswa->id }}" value="Izin"> Izin
                                    </label>
                                    <label class="radio-label">
                                        <input type="radio" wire:model="attendanceData.{{ $siswa->id }}" value="Alpa"> Alpa
                                    </label>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                
                <div style="margin-top: 2rem; text-align: right;">
                    <button type="submit" class="btn btn-primary" style="font-size: 1.1em; padding: 0.75rem 2rem;">Simpan Perubahan</button>
                </div>
            </form>
        @else
            <p style="text-align: center; color: #666; padding: 2rem;">Tidak ada siswa ditemukan.</p>
        @endif
    @else
        <p style="text-align: center; color: #666; padding: 2rem;">Silakan lengkapi filter di atas.</p>
    @endif
</div>

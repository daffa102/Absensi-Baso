<?php

namespace App\Livewire\Guru;

use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\TahunAjar;
use App\Models\Absensi;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class GuruEdit extends Component
{
    public $kelas_id;
    public $tahun_ajar_id;
    public $tanggal;
    
    // Maps siswa_id => status
    public $attendanceData = [];

    public function mount()
    {
        // Default to yesterday or allow user to pick
        $this->tanggal = date('Y-m-d', strtotime('-1 day'));
        
        $activeYear = TahunAjar::where('aktif', true)->first();
        if ($activeYear) {
            $this->tahun_ajar_id = $activeYear->id;
        }
    }

    public function updatedKelasId() { $this->loadStudents(); }
    public function updatedTahunAjarId() { $this->loadStudents(); }
    public function updatedTanggal() { $this->loadStudents(); }

    public function loadStudents()
    {
        $this->attendanceData = [];

        if (!$this->kelas_id || !$this->tahun_ajar_id || !$this->tanggal) {
            return;
        }

        $siswas = Siswa::where('kelas_id', $this->kelas_id)
            ->where('tahun_ajar_id', $this->tahun_ajar_id)
            ->with(['absensis' => function ($query) {
                $query->where('tanggal', $this->tanggal);
            }])
            ->get();

        foreach ($siswas as $siswa) {
            $existing = $siswa->absensis->first();
            // If editing, we only really care about existing records, 
            // but we can default to 'Hadir' if they want to back-fill
            $this->attendanceData[$siswa->id] = $existing ? $existing->status : 'Hadir';
        }
    }

    public function save()
    {
        $this->validate([
            'kelas_id' => 'required',
            'tahun_ajar_id' => 'required',
            'tanggal' => 'required|date',
            'attendanceData' => 'required|array',
        ]);

        DB::transaction(function () {
            foreach ($this->attendanceData as $siswaId => $status) {
                Absensi::updateOrCreate(
                    [
                        'siswa_id' => $siswaId,
                        'tanggal' => $this->tanggal,
                    ],
                    [
                        'kelas_id' => $this->kelas_id,
                        'tahun_ajar_id' => $this->tahun_ajar_id,
                        'status' => $status,
                    ]
                );
            }
        });

        $this->dispatch('form-saved');

        session()->flash('success', 'Perubahan absensi berhasil disimpan.');
    }

    public function render()
    {
        return view('livewire.guru.edit', [
            'kelass' => Kelas::all(),
            'tahunAjars' => TahunAjar::all(),
            'siswas' => ($this->kelas_id && $this->tahun_ajar_id) 
                ? Siswa::where('kelas_id', $this->kelas_id)
                    ->where('tahun_ajar_id', $this->tahun_ajar_id)
                    ->orderBy('nama')
                    ->get() 
                : [],
        ]);
    }
}

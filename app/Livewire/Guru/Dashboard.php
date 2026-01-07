<?php

namespace App\Livewire\Guru;

use App\Models\Siswa;
use App\Models\Kelas;
<<<<<<< HEAD
use Livewire\Attributes\Layout;
=======
use App\Models\TahunAjar;
use App\Models\Absensi;
>>>>>>> 2d8fa0d8b4e5a5e7881a283ce47d0ea71c73a0d5
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class Dashboard extends Component
{
<<<<<<< HEAD
    #[Layout('components.layouts.guru')]
    
    public $selectedKelas = '';
    public $search = '';
    public $absensiData = [];
    
    public function mount()
    {
        // Initialize absensi data array
        $this->absensiData = [];
    }
    
    public function updatedSelectedKelas()
    {
        // Reset absensi data when kelas changes
        $this->absensiData = [];
    }
    
    public function saveAbsensi()
    {
        if (empty($this->absensiData)) {
            session()->flash('error', 'Tidak ada data absensi untuk disimpan.');
            return;
        }
        
        $today = date('Y-m-d');
        $saved = 0;
        
        foreach ($this->absensiData as $siswaId => $data) {
            if (isset($data['status'])) {
                Absensi::updateOrCreate(
                    [
                        'tanggal' => $today,
                        'siswa_id' => $siswaId,
                    ],
                    [
                        'kelas_id' => $this->selectedKelas,
                        'guru_piket_id' => auth()->id(),
                        'status' => $data['status'],
                        'keterangan' => null,
                    ]
                );
                $saved++;
            }
        }
        
        session()->flash('success', "Berhasil menyimpan {$saved} data absensi.");
        // Don't reset $absensiData so status remains visible
    }
    
    public function setStatus($siswaId, $status)
    {
        $this->absensiData[$siswaId]['status'] = $status;
    }
    
=======
    public $kelas_id;
    public $tahun_ajar_id;
    public $tanggal;
    
    // Maps siswa_id => status (Hadir, Sakit, Izin, Alpa)
    public $attendanceData = [];

    public function mount()
    {
        $this->tanggal = date('Y-m-d');
        // Default to first active academic year if available
        $activeYear = TahunAjar::where('aktif', true)->first();
        if ($activeYear) {
            $this->tahun_ajar_id = $activeYear->id;
        }
    }

    public function updatedKelasId()
    {
        $this->loadStudents();
    }

    public function updatedTahunAjarId()
    {
        $this->loadStudents();
    }

    public function loadStudents()
    {
        $this->attendanceData = [];

        if (!$this->kelas_id || !$this->tahun_ajar_id) {
            return;
        }

        // Efficiently fetch students and their existing attendance for today
        $siswas = Siswa::where('kelas_id', $this->kelas_id)
            ->where('tahun_ajar_id', $this->tahun_ajar_id)
            ->with(['absensis' => function ($query) {
                $query->where('tanggal', $this->tanggal);
            }])
            ->get();

        foreach ($siswas as $siswa) {
            // Pre-fill with existing status or default to 'Hadir'
            $existing = $siswa->absensis->first();
            $this->attendanceData[$siswa->id] = $existing ? $existing->status : 'Hadir';
        }
    }

    public function save()
    {
        $this->validate([
            'kelas_id' => 'required',
            'tahun_ajar_id' => 'required',
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

        session()->flash('success', 'Data absensi berhasil disimpan.');
    }

>>>>>>> 2d8fa0d8b4e5a5e7881a283ce47d0ea71c73a0d5
    public function render()
    {
        $today = date('Y-m-d');
        
        $siswasQuery = Siswa::with(['kelas', 'tahun_ajar']);
        
        if ($this->selectedKelas) {
            $siswasQuery->where('kelas_id', $this->selectedKelas);
        }
        
        if ($this->search) {
            $siswasQuery->where('nama', 'like', '%' . $this->search . '%');
        }
        
        $siswas = $siswasQuery->get();
        
        // Load existing absensi for today
        $existingAbsensi = Absensi::where('tanggal', $today)
            ->whereIn('siswa_id', $siswas->pluck('id'))
            ->get()
            ->keyBy('siswa_id');
        
        return view('livewire.guru.dashboard', [
<<<<<<< HEAD
            'totalSiswa' => Siswa::count(),
            'totalHadir' => Absensi::where('tanggal', $today)->where('status', 'Hadir')->count(),
            'kelasList' => Kelas::all(),
            'siswas' => $siswas,
            'existingAbsensi' => $existingAbsensi,
=======
            'kelass' => Kelas::all(),
            'tahunAjars' => TahunAjar::all(),
            'siswas' => ($this->kelas_id && $this->tahun_ajar_id) 
                ? Siswa::where('kelas_id', $this->kelas_id)
                    ->where('tahun_ajar_id', $this->tahun_ajar_id)
                    ->orderBy('nama')
                    ->get() 
                : [],
>>>>>>> 2d8fa0d8b4e5a5e7881a283ce47d0ea71c73a0d5
        ]);
    }
}

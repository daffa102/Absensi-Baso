<?php

namespace App\Livewire\Guru;

use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\TahunAjar;
use App\Models\Absensi;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Dashboard extends Component
{
    #[Layout('components.layouts.guru')]
    
    public $selectedKelas = '';
    public $search = '';
    public $absensiData = [];
    
    public function mount()
    {
        // Initialize absensi data array
        $this->absensiData = [];
        
        // Load existing absensi for today if kelas is already selected
        if ($this->selectedKelas) {
            $today = date('Y-m-d');
            $existingAbsensi = Absensi::where('tanggal', $today)
                ->where('kelas_id', $this->selectedKelas)
                ->get();
            
            // Pre-populate absensiData with existing records
            foreach ($existingAbsensi as $absensi) {
                $this->absensiData[$absensi->siswa_id] = [
                    'status' => $absensi->status,
                ];
            }
        }
    }
    
    public function updatedSelectedKelas()
    {
        // Reset absensi data when kelas changes
        $this->absensiData = [];
        
        // Load existing absensi for today if kelas is selected
        if ($this->selectedKelas) {
            $today = date('Y-m-d');
            $existingAbsensi = Absensi::where('tanggal', $today)
                ->where('kelas_id', $this->selectedKelas)
                ->get();
            
            // Pre-populate absensiData with existing records
            foreach ($existingAbsensi as $absensi) {
                $this->absensiData[$absensi->siswa_id] = [
                    'status' => $absensi->status,
                ];
            }
        }
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
                        'guru_piket_id' => Auth::id(),
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
        
        $siswas = $siswasQuery->orderBy('nama')->get();
        
        // Load existing absensi for today
        $existingAbsensi = Absensi::where('tanggal', $today)
            ->whereIn('siswa_id', $siswas->pluck('id'))
            ->get()
            ->keyBy('siswa_id');
        
        return view('livewire.guru.dashboard', [
            'totalSiswa' => Siswa::count(),
            'totalHadir' => Absensi::where('tanggal', $today)->where('status', 'Hadir')->count(),
            'totalSakit' => Absensi::where('tanggal', $today)->where('status', 'Sakit')->count(),
            'totalIzin' => Absensi::where('tanggal', $today)->where('status', 'Izin')->count(),
            'totalAlpa' => Absensi::where('tanggal', $today)->where('status', 'Alpa')->count(),
            'kelasList' => Kelas::all(),
            'siswas' => $siswas,
            'existingAbsensi' => $existingAbsensi,
        ]);
    }
}

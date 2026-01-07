<?php

namespace App\Livewire\Admin;

use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\Absensi;
use App\Exports\AttendanceExport;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Livewire\Attributes\Layout;

class Dashboard extends Component
{
    #[Layout('components.layouts.admin')]
    public $selectedDate;
    public $selectedKelas = '';
    
    public function mount()
    {
        $this->selectedDate = date('Y-m-d');
    }

    public function exportExcel()
    {
        return Excel::download(
            new AttendanceExport($this->selectedDate, $this->selectedKelas), 
            'laporan-absensi-' . $this->selectedDate . '.xlsx'
        );
    }

    public function exportPdf()
    {
        $query = Absensi::with(['siswa.kelas', 'kelas'])
            ->where('tanggal', $this->selectedDate);
        
        if ($this->selectedKelas) {
            $query->where('kelas_id', $this->selectedKelas);
        }
        
        $data = [
            'tanggal' => $this->selectedDate,
            'kelas' => $this->selectedKelas ? Kelas::find($this->selectedKelas) : null,
            'stats' => [
                'hadir' => (clone $query)->where('status', 'Hadir')->count(),
                'sakit' => (clone $query)->where('status', 'Sakit')->count(),
                'izin' => (clone $query)->where('status', 'Izin')->count(),
                'alpa' => (clone $query)->where('status', 'Alpa')->count(),
            ],
            'absents' => (clone $query)->whereIn('status', ['Sakit', 'Izin', 'Alpa'])->get()
        ];

        $pdf = Pdf::loadView('exports.attendance-pdf', $data);
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, 'laporan-absensi-' . $this->selectedDate . '.pdf');
    }

    public function render()
    {
        $today = date('Y-m-d');
        
        // Query for absent list with class filter
        $absentQuery = Absensi::with(['siswa.kelas', 'kelas'])
            ->where('tanggal', $this->selectedDate)
            ->whereIn('status', ['Sakit', 'Izin', 'Alpa']);
        
        if ($this->selectedKelas) {
            $absentQuery->where('kelas_id', $this->selectedKelas);
        }
        
        return view('livewire.admin.dashboard', [
            'totalSiswa' => Siswa::count(),
            'hadirToday' => Absensi::where('tanggal', $today)->where('status', 'Hadir')->count(),
            'sakitToday' => Absensi::where('tanggal', $today)->where('status', 'Sakit')->count(),
            'izinToday' => Absensi::where('tanggal', $today)->where('status', 'Izin')->count(),
            'alpaToday' => Absensi::where('tanggal', $today)->where('status', 'Alpa')->count(),
            'kelasList' => Kelas::orderBy('nama_kelas')->get(),
            'absentList' => $absentQuery->get(),
        ]);
    }
}

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
    
    public function mount()
    {
        $this->selectedDate = date('Y-m-d');
    }

    public function exportExcel()
    {
        return Excel::download(new AttendanceExport($this->selectedDate), 'laporan-absensi-' . $this->selectedDate . '.xlsx');
    }

    public function exportPdf()
    {
        $data = [
            'tanggal' => $this->selectedDate,
            'stats' => [
                'hadir' => Absensi::where('tanggal', $this->selectedDate)->where('status', 'Hadir')->count(),
                'sakit' => Absensi::where('tanggal', $this->selectedDate)->where('status', 'Sakit')->count(),
                'izin' => Absensi::where('tanggal', $this->selectedDate)->where('status', 'Izin')->count(),
                'alpa' => Absensi::where('tanggal', $this->selectedDate)->where('status', 'Alpa')->count(),
            ],
            'absents' => Absensi::with('siswa.kelas')
                ->where('tanggal', $this->selectedDate)
                ->whereIn('status', ['Sakit', 'Izin', 'Alpa'])
                ->get()
        ];

        $pdf = Pdf::loadView('exports.attendance-pdf', $data);
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, 'laporan-absensi-' . $this->selectedDate . '.pdf');
    }

    public function render()
    {
        $today = date('Y-m-d');
        
        return view('livewire.admin.dashboard', [
            'totalSiswa' => Siswa::count(),
            'hadirToday' => Absensi::where('tanggal', $today)->where('status', 'Hadir')->count(),
            'sakitToday' => Absensi::where('tanggal', $today)->where('status', 'Sakit')->count(),
            'izinToday' => Absensi::where('tanggal', $today)->where('status', 'Izin')->count(),
            'alpaToday' => Absensi::where('tanggal', $today)->where('status', 'Alpa')->count(),
            
            'absentList' => Absensi::with('siswa.kelas')
                ->where('tanggal', $this->selectedDate)
                ->whereIn('status', ['Sakit', 'Izin', 'Alpa'])
                ->get(),
        ]);
    }
}

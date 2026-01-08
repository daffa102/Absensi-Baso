<?php

namespace App\Livewire\Admin;

use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\Absensi;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Livewire\Attributes\Layout;

use Livewire\WithFileUploads;

class Dashboard extends Component
{
    #[Layout('components.layouts.admin')]
    public $selectedDate;
    public $selectedKelas = '';
    
    // Monthly Export Props
    public $selectedMonth;
    public $selectedYear;
    
    public function mount()
    {
        $this->selectedDate = date('Y-m-d');
        $this->selectedMonth = date('m');
        $this->selectedYear = date('Y');
    }

    public function exportMonthlyExcel()
    {
        if (!$this->selectedKelas) {
            session()->flash('error', 'Silakan pilih kelas terlebih dahulu.');
            return;
        }

        $namaKelas = Kelas::find($this->selectedKelas)->nama_kelas;
        $monthName = \Carbon\Carbon::create(null, $this->selectedMonth, 1)->translatedFormat('F');
        $fileName = "Rekap_Absensi_{$namaKelas}_{$monthName}_{$this->selectedYear}.xlsx";

        return Excel::download(
            new \App\Exports\MonthlyRecapExport($this->selectedMonth, $this->selectedYear, $this->selectedKelas), 
            $fileName
        );
    }

    public function exportMonthlyPdf()
    {
        if (!$this->selectedKelas) {
            session()->flash('error', 'Silakan pilih kelas terlebih dahulu.');
            return;
        }

        $namaKelas = Kelas::find($this->selectedKelas)->nama_kelas;
        $monthName = \Carbon\Carbon::create(null, $this->selectedMonth, 1)->translatedFormat('F');
        $fileName = "Rekap_Absensi_{$namaKelas}_{$monthName}_{$this->selectedYear}.pdf";

        // Using streamDownload for PDF is better for browser preview/download
        $export = new \App\Exports\MonthlyRecapExport($this->selectedMonth, $this->selectedYear, $this->selectedKelas);
        $view = $export->view();
        
        // Render view to PDF
        $pdf = Pdf::loadHTML($view->render())
            ->setPaper('a4', 'landscape'); // Landscape for wide grid

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, $fileName);
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

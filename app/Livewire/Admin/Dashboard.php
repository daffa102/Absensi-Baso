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
    public $selectedStatus = '';
    
    // Monthly Export Props
    public $selectedMonth;
    public $selectedYear;
    
    protected $rules = [
        'selectedKelas' => 'required',
        'selectedMonth' => 'required|numeric|between:1,12',
        'selectedYear' => 'required|numeric',
    ];

    protected $messages = [
        'selectedKelas.required' => 'Silakan pilih kelas terlebih dahulu.',
        'selectedMonth.required' => 'Bulan harus dipilih.',
        'selectedYear.required' => 'Tahun harus dipilih.',
    ];

    public function mount()
    {
        $this->selectedDate = date('Y-m-d');
        $this->selectedMonth = date('m');
        $this->selectedYear = date('Y');
    }

    public function exportMonthlyExcel()
    {
        $this->validate();

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
        $this->validate();

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
        // 1. Fetch Class List (Minimal columns)
        $kelasList = Kelas::select('id', 'nama_kelas')->orderBy('nama_kelas')->get();

        // 2. Query for absent list with class and status filter
        $absentQuery = Absensi::with(['siswa:id,nama,nis,kelas_id', 'siswa.kelas:id,nama_kelas', 'kelas:id,nama_kelas'])
            ->where('tanggal', $this->selectedDate);
            
        if ($this->selectedStatus) {
            $absentQuery->where('status', strtolower($this->selectedStatus));
        } else {
            $absentQuery->whereIn('status', ['sakit', 'izin', 'alpa']);
        }
        
        if ($this->selectedKelas) {
            $absentQuery->where('kelas_id', $this->selectedKelas);
        }

        // 3. Dynamic stats
        $statsQuery = Absensi::where('tanggal', $this->selectedDate);
        if ($this->selectedKelas) {
            $statsQuery->where('kelas_id', $this->selectedKelas);
        }

        $stats = $statsQuery->selectRaw("
                COUNT(CASE WHEN status = 'hadir' THEN 1 END) as hadir,
                COUNT(CASE WHEN status = 'sakit' THEN 1 END) as sakit,
                COUNT(CASE WHEN status = 'izin' THEN 1 END) as izin,
                COUNT(CASE WHEN status = 'alpa' THEN 1 END) as alpa
            ")
            ->first();
        
        // 4. Total Siswa count
        $totalSiswaQuery = Siswa::query();
        if ($this->selectedKelas) {
            $totalSiswaQuery->where('kelas_id', $this->selectedKelas);
        }
        $totalSiswa = $totalSiswaQuery->count();

        return view('livewire.admin.dashboard', [
            'totalSiswa' => $totalSiswa,
            'hadirToday' => $stats->hadir ?? 0,
            'sakitToday' => $stats->sakit ?? 0,
            'izinToday' => $stats->izin ?? 0,
            'alpaToday' => $stats->alpa ?? 0,
            'kelasList' => $kelasList,
            'absentList' => $absentQuery->latest()->get(),
        ]);
    }
}

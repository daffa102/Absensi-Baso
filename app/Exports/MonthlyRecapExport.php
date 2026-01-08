<?php

namespace App\Exports;

use App\Models\Siswa;
use App\Models\Kelas;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class MonthlyRecapExport implements FromView, ShouldAutoSize, WithStyles
{
    protected $month;
    protected $year;
    protected $kelasId;

    public function __construct($month, $year, $kelasId)
    {
        $this->month = $month;
        $this->year = $year;
        $this->kelasId = $kelasId;
    }

    public function view(): View
    {
        $kelas = Kelas::findOrFail($this->kelasId);
        
        $siswas = Siswa::where('kelas_id', $this->kelasId)
            ->with(['absensis' => function ($query) {
                // Load all attendance for the given month/year
                $query->whereMonth('tanggal', $this->month)
                      ->whereYear('tanggal', $this->year);
            }])
            ->orderBy('nama')
            ->get();

        return view('exports.monthly-recap', [
            'siswas' => $siswas,
            'kelas' => $kelas,
            'month' => $this->month,
            'year' => $this->year,
        ]);
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the Title
            1 => ['font' => ['bold' => true, 'size' => 14]],
            2 => ['font' => ['bold' => true, 'size' => 12]],
        ];
    }
}

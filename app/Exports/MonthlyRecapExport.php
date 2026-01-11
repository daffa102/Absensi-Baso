<?php

namespace App\Exports;

use App\Models\Siswa;
use App\Models\Kelas;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithDrawings;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class MonthlyRecapExport implements FromView, ShouldAutoSize, WithStyles, WithDrawings
{
    protected $month;
    protected $year;
    protected $kelasId;
    protected $siswaCount;

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
                $query->whereMonth('tanggal', $this->month)
                      ->whereYear('tanggal', $this->year);
            }])
            ->orderBy('nama')
            ->get();

        $this->siswaCount = $siswas->count();

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
            1 => ['font' => ['bold' => true, 'size' => 14]],
            2 => ['font' => ['bold' => true, 'size' => 12]],
        ];
    }

    public function drawings()
    {
        $drawing = new Drawing();
        $drawing->setName('Signature');
        $drawing->setDescription('Teacher Signature');
        $drawing->setPath(public_path('assets/signatures/teacher_signature.png'));
        $drawing->setHeight(60);
        
        // Placement: after the student table
        // Table starts at row 3 (header), ends at 4 + siswaCount
        // Signature block starts 2 rows after table
        $row = $this->siswaCount + 8; 
        $drawing->setCoordinates('AE' . $row); // AE is roughly where "Wali Kelas" would be

        return $drawing;
    }
}

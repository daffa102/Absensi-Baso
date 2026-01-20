<?php

namespace App\Exports;

use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\Signature;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class MonthlyRecapExport implements FromView, ShouldAutoSize, WithStyles, WithEvents
{
    protected $month;
    protected $year;
    protected $kelasId;
    protected $siswaCount;
    protected $signatures;

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

        // Load active signatures
        $this->signatures = [
            'kepala_sekolah' => Signature::active()->byRole('kepala_sekolah')->first(),
        ];

        return view('exports.monthly-recap', [
            'siswas' => $siswas,
            'kelas' => $kelas,
            'month' => $this->month,
            'year' => $this->year,
            'signatures' => $this->signatures,
            'is_excel' => true,
        ]);
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true, 'size' => 14]],
            2 => ['font' => ['bold' => true, 'size' => 12]],
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                // Calculate Signature Row
                // Body ends at (4 + Count)
                // Spacer Row +1
                // Date Row +1
                // Title Row +1
                // Signature Row (Target) is next -> 4 + Count + 1 + 1 + 1 + 1 = Count + 8
                // Calculate Signature Row
                // Header (School Info) = 4 rows
                // Spacer <br> = 1 row (maybe) - NO, <br> is removed/ignored or part of cell?
                // Wait, there is a <br> between tables in line 35 of the blade?
                // Main Table Header = 2 rows
                // Data = siswaCount
                // Spacer Table = 1 row
                // Footer Row 1 (Padang) = 1 row
                // Footer Row 2 (Kepala) = 1 row
                // Signature Row (Target) = Next
                
                // Total Offset = 4 (Info) + 1 (Gap) + 2 (Header) + siswaCount + 1 (Spacer) + 1 (Padang) + 1 (Kepala)
                // Offset = 10 + siswaCount.
                // Signature Row index (1-based) = 10 + siswaCount + 1 (current row) = 11 + siswaCount?
                
                // Let's rely on the previous error.
                // Target was "Count + 8". Result was "Row 47" (when total rows ~43).
                // If it was Row 47 and Padang was at Row 47/48.
                // It means Count+8 was CLOSE but maybe 1 row too high or low.
                // User wants it "Exactly above names".
                // Name is at SignatureRow + 1.
                // So we need to target the row exactly before name.
                
                // Let's increase offset by 2 to push it down from "Padang/Kepala" area into the gap.
                $signatureRow = $this->siswaCount + 10; 

                // Set Row Height for Signature Row to ensure space
                $event->sheet->getDelegate()->getRowDimension($signatureRow)->setRowHeight(80);

                $signature = $this->signatures['kepala_sekolah'];
                
                if ($signature && file_exists($signature->full_path)) {
                    $path = $signature->full_path;
                    
                    // Main Drawing
                    $drawing = new Drawing();
                    $drawing->setName('Kepala Sekolah');
                    $drawing->setDescription('Signature');
                    $drawing->setPath($path);
                    $drawing->setHeight(75); 
                    $drawing->setCoordinates('AG' . $signatureRow);
                    $drawing->setOffsetY(2); 
                    $drawing->setOffsetX(40); // Center horizontally within the 5 merged columns
                    $drawing->setWorksheet($event->sheet->getDelegate());
                }
            },
        ];
    }
}

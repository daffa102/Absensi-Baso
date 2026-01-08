<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class SiswaTemplateExport implements FromArray, WithHeadings, WithTitle, ShouldAutoSize
{
    public function array(): array
    {
        return [
            // Sample Data
            ['2024001', 'Ahmad Dani', 'XII RPL 1', '2024/2025'],
            ['2024002', 'Budi Santoso', 'XII RPL 1', '2024/2025'],
        ];
    }

    public function headings(): array
    {
        return [
            'nis',
            'nama',
            'kelas',
            'tahun_ajar',
        ];
    }

    public function title(): string
    {
        return 'Template Import Siswa';
    }
}

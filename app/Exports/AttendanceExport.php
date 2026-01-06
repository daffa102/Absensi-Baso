<?php

namespace App\Exports;

use App\Models\Absensi;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class AttendanceExport implements FromCollection, WithHeadings, WithMapping
{
    protected $date;

    public function __construct($date)
    {
        $this->date = $date;
    }

    public function collection()
    {
        return Absensi::with(['siswa', 'siswa.kelas'])
            ->where('tanggal', $this->date)
            ->get();
    }

    public function headings(): array
    {
        return [
            'NIS',
            'Nama Siswa',
            'Kelas',
            'Status Kehadiran',
            'Tanggal',
        ];
    }

    public function map($absensi): array
    {
        return [
            $absensi->siswa->nis,
            $absensi->siswa->nama,
            $absensi->siswa->kelas->nama_kelas,
            $absensi->status,
            $absensi->tanggal,
        ];
    }
}

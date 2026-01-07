<?php

namespace App\Exports;

use App\Models\Absensi;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class AttendanceExport implements FromCollection, WithHeadings, WithMapping
{
    protected $date;
    protected $kelasId;

    public function __construct($date, $kelasId = null)
    {
        $this->date = $date;
        $this->kelasId = $kelasId;
    }

    public function collection()
    {
        $query = Absensi::with(['siswa', 'siswa.kelas', 'kelas'])
            ->where('tanggal', $this->date);
        
        if ($this->kelasId) {
            $query->where('kelas_id', $this->kelasId);
        }
        
        return $query->get();
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

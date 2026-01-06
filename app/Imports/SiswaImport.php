<?php

namespace App\Imports;

use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\TahunAjar;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;

class SiswaImport implements ToModel, WithHeadingRow, SkipsEmptyRows
{
    public function model(array $row)
    {
        $kelas = Kelas::where('nama_kelas', $row['kelas'])->first();
        $tahunAjar = TahunAjar::where('nama', $row['tahun_ajar'])->first();

        if (!$kelas || !$tahunAjar) {
            return null; // Skip if class or year not found
        }

        return new Siswa([
            'nis' => $row['nis'],
            'nama' => $row['nama'],
            'kelas_id' => $kelas->id,
            'tahun_ajar_id' => $tahunAjar->id,
        ]);
    }
}

<?php

namespace App\Livewire\Admin\DataSiswa;

use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\TahunAjar;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\DB;

class Index extends Component
{
    use WithPagination, WithFileUploads;
    #[Layout('components.layouts.admin')]

    public $search = '';
    public $selectedKelas = '';
    public $sortField = 'nama';
    public $sortDirection = 'asc';
    public $showImportModal = false;
    public $importFile;

    public function updatedSelectedKelas()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function delete($id)
    {
        Siswa::findOrFail($id)->delete();
        session()->flash('success', 'Data siswa berhasil dihapus.');
    }

    public function openImportModal()
    {
        $this->showImportModal = true;
        $this->importFile = null;
    }

    public function closeImportModal()
    {
        $this->showImportModal = false;
        $this->importFile = null;
    }

    public function downloadTemplate()
    {
        return \Maatwebsite\Excel\Facades\Excel::download(new \App\Exports\SiswaTemplateExport, 'template_import_siswa.xlsx');
    }

    public function importExcel()
    {
        $this->validate([
            'importFile' => 'required|mimes:xlsx,xls|max:2048',
        ]);

        try {
            $path = $this->importFile->getRealPath();
            $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReaderForFile($path);
            $spreadsheet = $reader->load($path);
            $worksheet = $spreadsheet->getActiveSheet();
            $rows = $worksheet->toArray();

            // Skip header row
            array_shift($rows);

            $imported = 0;
            $errors = [];

            DB::beginTransaction();

            foreach ($rows as $index => $row) {
                // Skip empty rows
                if (empty($row[0]) && empty($row[1])) {
                    continue;
                }

                $nis = $row[0] ?? null;
                $nama = $row[1] ?? null;
                $kelasNama = $row[2] ?? null;
                $tahunAjarNama = $row[3] ?? null;

                // Validate required fields
                if (!$nis || !$nama) {
                    $errors[] = "Baris " . ($index + 2) . ": NIS dan Nama wajib diisi";
                    continue;
                }

                // Find or create Kelas
                $kelas = null;
                if ($kelasNama) {
                    $kelas = Kelas::firstOrCreate(['nama_kelas' => $kelasNama]);
                }

                // Find or create TahunAjar
                $tahunAjar = null;
                if ($tahunAjarNama) {
                    $tahunAjar = TahunAjar::firstOrCreate(['nama' => $tahunAjarNama]);
                }

                // Create or update Siswa
                Siswa::updateOrCreate(
                    ['nis' => $nis],
                    [
                        'nama' => $nama,
                        'kelas_id' => $kelas?->id,
                        'tahun_ajar_id' => $tahunAjar?->id,
                    ]
                );

                $imported++;
            }

            DB::commit();

            $this->closeImportModal();
            
            if (count($errors) > 0) {
                session()->flash('warning', "Berhasil import {$imported} data. " . count($errors) . " data gagal: " . implode(', ', array_slice($errors, 0, 3)));
            } else {
                session()->flash('success', "Berhasil import {$imported} data siswa.");
            }

        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Gagal import data: ' . $e->getMessage());
        }
    }

    public function render()
    {
        $query = Siswa::with(['kelas', 'tahun_ajar'])
            ->leftJoin('kelas', 'siswas.kelas_id', '=', 'kelas.id')
            ->select('siswas.*')
            ->where(function($q) {
                $q->where('siswas.nama', 'like', '%' . $this->search . '%')
                  ->orWhere('siswas.nis', 'like', '%' . $this->search . '%');
            });

        if ($this->selectedKelas) {
            $query->where('siswas.kelas_id', $this->selectedKelas);
        }

        if ($this->sortField === 'nama_kelas') {
            $query->orderBy('kelas.nama_kelas', $this->sortDirection);
        } else {
            $query->orderBy('siswas.' . $this->sortField, $this->sortDirection);
        }

        return view('livewire.admin.data-siswa.index', [
            'siswas' => $query->paginate(10),
            'kelass' => Kelas::orderBy('nama_kelas')->get()
        ]);
    }
}

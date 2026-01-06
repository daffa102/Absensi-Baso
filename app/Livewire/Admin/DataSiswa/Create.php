<?php

namespace App\Livewire\Admin\DataSiswa;

use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\TahunAjar;
use App\Imports\SiswaImport;
use Livewire\Component;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;

class Create extends Component
{
    use WithFileUploads;

    public $nis, $nama, $kelas_id, $tahun_ajar_id;
    public $file_excel;

    protected $rules = [
        'nis' => 'required|unique:siswas,nis',
        'nama' => 'required',
        'kelas_id' => 'required|exists:kelas,id',
        'tahun_ajar_id' => 'required|exists:tahun_ajars,id',
    ];

    public function save()
    {
        $this->validate();

        Siswa::create([
            'nis' => $this->nis,
            'nama' => $this->nama,
            'kelas_id' => $this->kelas_id,
            'tahun_ajar_id' => $this->tahun_ajar_id,
        ]);

        session()->flash('success', 'Data siswa berhasil ditambahkan.');
        return redirect()->route('admin.data-siswa.index');
    }

    public function import()
    {
        $this->validate([
            'file_excel' => 'required|mimes:xlsx,xls,csv',
        ]);

        Excel::import(new SiswaImport, $this->file_excel->getRealPath());

        session()->flash('success', 'Data siswa berhasil diimport.');
        return redirect()->route('admin.data-siswa.index');
    }

    public function render()
    {
        return view('livewire.admin.data-siswa.create', [
            'kelass' => Kelas::all(),
            'tahunAjars' => TahunAjar::all(),
        ]);
    }
}

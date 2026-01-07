<?php

namespace App\Livewire\Admin\DataSiswa;

use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\TahunAjar;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Create extends Component
{
    #[Layout('components.layouts.admin')]
    
    public $nis, $nama, $kelas_id, $tahun_ajar_id;

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

    public function render()
    {
        return view('livewire.admin.data-siswa.create', [
            'kelass' => Kelas::all(),
            'tahunAjars' => TahunAjar::all(),
        ]);
    }
}

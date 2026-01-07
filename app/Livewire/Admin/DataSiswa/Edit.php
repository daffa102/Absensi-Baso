<?php

namespace App\Livewire\Admin\DataSiswa;

use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\TahunAjar;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Edit extends Component
{
    #[Layout('components.layouts.admin')]
    
    public $siswaId, $nis, $nama, $kelas_id, $tahun_ajar_id;

    public function mount($id)
    {
        $siswa = Siswa::findOrFail($id);
        $this->siswaId = $siswa->id;
        $this->nis = $siswa->nis;
        $this->nama = $siswa->nama;
        $this->kelas_id = $siswa->kelas_id;
        $this->tahun_ajar_id = $siswa->tahun_ajar_id;
    }

    protected function rules()
    {
        return [
            'nis' => 'required|unique:siswas,nis,' . $this->siswaId,
            'nama' => 'required',
            'kelas_id' => 'required|exists:kelas,id',
            'tahun_ajar_id' => 'required|exists:tahun_ajars,id',
        ];
    }

    public function update()
    {
        $this->validate();

        $siswa = Siswa::findOrFail($this->siswaId);
        $siswa->update([
            'nis' => $this->nis,
            'nama' => $this->nama,
            'kelas_id' => $this->kelas_id,
            'tahun_ajar_id' => $this->tahun_ajar_id,
        ]);

        session()->flash('success', 'Data siswa berhasil diperbarui.');
        return redirect()->route('admin.data-siswa.index');
    }

    public function render()
    {
        return view('livewire.admin.data-siswa.edit', [
            'kelass' => Kelas::all(),
            'tahunAjars' => TahunAjar::all(),
        ]);
    }
}

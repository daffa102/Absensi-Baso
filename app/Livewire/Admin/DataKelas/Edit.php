<?php

namespace App\Livewire\Admin\DataKelas;

use App\Models\Kelas;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Edit extends Component
{
    #[Layout('components.layouts.admin')]
    
    public $kelasId;
    public $nama_kelas;

    public function mount($id)
    {
        $kelas = Kelas::findOrFail($id);
        $this->kelasId = $kelas->id;
        $this->nama_kelas = $kelas->nama_kelas;
    }

    protected function rules()
    {
        return [
            'nama_kelas' => 'required|unique:kelas,nama_kelas,' . $this->kelasId,
        ];
    }

    public function update()
    {
        $this->validate();

        $kelas = Kelas::findOrFail($this->kelasId);
        $kelas->update([
            'nama_kelas' => $this->nama_kelas,
        ]);

        session()->flash('success', 'Data kelas berhasil diperbarui.');
        return redirect()->route('admin.data-kelas.index');
    }

    public function render()
    {
        return view('livewire.admin.data-kelas.edit');
    }
}

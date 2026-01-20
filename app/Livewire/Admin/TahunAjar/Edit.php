<?php

namespace App\Livewire\Admin\TahunAjar;

use App\Models\TahunAjar;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Edit extends Component
{
    #[Layout('components.layouts.admin')]
    
    public $tahunId;
    public $nama;
    public $aktif;

    public function mount($id)
    {
        $tahun = TahunAjar::findOrFail($id);
        $this->tahunId = $tahun->id;
        $this->nama = $tahun->nama;
        $this->aktif = $tahun->aktif;
    }

    protected function rules()
    {
        return [
            'nama' => 'required|unique:tahun_ajars,nama,' . $this->tahunId,
            'aktif' => 'boolean',
        ];
    }

    public function update()
    {
        $this->validate();

        $tahun = TahunAjar::findOrFail($this->tahunId);

        if ($this->aktif && !$tahun->aktif) {
            TahunAjar::where('aktif', true)->update(['aktif' => false]);
        }

        $tahun->update([
            'nama' => $this->nama,
            'aktif' => $this->aktif,
        ]);

        $this->dispatch('form-saved');

        session()->flash('success', 'Tahun ajar berhasil diperbarui.');
        return redirect()->route('admin.tahun-ajar.index');
    }

    public function render()
    {
        return view('livewire.admin.tahun-ajar.edit');
    }
}

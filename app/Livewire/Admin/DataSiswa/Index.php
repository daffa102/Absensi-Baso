<?php

namespace App\Livewire\Admin\DataSiswa;

use App\Models\Siswa;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';

    public function delete($id)
    {
        Siswa::findOrFail($id)->delete();
        session()->flash('success', 'Data siswa berhasil dihapus.');
    }

    public function render()
    {
        return view('livewire.admin.data-siswa.index', [
            'siswas' => Siswa::with(['kelas', 'tahun_ajar'])
                ->where('nama', 'like', '%' . $this->search . '%')
                ->orWhere('nis', 'like', '%' . $this->search . '%')
                ->latest()
                ->paginate(10)
        ]);
    }
}

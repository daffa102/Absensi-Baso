<?php

namespace App\Livewire\Admin\DataKelas;

use App\Models\Kelas;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';

    public function delete($id)
    {
        Kelas::findOrFail($id)->delete();
        session()->flash('success', 'Data kelas berhasil dihapus.');
    }

    public function render()
    {
        return view('livewire.admin.data-kelas.index', [
            'kelass' => Kelas::where('nama_kelas', 'like', '%' . $this->search . '%')
                ->latest()
                ->paginate(10)
        ]);
    }
}

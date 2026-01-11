<?php

namespace App\Livewire\Admin\DataKelas;

use App\Models\Kelas;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    #[Layout('components.layouts.admin')]

    public $search = '';
    public $sortField = 'nama_kelas';
    public $sortDirection = 'asc';

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
        Kelas::findOrFail($id)->delete();
        session()->flash('success', 'Data kelas berhasil dihapus.');
    }

    public function render()
    {
        return view('livewire.admin.data-kelas.index', [
            'kelass' => Kelas::withCount('siswas')
                ->where('nama_kelas', 'like', '%' . $this->search . '%')
                ->orderBy($this->sortField, $this->sortDirection)
                ->paginate(10)
        ]);
    }
}

<?php

namespace App\Livewire\Admin\TahunAjar;

use App\Models\TahunAjar;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';

    public function toggleAktif($id)
    {
        $tahun = TahunAjar::findOrFail($id);
        
        // If we are activating this one, deactivate others
        if (!$tahun->aktif) {
            TahunAjar::where('id', '!=', $id)->update(['aktif' => false]);
            $tahun->update(['aktif' => true]);
        } else {
            $tahun->update(['aktif' => false]);
        }

        session()->flash('success', 'Status tahun ajar berhasil diperbarui.');
    }

    public function delete($id)
    {
        TahunAjar::findOrFail($id)->delete();
        session()->flash('success', 'Tahun ajar berhasil dihapus.');
    }

    public function render()
    {
        return view('livewire.admin.tahun-ajar.index', [
            'tahunAjars' => TahunAjar::where('nama', 'like', '%' . $this->search . '%')
                ->latest()
                ->paginate(10)
        ]);
    }
}

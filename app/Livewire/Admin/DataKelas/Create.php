<?php

namespace App\Livewire\Admin\DataKelas;

use App\Models\Kelas;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Create extends Component
{
    #[Layout('components.layouts.admin')]
    
    public $nama_kelas;

    protected $rules = [
        'nama_kelas' => 'required|unique:kelas,nama_kelas',
    ];

    public function save()
    {
        $this->validate();

        Kelas::create([
            'nama_kelas' => $this->nama_kelas,
        ]);

        session()->flash('success', 'Data kelas berhasil ditambahkan.');
        return redirect()->route('admin.data-kelas.index');
    }

    public function render()
    {
        return view('livewire.admin.data-kelas.create');
    }
}

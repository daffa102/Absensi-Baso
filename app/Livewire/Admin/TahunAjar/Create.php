<?php

namespace App\Livewire\Admin\TahunAjar;

use App\Models\TahunAjar;
use Livewire\Component;

class Create extends Component
{
    public $nama;
    public $aktif = false;

    protected $rules = [
        'nama' => 'required|unique:tahun_ajars,nama',
        'aktif' => 'boolean',
    ];

    public function save()
    {
        $this->validate();

        if ($this->aktif) {
            TahunAjar::where('aktif', true)->update(['aktif' => false]);
        }

        TahunAjar::create([
            'nama' => $this->nama,
            'aktif' => $this->aktif,
        ]);

        session()->flash('success', 'Tahun ajar berhasil ditambahkan.');
        return redirect()->route('admin.tahun-ajar.index');
    }

    public function render()
    {
        return view('livewire.admin.tahun-ajar.create');
    }
}

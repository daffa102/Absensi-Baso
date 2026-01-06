<?php

namespace App\Livewire\Guru;

use App\Models\Absensi;
use App\Models\Siswa;
use Livewire\Component;

class Dashboard extends Component
{
    public function render()
    {
        return view('livewire.guru.dashboard', [
            'totalSiswa' => Siswa::count(),
            'totalHadir' => Absensi::where('tanggal', date('Y-m-d'))->where('status', 'Hadir')->count(),
        ]);
    }
}

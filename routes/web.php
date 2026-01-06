<?php 

use App\Livewire\Auth\Login;
use App\Livewire\Admin\Dashboard as AdminDashboard;
use App\Livewire\Guru\Dashboard as GuruDashboard;
use App\Livewire\Admin\DataKelas\Index as KelasIndex;
use App\Livewire\Admin\DataKelas\Create as KelasCreate;
use App\Livewire\Admin\DataKelas\Edit as KelasEdit;
use App\Livewire\Admin\DataSiswa\Index as SiswaIndex;
use App\Livewire\Admin\DataSiswa\Create as SiswaCreate;
use App\Livewire\Admin\DataSiswa\Edit as SiswaEdit;
use App\Livewire\Admin\TahunAjar\Index as TahunAjarIndex;
use App\Livewire\Admin\TahunAjar\Create as TahunAjarCreate;
use App\Livewire\Admin\TahunAjar\Edit as TahunAjarEdit;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', Login::class)->name('login');

Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/');
})->name('logout');

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', AdminDashboard::class)->name('dashboard');

    // Tahun Ajar
    Route::get('/tahun-ajar', TahunAjarIndex::class)->name('tahun-ajar.index');
    Route::get('/tahun-ajar/create', TahunAjarCreate::class)->name('tahun-ajar.create');
    Route::get('/tahun-ajar/{id}/edit', TahunAjarEdit::class)->name('tahun-ajar.edit');

    // Data Kelas
    Route::get('/data-kelas', KelasIndex::class)->name('data-kelas.index');
    Route::get('/data-kelas/create', KelasCreate::class)->name('data-kelas.create');
    Route::get('/data-kelas/{id}/edit', KelasEdit::class)->name('data-kelas.edit');

    // Data Siswa
    Route::get('/data-siswa', SiswaIndex::class)->name('data-siswa.index');
    Route::get('/data-siswa/create', SiswaCreate::class)->name('data-siswa.create');
    Route::get('/data-siswa/{id}/edit', SiswaEdit::class)->name('data-siswa.edit');
});

Route::middleware(['auth', 'role:guru_piket'])->prefix('guru')->name('guru.')->group(function () {
    Route::get('/dashboard', GuruDashboard::class)->name('dashboard');
});

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\User;
use App\Models\LogsAbsensi;

class Absensi extends Model
{
    /** @use HasFactory<\Database\Factories\AbsensiFactory> */
    use HasFactory;

    protected $fillable = [
        'tanggal',
        'siswa_id',
        'kelas_id',
        'guru_piket_id',
        'status',
        'keterangan',
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function guru_piket()
    {
        return $this->belongsTo(User::class, 'guru_piket_id');
    }

    public function logs()
    {
        return $this->hasMany(LogsAbsensi::class);
    }
}

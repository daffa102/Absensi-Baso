<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Absensi;
use App\Models\Siswa;
use App\Models\User;

class LogsAbsensi extends Model
{
    /** @use HasFactory<\Database\Factories\LogsAbsensiFactory> */
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'absensi_id',
        'siswa_id',
        'guru_piket_id',
        'status_lama',
        'status_baru',
        'keterangan_lama',
        'keterangan_baru',
        'waktu_edit',
    ];

    protected $casts = [
        'waktu_edit' => 'datetime',
    ];

    public function absensi()
    {
        return $this->belongsTo(Absensi::class);
    }

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    public function guru_piket()
    {
        return $this->belongsTo(User::class, 'guru_piket_id');
    }
}

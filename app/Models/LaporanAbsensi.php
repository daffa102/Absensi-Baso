<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanAbsensi extends Model
{
    /** @use HasFactory<\Database\Factories\LaporanAbsensiFactory> */
    use HasFactory;

    protected $fillable = [
        'guru_piket_id',
        'tanggal',
        'file_excel',
        'file_pdf',
    ];

    public function guru_piket()
    {
        return $this->belongsTo(User::class, 'guru_piket_id');
    }
}

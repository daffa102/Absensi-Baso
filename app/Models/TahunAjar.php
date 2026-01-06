<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TahunAjar extends Model
{
    /** @use HasFactory<\Database\Factories\TahunAjarFactory> */
    use HasFactory;

    protected $fillable = ['nama', 'aktif'];

    protected $casts = [
        'aktif' => 'boolean',
    ];

    public function siswas()
    {
        return $this->hasMany(Siswa::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Signature extends Model
{
    protected $fillable = [
        'role',
        'name',
        'nip',
        'signature_path',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get the full URL for the signature image
     */
    public function getSignatureUrlAttribute()
    {
        if ($this->signature_path) {
            return Storage::url($this->signature_path);
        }
        return null;
    }

    /**
     * Get the full storage path for the signature image
     */
    public function getFullPathAttribute()
    {
        if ($this->signature_path) {
            return storage_path('app/public/' . $this->signature_path);
        }
        return null;
    }

    /**
     * Scope to get only active signatures
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope to filter by role
     */
    public function scopeByRole($query, $role)
    {
        return $query->where('role', $role);
    }

    /**
     * Get role label in Indonesian
     */
    public function getRoleLabelAttribute()
    {
        return match($this->role) {
            'kepala_sekolah' => 'Kepala Sekolah',
            'wali_kelas' => 'Wali Kelas',
            default => $this->role,
        };
    }

    /**
     * Delete signature file when model is deleted
     */
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($signature) {
            if ($signature->signature_path && Storage::disk('public')->exists($signature->signature_path)) {
                Storage::disk('public')->delete($signature->signature_path);
            }
        });
    }
}

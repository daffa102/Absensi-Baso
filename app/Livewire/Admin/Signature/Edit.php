<?php

namespace App\Livewire\Admin\Signature;

use App\Models\Signature;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Storage;

class Edit extends Component
{
    use WithFileUploads;

    #[Layout('components.layouts.admin')]
    
    public $signatureId;
    public $role = 'kepala_sekolah';
    public $name = '';
    public $nip = '';
    public $signatureFile;
    public $currentSignaturePath;
    public $previewUrl = null;
    public $is_active = true;

    protected $rules = [
        'role' => 'required|in:kepala_sekolah',
        'name' => 'required|string|max:255',
        'nip' => 'nullable|string|max:50',
        'signatureFile' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
        'is_active' => 'boolean',
    ];

    protected $messages = [
        'role.required' => 'Role harus dipilih.',
        'role.in' => 'Role tidak valid.',
        'name.required' => 'Nama harus diisi.',
        'name.max' => 'Nama maksimal 255 karakter.',
        'nip.max' => 'NIP maksimal 50 karakter.',
        'signatureFile.image' => 'File harus berupa gambar.',
        'signatureFile.mimes' => 'Format file harus PNG, JPG, atau JPEG.',
        'signatureFile.max' => 'Ukuran file maksimal 2MB.',
    ];

    public function mount($id)
    {
        $this->signatureId = $id;
        $signature = Signature::findOrFail($id);
        
        $this->role = $signature->role;
        $this->name = $signature->name;
        $this->nip = $signature->nip;
        $this->currentSignaturePath = $signature->signature_path;
        $this->is_active = $signature->is_active;
    }

    public function updatedSignatureFile()
    {
        $this->validate([
            'signatureFile' => 'image|mimes:png,jpg,jpeg|max:2048',
        ]);
        
        $this->previewUrl = $this->signatureFile->temporaryUrl();
    }

    public function update()
    {
        $this->validate();

        $signature = Signature::findOrFail($this->signatureId);
        
        $updateData = [
            'role' => $this->role,
            'name' => $this->name,
            'nip' => $this->nip,
            'is_active' => $this->is_active,
        ];

        // If new file uploaded, replace the old one
        if ($this->signatureFile) {
            // Delete old file
            if ($signature->signature_path && Storage::disk('public')->exists($signature->signature_path)) {
                Storage::disk('public')->delete($signature->signature_path);
            }
            
            // Store new file
            $filename = $this->role . '_' . time() . '.' . $this->signatureFile->extension();
            $path = $this->signatureFile->storeAs('signatures', $filename, 'public');
            $updateData['signature_path'] = $path;
        }

        $signature->update($updateData);

        $this->dispatch('form-saved');

        session()->flash('success', 'Tanda tangan berhasil diperbarui.');
        
        return redirect()->route('admin.signature.index');
    }

    public function render()
    {
        return view('livewire.admin.signature.edit');
    }
}

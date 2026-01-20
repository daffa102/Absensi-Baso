<?php

namespace App\Livewire\Admin\Signature;

use App\Models\Signature;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;

class Create extends Component
{
    use WithFileUploads;

    #[Layout('components.layouts.admin')]
    
    public $role = 'kepala_sekolah';
    public $name = '';
    public $nip = '';
    public $signatureFile;
    public $previewUrl = null;

    protected $rules = [
        'role' => 'required|in:kepala_sekolah',
        'name' => 'required|string|max:255',
        'nip' => 'nullable|string|max:50',
        'signatureFile' => 'required|image|mimes:png,jpg,jpeg|max:2048',
    ];

    protected $messages = [
        'role.required' => 'Role harus dipilih.',
        'role.in' => 'Role tidak valid.',
        'name.required' => 'Nama harus diisi.',
        'name.max' => 'Nama maksimal 255 karakter.',
        'nip.max' => 'NIP maksimal 50 karakter.',
        'signatureFile.required' => 'File tanda tangan harus diupload.',
        'signatureFile.image' => 'File harus berupa gambar.',
        'signatureFile.mimes' => 'Format file harus PNG, JPG, atau JPEG.',
        'signatureFile.max' => 'Ukuran file maksimal 2MB.',
    ];

    public function updatedSignatureFile()
    {
        $this->validate([
            'signatureFile' => 'image|mimes:png,jpg,jpeg|max:2048',
        ]);
        
        $this->previewUrl = $this->signatureFile->temporaryUrl();
    }

    public function save()
    {
        $this->validate();

        // Generate unique filename
        $filename = $this->role . '_' . time() . '.' . $this->signatureFile->extension();
        
        // Store file in public/signatures directory
        $path = $this->signatureFile->storeAs('signatures', $filename, 'public');

        // Create signature record
        Signature::create([
            'role' => $this->role,
            'name' => $this->name,
            'nip' => $this->nip,
            'signature_path' => $path,
            'is_active' => true,
        ]);

        // Dispatch event to clear localStorage
        $this->dispatch('form-saved');

        session()->flash('message', 'Tanda tangan berhasil ditambahkan.');
        
        return redirect()->route('admin.signature.index');
    }

    public function render()
    {
        return view('livewire.admin.signature.create');
    }
}

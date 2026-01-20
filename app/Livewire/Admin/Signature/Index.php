<?php

namespace App\Livewire\Admin\Signature;

use App\Models\Signature;
use Livewire\Component;
use Livewire\Attributes\Layout;

class Index extends Component
{
    #[Layout('components.layouts.admin')]
    
    public $signatures;
    public $confirmingDelete = false;
    public $deleteId = null;

    public function mount()
    {
        $this->loadSignatures();
    }

    public function loadSignatures()
    {
        $this->signatures = Signature::orderBy('role')->orderBy('created_at', 'desc')->get();
    }

    public function toggleActive($id)
    {
        $signature = Signature::find($id);
        if ($signature) {
            $signature->is_active = !$signature->is_active;
            $signature->save();
            
            $this->loadSignatures();
            session()->flash('message', 'Status tanda tangan berhasil diubah.');
        }
    }

    public function confirmDelete($id)
    {
        $this->deleteId = $id;
        $this->confirmingDelete = true;
    }

    public function delete()
    {
        if ($this->deleteId) {
            $signature = Signature::find($this->deleteId);
            if ($signature) {
                $signature->delete();
                session()->flash('message', 'Tanda tangan berhasil dihapus.');
            }
        }
        
        $this->confirmingDelete = false;
        $this->deleteId = null;
        $this->loadSignatures();
    }

    public function cancelDelete()
    {
        $this->confirmingDelete = false;
        $this->deleteId = null;
    }

    public function render()
    {
        return view('livewire.admin.signature.index');
    }
}

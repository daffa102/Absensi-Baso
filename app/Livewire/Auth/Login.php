<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Login extends Component
{
    public $email;
    public $password;

    protected $rules = [
        'email' => 'required|min:3',
        'password' => 'required',
    ];

    protected $messages = [
        'email.required' => 'Email atau NIP harus diisi.',
        'email.min' => 'Email atau NIP minimal 3 karakter.',
        'password.required' => 'Password harus diisi.',
    ];

    public function login()
    {
        $this->validate();

        // Try login with email first
        $credentials = ['email' => $this->email, 'password' => $this->password];
        
        // If email login fails, try with NIP
        if (!Auth::attempt($credentials)) {
            $credentials = ['nip' => $this->email, 'password' => $this->password];
            
            if (!Auth::attempt($credentials)) {
                $message = 'Email/NIP atau password yang Anda masukkan salah.';
                session()->flash('error', $message);
                $this->addError('login', $message);
                $this->dispatch('error-login', message: $message);
                return;
            }
        }

        session()->regenerate();

        // Redirect based on role
        if (Auth::user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        } else if (Auth::user()->role === 'guru_piket') {
            return redirect()->route('guru.dashboard');
        }

        return redirect()->intended('/');
    }

    #[Layout('components.layouts.auth')]
    public function render()
    {
        return view('livewire.auth.login');
    }
}

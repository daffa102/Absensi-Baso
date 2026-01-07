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
        'email' => 'required',
        'password' => 'required',
    ];

    protected $messages = [
        'email.required' => 'Email atau NIP harus diisi.',
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
                session()->flash('error', 'Email/NIP atau password yang Anda masukkan salah.');
                $this->addError('login', 'Email/NIP atau password yang Anda masukkan salah.');
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

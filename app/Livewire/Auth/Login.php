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
        'email' => 'required|email',
        'password' => 'required',
    ];

    public function login()
    {
        $this->validate();

        if (Auth::attempt(['email' => $this->email, 'password' => $this->password])) {
            session()->regenerate();

            if (Auth::user()->role === 'admin') {
                return redirect()->route('admin.dashboard');
            } else if (Auth::user()->role === 'guru_piket') {
                return redirect()->route('guru.dashboard');
            }

            return redirect()->intended('/');
        }

        $this->addError('email', 'Email atau password salah.');
    }

    #[Layout('components.layouts.app')]
    public function render()
    {
        return view('livewire.auth.login');
    }
}

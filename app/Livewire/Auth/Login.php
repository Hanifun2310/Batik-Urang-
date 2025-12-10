<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate; 

#[Layout('components.layouts.app')]
class Login extends Component
{
    #[Validate('required|email')]
    public string $email = '';

    #[Validate('required')]
    public string $password = '';

    public bool $remember = false;

    /**
     * Method untuk memproses login
     */
    public function login()
    {

        $this->validate();

        if (Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            
            // Regenerasi ID sesi untuk keamanan 
            session()->regenerate();

            // navigate: true membuat transisi lebih cepat
            return $this->redirect('/', navigate: true);
        }



        $this->addError('email', 'Email atau password yang Anda masukkan salah.');
        
        // untuk mengosongkan password agar pengguna mengetik ulang
        $this->reset('password');
    }

}
<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout; 

#[Layout('components.layouts.app')] 
class Login extends Component
{
    // Properti untuk input email dan password
    public string $email = '';
    public string $password = '';
    // Properti untuk checkbox "Ingat Saya" (opsional)
    public bool $remember = false;

    /**
     * Aturan validasi
     */
    protected function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ];
    }

    /**
     * Method untuk memproses login
     */
    public function login()
    {
        // Validasi input
        $credentials = $this->validate();

        // Coba lakukan login menggunakan Auth::attempt
        // Auth::attempt otomatis mengecek email dan HASH password
        // Argumen kedua (true/false) adalah untuk 'remember me'
        if (Auth::attempt($credentials, $this->remember)) {
            // Jika berhasil, regenerate session & redirect ke homepage
            request()->session()->regenerate();
            return $this->redirect('/', navigate: true);
        }

        // Jika login gagal (email/password salah)
        // Tambahkan error ke field 'email' agar ditampilkan di view
        $this->addError('email', 'Email atau password yang Anda masukkan salah.');
        // Hapus password agar user harus mengetik ulang
        $this->reset('password');
    }

    /**
     * Render view (Livewire otomatis mencari livewire.auth.login)
     */
     // Method render() tidak perlu ditulis jika pakai Layout attribute
     // public function render()
     // {
     //     return view('livewire.auth.login');
     // }
}
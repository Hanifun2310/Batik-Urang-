<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;

#[Layout('components.layouts.app')]
class Register extends Component
{
    // Properti Formulir
    #[Validate]
    public $name = '';

    #[Validate]
    public $email = '';

    #[Validate]
    public $password = '';

    public $password_confirmation = '';

    /**
     * Aturan validasi
     */
    protected function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'confirmed', Password::defaults()],
        ];
    }

    /**
     * Proses Register
     */
    public function register()
    {
        $this->validate();

        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
        ]);

        // Login otomatis
        Auth::login($user);

        // Redirect ke halaman Profile
        return $this->redirect(route('profile'), navigate: true);
    }
}
<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Password;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.app')]
class ForgotPassword extends Component
{
    public string $email = '';
    public $status = null;

    protected function rules(): array
    {
        return [
            'email' => ['required', 'email'],
        ];
    }

    public function sendResetLink()
    {
        $this->validate();

        // Mengirim link reset password menggunakan broker Laravel
        $response = Password::sendResetLink(['email' => $this->email]);

        if ($response == Password::RESET_LINK_SENT) {
            $this->status = __($response);
            $this->email = ''; // Reset input setelah berhasil
        } else {
            $this->addError('email', __($response));
        }
    }

    // Render otomatis ke livewire.auth.forgot-password
}
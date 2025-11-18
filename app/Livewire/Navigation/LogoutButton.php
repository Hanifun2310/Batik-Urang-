<?php

namespace App\Livewire\Navigation; // <-- Perhatikan namespace

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LogoutButton extends Component
{
    /**
     * Method untuk melakukan logout.
     */
    public function logout()
    {
        Auth::logout();
        Session::invalidate();
        Session::regenerateToken();

        // Redirect ke homepage
        return $this->redirect('/', navigate: true);
    }

    /**
     * Render view komponen (tombol logout).
     */
    public function render()
    {
        // Livewire otomatis mencari view: livewire.navigation.logout-button
        return view('livewire.navigation.logout-button');
    }
}
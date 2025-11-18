<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use App\Models\User; 
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\On;

#[Layout('components.layouts.admin')]
class UserManagement extends Component
{
    use WithPagination;

    // Properti untuk tabel
    public $search = '';
    public $perPage = 10;
    
    // Properti untuk Modal Reset Password
    public $isResetModalOpen = false;
    public $selectedUser = null;

    // Properti yang divalidasi untuk password baru
    #[Validate('required|min:8')]
    public $newPassword = '';


    // FUNGSI UTAMA: Mengambil data pengguna
    public function getUsersProperty()
    {
        return User::query()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%'.$this->search.'%')
                      ->orWhere('email', 'like', '%'.$this->search.'%');
            })
            ->latest()
            ->paginate($this->perPage);
    }
    
    // FUNGSI: Membuka modal reset
    public function showResetModal($userId)
    {
        $this->selectedUser = User::findOrFail($userId);
        $this->resetErrorBag();
        $this->newPassword = ''; // Kosongkan input password
        $this->isResetModalOpen = true;
    }

    // FUNGSI: Menutup modal reset
    public function closeResetModal()
    {
        $this->isResetModalOpen = false;
        $this->selectedUser = null;
        $this->newPassword = '';
    }

    // FUNGSI: Reset Password (HANYA admin yang bisa)
    public function resetPassword()
    {
        if (!$this->selectedUser) {
            return;
        }

        // Validasi input password baru
        $this->validate();

        // Update password pengguna (Laravel akan otomatis me-HASH password)
        $this->selectedUser->update([
            'password' => Hash::make($this->newPassword),
        ]);
        
        // Kirim notifikasi Toast
        $this->dispatch('success-alert', ['message' => 'Password pengguna ' . $this->selectedUser->email . ' berhasil direset.']);
        
        // Tutup modal
        $this->closeResetModal();
    }


    public function render()
    {
        return view('livewire.admin.user-management', [
            'users' => $this->users,
        ]);
    }
}
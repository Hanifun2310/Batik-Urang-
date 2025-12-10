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
    

    public function showResetModal($userId)
    {
        $this->selectedUser = User::findOrFail($userId);
        $this->resetErrorBag();
        $this->newPassword = ''; 
        $this->isResetModalOpen = true;
    }


    public function closeResetModal()
    {
        $this->isResetModalOpen = false;
        $this->selectedUser = null;
        $this->newPassword = '';
    }


    public function resetPassword()
    {
        if (!$this->selectedUser) {
            return;
        }


        $this->validate();


        $this->selectedUser->update([
            'password' => Hash::make($this->newPassword),
        ]);
        

        $this->dispatch('success-alert', ['message' => 'Password pengguna ' . $this->selectedUser->email . ' berhasil direset.']);

        $this->closeResetModal();
    }


    public function render()
    {
        return view('livewire.admin.user-management', [
            'users' => $this->users,
        ]);
    }
}
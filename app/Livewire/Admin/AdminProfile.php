<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use App\Models\User;

#[Layout('components.layouts.admin')] // Menggunakan layout admin Mazer
class AdminProfile extends Component
{
    // Properti untuk Form Info Profil
    public $name;
    public $email;

    // Properti untuk Form Ubah Password
    public $current_password;
    public $new_password;
    public $new_password_confirmation;

    /**
     * Mount: Dipanggil saat komponen dimuat.
     * Mengisi form dengan data admin yang sedang login.
     */
    public function mount()
    {
        $user = Auth::user();
        $this->name = $user->name;
        $this->email = $user->email;
    }

    /**
     * Aksi: Memperbarui informasi profil (Nama & Email)
     */
    public function updateProfile()
    {
         /** @var \App\Models\User $user */ 
        $user = Auth::user();

        // Validasi
        $validatedData = $this->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                // Pastikan email unik, KECUALI untuk user ID saat ini
                Rule::unique('users')->ignore($user->id),
            ],
        ]);

        // Simpan perubahan
        $user->update($validatedData);

        // Kirim notifikasi SweetAlert
        $this->dispatch('success-alert', ['message' => 'Informasi profil berhasil diperbarui.']);
    }

    /**
     * Aksi: Memperbarui password
     */
    public function updatePassword()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Validasi
        $validatedData = $this->validate([
            // 1. Cek apakah password saat ini cocok
            'current_password' => [
                'required',
                function ($attribute, $value, $fail) use ($user) {
                    if (!Hash::check($value, $user->password)) {
                        $fail('Password saat ini yang Anda masukkan salah.');
                    }
                },
            ],
            // 2. Validasi password baru
            'new_password' => [
                'required',
                'string',
                Password::min(8)->mixedCase()->numbers(), // Standar keamanan: min 8, huruf besar/kecil, angka
                'confirmed', // Otomatis cek 'new_password_confirmation'
            ],
        ]);

        // Simpan password baru (Laravel akan otomatis Hash)
        $user->update([
            'password' => Hash::make($this->new_password),
        ]);

        // Reset field password & kirim notifikasi
        $this->reset(['current_password', 'new_password', 'new_password_confirmation']);
        $this->dispatch('success-alert', ['message' => 'Password berhasil diubah.']);
    }


    public function render()
    {
        return view('livewire.admin.admin-profile');
    }
}
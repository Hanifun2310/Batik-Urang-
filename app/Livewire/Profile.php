<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Livewire\WithFileUploads; 
use Illuminate\Support\Facades\Storage;

#[Layout('components.layouts.app')]
class Profile extends Component
{
    use WithFileUploads;

    // Properti untuk form edit
    public string $name = '';
    public string $email = '';
    public ?string $bio = '';
    public ?string $gender = '';
    public ?string $date_of_birth = '';
    public ?string $phone_number = '';
    public ?string $address = '';

    // Properti untuk ganti password
    public string $password = '';
    public string $password_confirmation = '';

    //Properti untuk file foto (tipe mixed agar bisa null/TemporaryUploadedFile)
    public $photo;

    public function mount()
    {
        $user = Auth::user();
        $this->name = $user->name;
        $this->email = $user->email;
        $this->bio = $user->bio;
        $this->gender = $user->gender;
        $this->date_of_birth = $user->date_of_birth;
        $this->phone_number = $user->phone_number;
        $this->address = $user->address;
        // Kita tidak mengisi $this->photo di mount
    }

    public function updateProfile()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Validasi data
        $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'bio' => ['nullable', 'string', 'max:500'],
            'gender' => ['nullable', 'string', Rule::in(['Pria', 'Wanita'])],
            'date_of_birth' => ['nullable', 'date'],
            'phone_number' => ['nullable', 'string', 'max:15'],
            'address' => ['nullable', 'string' , 'max:1000'],
            'password' => ['nullable', 'string', 'confirmed', Password::defaults()],
            'photo' => ['nullable', 'image', 'max:1024'], 
        ]);

        // Update data user (field teks)
        $user->name = $this->name;
        $user->email = $this->email;
        $user->bio = $this->bio;
        $user->gender = $this->gender;
        $user->date_of_birth = $this->date_of_birth;
        $user->phone_number = $this->phone_number;
        $user->address = $this->address;
        // [TAMBAH] Proses upload foto jika ada
        if ($this->photo) {
            // Hapus foto lama jika ada
            if ($user->profile_photo_path && Storage::disk('public')->exists($user->profile_photo_path)) {
                Storage::disk('public')->delete($user->profile_photo_path);
            }
            // Simpan foto baru ke folder 'profile-photos' di 'storage/app/public'
            $path = $this->photo->store('profile-photos', 'public');
            // Simpan path foto baru ke database
            $user->profile_photo_path = $path;
        }

        // Update password (HANYA JIKA diisi)
        if (!empty($this->password)) {
            $user->password = Hash::make($this->password);
        }

        // Simpan semua perubahan ke database
        $user->save();

        // Reset field password dan photo di form
        $this->reset('password', 'password_confirmation', 'photo');

        // Kirim pesan sukses
        session()->flash('success', 'Profil berhasil diperbarui!');

        $this->dispatch('profile-updated'); 
    }


    public function render()
    {
        return view('livewire.profile');
    }
}
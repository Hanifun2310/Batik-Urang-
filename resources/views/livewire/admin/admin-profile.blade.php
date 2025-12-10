<div>
    <div class="page-heading">
        <h3>Akun Saya</h3>
    </div>

    <div class="page-content">
        <section class="section">
            <div class="row">


                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Informasi Profil</h4>
                        </div>
                        <div class="card-body">
                            <!-- Form untuk update profil -->
                            <form wire:submit="updateProfile">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Nama Lengkap</label>
                                    <input type="text" class="form-control" wire:model="name" id="name">
                                    @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="email" class="form-label">Alamat Email</label>
                                    <input type="email" class="form-control" wire:model="email" id="email">
                                    @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>

                                <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">
                                    <span wire:loading wire:target="updateProfile" class="spinner-border spinner-border-sm me-2" role="status"></span>
                                    Simpan Perubahan Profil
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- KOLOM 2: UBAH PASSWORD -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Ubah Password</h4>
                        </div>
                        <div class="card-body">
                            <!-- Form untuk update password -->
                            <form wire:submit="updatePassword">
                                <div class="mb-3">
                                    <label for="current_password" class="form-label">Password Saat Ini</label>
                                    <input type="password" class="form-control" wire:model="current_password" id="current_password">
                                    @error('current_password') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="new_password" class="form-label">Password Baru</label>
                                    <input type="password" class="form-control" wire:model="new_password" id="new_password">
                                    @error('new_password') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="new_password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                                    <input type="password" class="form-control" wire:model="new_password_confirmation" id="new_password_confirmation">
                                </div>

                                <button type="submit" class="btn btn-danger" wire:loading.attr="disabled">
                                    <span wire:loading wire:target="updatePassword" class="spinner-border spinner-border-sm me-2" role="status"></span>
                                    Ubah Password
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </section>
    </div>
</div>
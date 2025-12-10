<div>
    <div class="page-heading">
        <h3>Manajemen Pengguna</h3>
    </div>

    <div class="page-content">
        <section class="section">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Daftar Semua Pengguna</h4>
                </div>
                <div class="card-body">

                    <!-- Search Input -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <input type="text" class="form-control" placeholder="Cari Nama atau Email Pengguna..." wire:model.live.debounce.300ms="search">
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover table-lg">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Terdaftar Sejak</th>
                                    {{-- <th>Aksi</th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($users as $user)
                                <tr>
                                    <td class="text-bold-500">{{ $user->id }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->created_at->format('d M Y') }}</td>
                                    <td>
                                        {{-- <button class="btn btn-sm btn-danger" wire:click="showResetModal({{ $user->id }})">
                                            Reset Password
                                        </button> --}}
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center p-3">Tidak ada pengguna yang ditemukan.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
        </section>
    </div>


    @if($isResetModalOpen && $selectedUser)
        <div class="modal-backdrop fade show"></div>
        <div class="modal fade show" id="resetModal" tabindex="-1" style="display: block;">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form wire:submit.prevent="resetPassword">
                        <div class="modal-header bg-danger text-white">
                            <h5 class="modal-title">Reset Password Pengguna</h5>
                            <button type="button" class="btn-close btn-close-white" wire:click="closeResetModal" aria-label="Close"></button>
                        </div>
                        
                        <div class="modal-body">
                            <p>Anda akan mereset password untuk pengguna:</p>
                            <h5 class="text-bold mb-3">{{ $selectedUser->name }} ({{ $selectedUser->email }})</h5>
                            
                            <div class="alert alert-warning">
                                **Peringatan Keamanan:** Password akan disimpan sebagai HASH terenkripsi. Anda tidak dapat melihat password lama pengguna.
                            </div>
                            
                            <div class="mb-3">
                                <label for="newPassword" class="form-label">Password Baru (Min. 8 Karakter)</label>
                                <input type="password" class="form-control" wire:model="newPassword" id="newPassword">
                                @error('newPassword') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" wire:click="closeResetModal">Batal</button>
                            <button type="submit" class="btn btn-danger" wire:loading.attr="disabled">
                                <span wire:loading wire:target="resetPassword" class="spinner-border spinner-border-sm me-2" role="status"></span>
                                Reset & Simpan Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>
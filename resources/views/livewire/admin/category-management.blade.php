<div>
    <div class="page-heading">
        <h3>Manajemen Kategori</h3>
    </div>

    <div class="page-content">
        <section class="section">
            <div class="card">
                <div class="card-header">
                    <button class="btn btn-primary" wire:click="showModal">Tambah Kategori Baru</button>
                </div>
                <div class="card-body">

                    @if(session('message'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('message') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-hover table-lg">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nama Kategori</th>
                                    <th>Dibuat</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($categories as $category)
                                <tr>
                                    <td class="text-bold-500">{{ $category->id }}</td>
                                    <td>{{ $category->name }}</td>
                                    <td>{{ $category->created_at->format('d M Y') }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-warning" wire:click="showModal({{ $category->id }})">Edit</button>
                                        
                                        <button class="btn btn-sm btn-danger" 
                                                wire:click="confirmDelete({{ $category->id }})"> Hapus
                                        </button>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center">
                                        <p class="p-3 mb-0">Belum ada data kategori.</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $categories->links() }}
                    </div>
                </div>
            </div>
        </section>
    </div>

    @if($isModalOpen)
        <div class="modal-backdrop fade show"></div>
        <div class="modal fade show" id="categoryModal" tabindex="-1" style="display: block;">
            <div class="modal-dialog" role="document"> 
                <div class="modal-content">
                    
                    <form wire:submit="save">
                        <div class="modal-header">
                            <h5 class="modal-title">{{ $modalTitle }}</h5>
                            <button type="button" class="btn-close" wire:click="closeModal" aria-label="Close"></button>
                        </div>
                        
                        <div class="modal-body"> 
                            <div class="mb-3">
                                <label for="name" class="form-label">Nama Kategori</label>
                                <input type="text" class="form-control" wire:model="name">
                                @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" wire:click="closeModal">Batal</button>
                            <button type="submit" class="btn btn-primary">
                                @if($categoryId)
                                    Simpan Perubahan
                                @else
                                    Simpan Kategori
                                @endif
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    @endif

</div>
<div>
    <div class="page-heading">
        <h3>Manajemen Produk</h3>
    </div>

    <div class="page-content">
        <section class="section">
            <div class="card">
                <div class="card-header">
                    <button class="btn btn-primary" wire:click="showCreateModal">Tambah Produk Baru</button>
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
                                    <th>Gambar</th>
                                    <th>Nama Produk</th>
                                    <th>Kategori</th>
                                    <th>Harga</th>
                                    <th>Stok</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($products as $product)
                                <tr>
                                    <td>
                                        @if($product->main_image_url)
                                            <img src="{{ asset('storage/' . $product->main_image_url) }}" alt="{{ $product->name }}" width="60" style="object-fit: cover; border-radius: 8px;">
                                        @else
                                            <span class="badge bg-light-secondary">No-Img</span>
                                        @endif
                                    </td>
                                    <td class="text-bold-500">{{ $product->name }}</td>
                                    <td>{{ $product->category?->name ?? 'Tanpa Kategori' }}</td>
                                    <td class="text-bold-500">
                                        Rp {{ number_format($product->price, 0, ',', '.') }}
                                    </td>
                                    <td>{{ $product->stock_quantity }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-warning mb-auto " 
                                                wire:click="showEditModal({{ $product->id }})">Edit</button>
                                        <button class="btn btn-sm btn-danger" 
                                                wire:click="confirmDelete({{ $product->id }})" > Hapus
                                        </button>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center">
                                        <p class="p-3 mb-0">Belum ada data produk.</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $products->links() }}
                    </div>
                </div>
            </div>
        </section>
    </div>

    @if($isModalOpen)
        <div class="modal-backdrop fade show"></div>

        <div class="modal fade show" id="productModal" tabindex="-1" style="display: block;">
            <div class="modal-dialog modal-lg" role="document"> 
                <div class="modal-content">
                    
                    <form wire:submit="save">
                        <div class="modal-header">
                            <h5 class="modal-title">{{ $modalTitle }}</h5>
                            <button type="button" class="btn-close" wire:click="closeModal" aria-label="Close"></button>
                        </div>
                        
                        <div class="modal-body" style="max-height: 60vh; overflow-y: auto;"> 
                            
                            <div class="mb-3">
                                <label for="name" class="form-label">Nama Produk</label>
                                <input type="text" class="form-control" wire:model="name">
                                @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="category_id" class="form-label">Kategori</label>
                                    <select class="form-select" wire:model="category_id">
                                        <option value="">Pilih Kategori</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('category_id') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="price" class="form-label">Harga</label>
                                    <input type="number" class="form-control" wire:model="price" step="1000">
                                    @error('price') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="stock_quantity" class="form-label">Stok</label>
                                    <input type="number" class="form-control" wire:model="stock_quantity">
                                    @error('stock_quantity') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label for="photo" class="form-label">Upload Gambar Utama</label>
                                    <input type="file" class="form-control" wire:model="photo" id="photo">
                                    
                                    <div wire:loading wire:target="photo" class="text-muted mt-1">
                                        Uploading...
                                    </div>

                                    @if ($photo)
                                        <img src="{{ $photo->temporaryUrl() }}" alt="Preview" class="img-thumbnail mt-2" width="150">
                                    @elseif ($oldPhotoPath)
                                        <img src="{{ asset('storage/' . $oldPhotoPath) }}" alt="Current Image" class="img-thumbnail mt-2" width="150">
                                    @endif
                                    @error('photo') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="description" class="form-label">Deskripsi</label>
                                <textarea class="form-control" rows="3" wire:model="description"></textarea>
                                @error('description') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="mb-3">
                                <label for="size_chart_note" class="form-label">Catatan Ukuran</label>
                                <textarea class="form-control" rows="2" wire:model="size_chart_note"></textarea>
                                @error('size_chart_note') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" wire:click="closeModal">Batal</button>
                            <button type="submit" class="btn btn-primary" wire:loading.attr="disabled" wire:target="save">
                                <span wire:loading wire:target="save" class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                                
                                @if($productId)
                                    Simpan Perubahan
                                @else
                                    Simpan Produk
                                @endif
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    @endif

</div>
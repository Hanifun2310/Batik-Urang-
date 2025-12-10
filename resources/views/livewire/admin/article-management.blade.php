<div>
    <div class="page-heading">
        <h3>Manajemen Artikel Blog</h3>
    </div>

    <div class="page-content">
        <section class="section">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">Daftar Artikel</h4>
                    <button class="btn btn-primary" wire:click="create">
                        <i class="bi bi-plus-lg"></i> Tambah Artikel Baru
                    </button>
                </div>
                <div class="card-body">

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <input type="text" class="form-control" placeholder="Cari Judul atau Isi Artikel..." wire:model.live.debounce.300ms="search">
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover table-lg">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Gambar</th>
                                    <th>Judul</th>
                                    <th>Status</th>
                                    <th>Tanggal</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($articles as $article)
                                <tr>
                                    <td class="text-bold-500">{{ $article->id }}</td>
                                    <td>
                                        @if($article->featured_image_url)
                                            <img src="{{ asset('storage/' . $article->featured_image_url) }}" alt="Cover" class="rounded" style="width: 50px; height: 50px; object-fit: cover;">
                                        @else
                                            <i class="bi bi-image" style="font-size: 2rem;"></i>
                                        @endif
                                    </td>
                                    <td>{{ Str::limit($article->title, 50) }}</td>
                                    <td>

                                        @if($article->status == 'published')
                                            <span class="badge bg-success">Dipublikasikan</span>
                                        @else
                                            <span class="badge bg-warning">Draft</span>
                                        @endif
                                    </td>
                                    <td>{{ $article->created_at->format('d M Y') }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-info me-2" wire:click="edit({{ $article->id }})">Edit</button>
                                        <button class="btn btn-sm btn-danger" wire:click="confirmDelete({{ $article->id }})">Hapus</button>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center p-3">Tidak ada artikel yang ditemukan.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $articles->links() }}
                    </div>
                </div>
            </div>
        </section>
    </div>


    @if($isModalOpen)
        <div class="modal-backdrop fade show"></div>
        <div class="modal fade show" id="articleModal" tabindex="-1" style="display: block;">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <form wire:submit.prevent="store">
                        <div class="modal-header bg-primary text-white">
                            <h5 class="modal-title">{{ $isEditMode ? 'Edit Artikel: ' . Str::limit($title, 30) : 'Tambah Artikel Baru' }}</h5>
                            <button type="button" class="btn-close btn-close-white" wire:click="closeModal" aria-label="Close"></button>
                        </div>
                        
                        <div class="modal-body" style="max-height: 70vh; overflow-y: auto;">
                            <div class="row">

                                <div class="col-md-8">
                                    {{-- Judul --}}
                                    <div class="mb-3">
                                        <label for="title" class="form-label">Judul Artikel</label>
                                        <input type="text" class="form-control @error('title') is-invalid @enderror" wire:model.live="title" id="title" placeholder="Masukkan judul artikel">
                                        @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                    

                                    {{-- Konten --}}
                                    <div class="mb-3">
                                        <label for="content" class="form-label">Isi Konten Artikel</label>
                                        <textarea class="form-control @error('content') is-invalid @enderror" wire:model="content" id="content" rows="10" placeholder="Tulis isi artikel di sini..."></textarea>
                                        @error('content') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    {{-- Gambar Cover --}}
                                    <div class="mb-3">
                                        <label for="coverImage" class="form-label">Gambar Cover</label>
                                        <input type="file" class="form-control @error('coverImage') is-invalid @enderror" wire:model="coverImage" id="coverImage">
                                        @error('coverImage') <div class="invalid-feedback">{{ $message }}</div> @enderror

                                        @if ($coverImage)
                                            <p class="mt-2">Preview Gambar Baru:</p>
                                            <img src="{{ $coverImage->temporaryUrl() }}" class="img-fluid rounded shadow-sm" style="max-height: 150px;">
                                        @endif
                                        
                                        @if ($isEditMode && $oldFeaturedImagePath && !$coverImage)
                                            <p class="mt-2">Gambar Saat Ini:</p>
                                            <img src="{{ asset('storage/' . $oldFeaturedImagePath) }}" class="img-fluid rounded shadow-sm" style="max-height: 150px;">
                                            <small class="d-block text-muted">Akan diganti jika Anda mengunggah yang baru.</small>
                                        @endif

                                    <div class="mb-3">
                                        <label for="statusSelect" class="form-label">Status Publikasi</label>
                                        <select id="statusSelect" class="form-select" wire:model="status">
                                            <option value="draft">Draft (Tidak Tampil)</option>
                                            <option value="published">Dipublikasikan (Tampil)</option>
                                        </select>
                                    </div>

                                </div>
                            </div>
                            
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" wire:click="closeModal">Batal</button>
                            <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">
                                <span wire:loading wire:target="store" class="spinner-border spinner-border-sm me-2" role="status"></span>
                                {{ $isEditMode ? 'Simpan Perubahan' : 'Tambahkan Artikel' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>
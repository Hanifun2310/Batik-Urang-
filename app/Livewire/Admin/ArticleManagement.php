<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use App\Models\Article;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth; // Pastikan Auth di-import
use Livewire\Attributes\On;

#[Layout('components.layouts.admin')]
class ArticleManagement extends Component
{
    use WithPagination, WithFileUploads;

    // Properti untuk tabel
    public $search = '';
    public $perPage = 10;

    // Properti untuk CRUD
    public $articleId;
    
    #[Validate('required|min:5|max:255')]
    public $title;
    public $slug;
    
    #[Validate('required|min:10')]
    public $content;
    
    #[Validate('nullable|image|max:1024')]
    public $coverImage; // Properti untuk upload file (temporary)
    public $oldFeaturedImagePath; // Properti untuk path gambar lama (saat edit)
    
    #[Validate('required|in:draft,published')]
    public $status = 'draft'; // Sesuai Model Anda (string), default 'draft'
    
    // Properti Modal
    public $isModalOpen = false;
    public $isEditMode = false;
    
    // --- PERBAIKAN 1: Tambahkan properti untuk menyimpan ID Hapus ---
    public $itemToDelete = null;

    // FUNGSI: Otomatis generate slug saat title diubah
    public function updatedTitle($value)
    {
        $this->slug = Str::slug($value);
    }

    // FUNGSI UTAMA: Mengambil data artikel
    public function getArticlesProperty()
    {
        return Article::query()
            ->when($this->search, function ($query) {
                $query->where('title', 'like', '%'.$this->search.'%')
                      ->orWhere('content', 'like', '%'.$this->search.'%');
            })
            ->latest()
            ->paginate($this->perPage);
    }
    
    // FUNGSI: Membuka modal untuk Tambah Artikel
    public function create()
    {
        $this->resetCrudProps(); // Gunakan fungsi reset kustom
        $this->isEditMode = false;
        $this->isModalOpen = true;
    }
    
    // FUNGSI: Membuka modal untuk Edit Artikel
    public function edit(Article $article)
    {
        $this->resetCrudProps(); // Reset dulu
        
        $this->articleId = $article->id;
        $this->title = $article->title;
        $this->slug = $article->slug;
        $this->content = $article->content;
        $this->status = $article->status; // Mengambil 'published' atau 'draft'
        $this->oldFeaturedImagePath = $article->featured_image_url; // Mengambil path dari Model
        
        $this->isEditMode = true;
        $this->isModalOpen = true;
    }
    
    // FUNGSI: Simpan atau Update Artikel
    public function store()
    {
        $this->validate();

        $imagePath = $this->oldFeaturedImagePath; // Default path lama
        
        if ($this->coverImage) {
            if ($this->isEditMode && $this->oldFeaturedImagePath) {
                Storage::disk('public')->delete($this->oldFeaturedImagePath);
            }
            $imagePath = $this->coverImage->store('article_covers', 'public');
        }

        $baseSlug = Str::slug($this->title);
        $slug = $baseSlug;
        $i = 1;
        while (Article::where('slug', $slug)
                        ->where('id', '!=', $this->articleId)
                        ->exists()) {
            $slug = $baseSlug . '-' . $i++;
        }

        $data = [
            'title' => $this->title,
            'slug' => $slug,
            'content' => $this->content,
            'featured_image_url' => $imagePath, // Sesuai Model
            'status' => $this->status, // Sesuai Model
            // 'user_id' => Auth::id(), // Anda mengomentari ini di Model, jadi saya nonaktifkan
        ];

        if ($this->isEditMode) {
            Article::find($this->articleId)->update($data);
            $message = 'Artikel berhasil diperbarui.';
        } else {
            Article::create($data);
            $message = 'Artikel baru berhasil ditambahkan.';
        }

        $this->dispatch('success-alert', ['message' => $message]);
        $this->closeModal();
    }
    
    // FUNGSI: Menutup modal
    public function closeModal()
    {
        $this->isModalOpen = false;
        $this->resetCrudProps();
    }
    
    // FUNGSI: Reset properti form
    private function resetCrudProps()
    {
        $this->resetErrorBag();
        $this->reset(['articleId', 'title', 'slug', 'content', 'coverImage', 'oldFeaturedImagePath', 'status', 'isEditMode', 'itemToDelete']);
    }


    // --- PERBAIKAN 2: Sesuaikan confirmDelete agar cocok dengan JS Anda ---
    // FUNGSI: Tampilkan Konfirmasi Hapus ke User
    public function confirmDelete($articleId)
    {
        $this->itemToDelete = $articleId; // 1. Simpan ID di properti
        $this->dispatch('show-delete-confirmation'); // 2. Kirim event SEDERHANA (tanpa data)
    }

    // --- PERBAIKAN 3: Sesuaikan delete agar cocok dengan JS Anda ---
    #[On('delete-confirmed')] // Listener ini sudah benar
    public function delete() // Hapus parameter $articleId
    {
        // 1. Ambil ID dari properti
        $article = Article::find($this->itemToDelete); 
        
        if ($article) {
            if ($article->featured_image_url) {
                Storage::disk('public')->delete($article->featured_image_url);
            }
            $article->delete();
            $this->dispatch('success-alert', ['message' => 'Artikel berhasil dihapus!']);
        } else {
             $this->dispatch('success-alert', ['message' => 'Artikel tidak ditemukan atau sudah dihapus.']);
        }
        
        // 2. Reset ID setelah selesai
        $this->itemToDelete = null; 
    }
    
    
    public function render()
    {
        return view('livewire.admin.article-management', [
            'articles' => $this->articles,
        ]);
    }
}
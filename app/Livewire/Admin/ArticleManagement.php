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
use Illuminate\Support\Facades\Auth; 
use Livewire\Attributes\On;

#[Layout('components.layouts.admin')]
class ArticleManagement extends Component
{
    use WithPagination, WithFileUploads;


    public $search = '';
    public $perPage = 10;


    public $articleId;
    
    #[Validate('required|min:5|max:255')]
    public $title;
    public $slug;
    
    #[Validate('required|min:10')]
    public $content;
    
    #[Validate('nullable|image|max:1024')]
    public $coverImage;
    public $oldFeaturedImagePath; 
    
    #[Validate('required|in:draft,published')]
    public $status = 'draft'; 
    
    public $isModalOpen = false;
    public $isEditMode = false;
    
    public $itemToDelete = null;
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
    
    public function create()
    {
        $this->resetCrudProps();
        $this->isEditMode = false;
        $this->isModalOpen = true;
    }
    
    public function edit(Article $article)
    {
        $this->resetCrudProps(); 
        
        $this->articleId = $article->id;
        $this->title = $article->title;
        $this->slug = $article->slug;
        $this->content = $article->content;
        $this->status = $article->status; 
        $this->oldFeaturedImagePath = $article->featured_image_url;
        
        $this->isEditMode = true;
        $this->isModalOpen = true;
    }
    
    public function store()
    {
        $this->validate();

        $imagePath = $this->oldFeaturedImagePath; 
        
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
            'featured_image_url' => $imagePath,
            'status' => $this->status, 
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
    
    private function resetCrudProps()
    {
        $this->resetErrorBag();
        $this->reset(['articleId', 'title', 'slug', 'content', 'coverImage', 'oldFeaturedImagePath', 'status', 'isEditMode', 'itemToDelete']);
    }


    public function confirmDelete($articleId)
    {
        $this->itemToDelete = $articleId; 
        $this->dispatch('show-delete-confirmation'); 
    }

    #[On('delete-confirmed')] 
    public function delete() 
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
        
        $this->itemToDelete = null; 
    }
    
    
    public function render()
    {
        return view('livewire.admin.article-management', [
            'articles' => $this->articles,
        ]);
    }
}
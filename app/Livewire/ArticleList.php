<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Article;          // Impor model Article
use Livewire\Attributes\Layout; // Impor Layout
use Livewire\WithPagination;    // Impor trait Pagination

#[Layout('components.layouts.app')] // <-- Gunakan layout utama
class ArticleList extends Component
{
    use WithPagination; // <-- [TAMBAH] Aktifkan pagination Livewire

    /**
     * Method render untuk menampilkan view.
     */
    public function render()
    {
        // 1. Ambil data artikel dari database
        $articles = Article::where('status', 'published') // Ambil hanya yang statusnya 'published'
                           ->latest()                 // Urutkan dari yang terbaru
                           ->paginate(6);              // Bagi per halaman (misal 6 artikel per halaman)

        // 2. Kirim data artikel ke view
        return view('livewire.article-list', [
            'articles' => $articles
        ]);
    }
}
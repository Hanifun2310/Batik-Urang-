<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Article;         
use Livewire\Attributes\Layout; 
use Livewire\WithPagination;    

#[Layout('components.layouts.app')]
class ArticleList extends Component
{
    use WithPagination; 

    /**
     * Method render untuk menampilkan view.
     */
    public function render()
    {
        // 1. Ambil data artikel dari database
        $articles = Article::where('status', 'published') 
                        ->latest()                 
                        ->paginate(6);              

        // 2. Kirim data artikel ke view
        return view('livewire.article-list', [
            'articles' => $articles
        ]);
    }
}
<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Article;         
use Livewire\Attributes\Layout; 
use Livewire\Attributes\Title; 

#[Layout('components.layouts.app')] 
class ArticleShow extends Component
{
    // Properti $title untuk judul tab browser
    public $title; 

    // Properti untuk menyimpan artikel yang sedang dilihat
    public Article $article;

    /**
     * Method mount dijalankan saat komponen dimuat.
     */
    public function mount(Article $article)
    {
        // if ($article->status !== 'published') {
        //     abort(404);
        // }

        $this->article = $article;

        $this->title = $article->title . ' - Batik Urang'; 
    }
    
    /**
     * Method render untuk menampilkan view.
     */
    public function render()
    {
        return view('livewire.article-show');
    }
}
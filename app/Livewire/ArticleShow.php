<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Article;         
use Livewire\Attributes\Layout; 
use Livewire\Attributes\Title; 

#[Layout('components.layouts.app')] 
class ArticleShow extends Component
{
    public $title; 

    public Article $article;

    /**
     * Method mount dijalankan saat komponen dimuat.
     */
    public function mount(Article $article)
    {
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
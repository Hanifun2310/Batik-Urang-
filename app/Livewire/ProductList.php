<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;
use App\Models\Category;
use Livewire\Attributes\Layout;
use Livewire\WithPagination;      
use Livewire\Attributes\Url;      

#[Layout('components.layouts.app')] 
class ProductList extends Component
{
    use WithPagination; 


    
    #[Url(as: 'kategori', keep: true)] 
    public $selectedCategory = ''; 
    #[Url(as: 'q', keep: true)] 
    public $searchQuery = ''; 

    /**
     * Method render untuk menampilkan view.
     * Logika pengambilan data ada di sini.
     */
    public function render()
    {
        $productQuery = Product::query()->latest(); 


        if (!empty($this->selectedCategory)) {

            $category = Category::where('slug', $this->selectedCategory)->first();
            if ($category) {
                
                $productQuery->where('category_id', $category->id);
            }
        }

        if (!empty($this->searchQuery)) {
            $productQuery->where('name', 'LIKE', '%' . $this->searchQuery . '%');
        }


        $categories = Category::orderBy('name', 'asc')->get();

        $products = $productQuery->paginate(12);


        return view('livewire.product-list', [
            'products' => $products,
            'categories' => $categories,
        ]);
    }


    public function updated($propertyName)
    {
        if (in_array($propertyName, ['selectedCategory', 'searchQuery'])) {
            $this->resetPage(); 
        }
    }
}
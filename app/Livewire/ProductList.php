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
        // Mulai query produk
        $productQuery = Product::query()->latest(); 

        // Terapkan filter Kategori 
        if (!empty($this->selectedCategory)) {

            $category = Category::where('slug', $this->selectedCategory)->first();
            if ($category) {
                
                $productQuery->where('category_id', $category->id);
            }
        }

        // Terapkan filter Pencarian 
        if (!empty($this->searchQuery)) {
            $productQuery->where('name', 'LIKE', '%' . $this->searchQuery . '%');
        }

        // Ambil semua kategori (untuk ditampilkan sebagai filter)
        $categories = Category::orderBy('name', 'asc')->get();

        // Ambil hasil produk dengan pagination
        $products = $productQuery->paginate(12);

        // Kirim semua data ke view
        return view('livewire.product-list', [
            'products' => $products,
            'categories' => $categories,
            // 'searchTerm' => $this->searchQuery 
        ]);
    }


    public function updated($propertyName)
    {
        if (in_array($propertyName, ['selectedCategory', 'searchQuery'])) {
            $this->resetPage(); 
        }
    }
}
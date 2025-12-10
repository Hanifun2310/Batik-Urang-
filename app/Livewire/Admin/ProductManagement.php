<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Product;
use App\Models\Category;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage; 
use Livewire\Attributes\On;

#[Layout('components.layouts.admin')]
class ProductManagement extends Component
{
    use WithPagination;
    use WithFileUploads;

    // --- Properti Formulir ---
    #[Validate('required|string|max:255')]
    public $name;

    #[Validate('required|exists:categories,id')]
    public $category_id;

    #[Validate('required|numeric|min:0')]
    public $price;

    #[Validate('required|integer|min:0')]
    public $stock_quantity;

    #[Validate('nullable|string')]
    public $description;

    #[Validate('nullable|image|max:1024')] 
    public $photo;

    #[Validate('nullable|string')]
    public $size_chart_note;


    public $productId = null;       
    public $oldPhotoPath = null;    
    public $modalTitle = 'Tambah Produk Baru'; 


    public $isModalOpen = false;


    public function showCreateModal()
    {
        $this->reset(); 
        $this->resetErrorBag();
        $this->modalTitle = 'Tambah Produk Baru';
        $this->isModalOpen = true;
    }

    public function showEditModal($id)
    {
        $this->reset(); 
        $this->resetErrorBag();
        
        $product = Product::findOrFail($id); 
        
        $this->productId = $product->id;
        $this->name = $product->name;
        $this->category_id = $product->category_id;
        $this->price = $product->price;
        $this->stock_quantity = $product->stock_quantity;
        $this->description = $product->description;
        $this->size_chart_note = $product->size_chart_note;
        $this->oldPhotoPath = $product->main_image_url; 

        $this->modalTitle = 'Edit Produk: ' . $product->name;
        $this->isModalOpen = true;
    }
    

    public function closeModal()
    {
        $this->isModalOpen = false;
        $this->reset(); 
    }

    public $itemToDelete = null;

public function confirmDelete($id)
{
    $this->itemToDelete = $id; 

    $this->dispatch('show-delete-confirmation'); 
}

    // --- FUNGSI SAVE ---
    public function save()
    {

        $this->validate();

        $imagePath = $this->oldPhotoPath; 

        if ($this->photo) {
            $imagePath = $this->photo->store('products', 'public');
            if ($this->oldPhotoPath) {
                Storage::disk('public')->delete($this->oldPhotoPath);
            }
        }


        $data = [
            'name' => $this->name,
            'category_id' => $this->category_id,
            'price' => $this->price,
            'stock_quantity' => $this->stock_quantity,
            'description' => $this->description,
            'main_image_url' => $imagePath,
            'size_chart_note' => $this->size_chart_note,
        ];


        if ($this->productId) {
            // MODE UPDATE
            $product = Product::find($this->productId);
            $product->update($data);
            $message = 'Produk berhasil diperbarui.';
        } else {
            // MODE CREATE
            Product::create($data);
            $message = 'Produk berhasil ditambahkan.';
        }


        $this->dispatch('success-alert', ['message' => $message]);


        $this->closeModal();
    }

    


// FUNGSI DELETE 
#[On('delete-confirmed')]
public function delete()
{

    if ($this->itemToDelete) {
        $product = Product::findOrFail($this->itemToDelete);
        

        if ($product->main_image_url) {
            Storage::disk('public')->delete($product->main_image_url);
        }

        $product->delete();


        $this->dispatch('success-alert', ['message' => 'Produk berhasil dihapus.']);
        
        $this->itemToDelete = null;

    }
}
// ...

    public function render()
    {
        $products = Product::with('category')
                           ->latest()
                           ->paginate(10);
        
        $categories = Category::orderBy('name')->get();

        return view('livewire.admin.product-management', [
            'products' => $products,
            'categories' => $categories,
        ]);
    }
}
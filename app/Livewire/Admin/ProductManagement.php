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

    #[Validate('nullable|image|max:1024')] // Validasi photo: (hanya untuk UPLOAD BARU)
    public $photo;

    #[Validate('nullable|string')]
    public $size_chart_note;

    // --- ProOPERTI BARU UNTUK EDIT ---
    public $productId = null;       // 2. Untuk menyimpan ID produk yang diedit
    public $oldPhotoPath = null;    // 3. Untuk menyimpan path gambar lama (untuk preview)
    public $modalTitle = 'Tambah Produk Baru'; // 4. Untuk judul modal dinamis

    // --- Properti Modal ---
    public $isModalOpen = false;

    // --- 5. FUNGSI BARU: Membuka modal untuk CREATE ---
    public function showCreateModal()
    {
        $this->reset(); // Reset semua properti
        $this->resetErrorBag();
        $this->modalTitle = 'Tambah Produk Baru';
        $this->isModalOpen = true;
    }

    // --- 6. FUNGSI BARU: Membuka modal untuk EDIT ---
    public function showEditModal($id)
    {
        $this->reset(); // Reset dulu
        $this->resetErrorBag();
        
        $product = Product::findOrFail($id); // Cari produk, atau gagal
        
        // 6a. Isi semua properti form
        $this->productId = $product->id;
        $this->name = $product->name;
        $this->category_id = $product->category_id;
        $this->price = $product->price;
        $this->stock_quantity = $product->stock_quantity;
        $this->description = $product->description;
        $this->size_chart_note = $product->size_chart_note;
        $this->oldPhotoPath = $product->main_image_url; // Simpan path gambar lama

        // Atur modal dan buka
        $this->modalTitle = 'Edit Produk: ' . $product->name;
        $this->isModalOpen = true;
    }
    
    // ---UNGSI CLOSE MODAL (Update) ---
    public function closeModal()
    {
        $this->isModalOpen = false;
        $this->reset(); // Reset akan menghapus semua properti (termasuk productId)
    }

    public $itemToDelete = null;

// FUNGSI BARU: Untuk memicu dialog SweetAlert dari Livewire
public function confirmDelete($id)
{
    $this->itemToDelete = $id; // Simpan ID di properti
    // Kirim event ke JavaScript untuk menampilkan SweetAlert
    $this->dispatch('show-delete-confirmation'); 
}

    // --- FUNGSI SAVE ---
// --- FUNGSI SAVE YANG BENAR ---
    public function save()
    {
        // 1. Validasi
        $this->validate();

        $imagePath = $this->oldPhotoPath; 

        // 2. Logika Upload Gambar
        if ($this->photo) {
            $imagePath = $this->photo->store('products', 'public');
            if ($this->oldPhotoPath) {
                Storage::disk('public')->delete($this->oldPhotoPath);
            }
        }

        // 3. Siapkan data
        $data = [
            'name' => $this->name,
            'category_id' => $this->category_id,
            'price' => $this->price,
            'stock_quantity' => $this->stock_quantity,
            'description' => $this->description,
            'main_image_url' => $imagePath,
            'size_chart_note' => $this->size_chart_note,
        ];

        // 4. Logika PINTAR: Update atau Create?
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

        // 5. Kirim SweetAlert (Hanya Sekali)
        $this->dispatch('success-alert', ['message' => $message]);

        // 6. Tutup modal (Hanya Sekali)
        $this->closeModal();
    }

    

    // ---FUNGSI BARU: HAPUS PRODUK ---
// app/Livewire/Admin/ProductManagement.php

// ...

// FUNGSI DELETE (DIJALANKAN OLEH EVENT 'delete-confirmed')
#[On('delete-confirmed')]
public function delete()
{
    // Cek jika ID tersedia dan merupakan ID produk
    if ($this->itemToDelete) {
        $product = Product::findOrFail($this->itemToDelete);
        
        // Hapus gambar dari storage (jika ada)
        if ($product->main_image_url) {
            Storage::disk('public')->delete($product->main_image_url);
        }

        // Hapus record produk dari database
        $product->delete();

        // Kirim notifikasi Toast
        $this->dispatch('success-alert', ['message' => 'Produk berhasil dihapus.']);
        
        // Bersihkan properti
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
<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use App\Models\Category; // Import Model Category
use Livewire\WithPagination;
use Livewire\Attributes\On;

#[Layout('components.layouts.admin')]
class CategoryManagement extends Component
{
    use WithPagination;

    // Properti Form
    public $categoryId = null; // Untuk mode Edit
    public $modalTitle = 'Tambah Kategori Baru';

    // Properti yang divalidasi
    #[Validate('required|string|max:100|unique:categories,name')]
    public $name = '';

    // Properti Modal
    public $isModalOpen = false;

    // --- Fungsi Modal & Reset ---

    public function showModal($id = null)
    {
        $this->reset(['name', 'categoryId']); // Bersihkan form
        $this->resetErrorBag();

        if ($id) {
            // Mode Edit
            $category = Category::findOrFail($id);
            $this->categoryId = $category->id;
            $this->name = $category->name;
            $this->modalTitle = 'Edit Kategori: ' . $category->name;
        } else {
            // Mode Create
            $this->modalTitle = 'Tambah Kategori Baru';
        }
        $this->isModalOpen = true;
    }

    public function closeModal()
    {
        $this->isModalOpen = false;
        $this->reset();
    }

    // --- Fungsi CRUD ---

    public function save()
{
    // Jika mode edit, abaikan nama kategori saat ini dari validasi unique
    if ($this->categoryId) {
        $this->validate([
            'name' => 'required|string|max:100|unique:categories,name,' . $this->categoryId,
        ]);
    } else {
        $this->validate();
    }

    $data = [
        'name' => $this->name,
    ];

    if ($this->categoryId) {
        // UPDATE
        $category = Category::find($this->categoryId);
        $category->update($data);
        $this->dispatch('success-alert', ['message' => 'Kategori berhasil diperbarui.']);
    } else {
        // CREATE
        Category::create($data);
        $this->dispatch('success-alert', ['message' => 'Kategori berhasil ditambahkan.']);
    }

    $this->closeModal();
}

public $itemToDelete = null; // Properti baru untuk menyimpan ID yang akan dihapus

    // FUNGSI BARU: Untuk memicu dialog SweetAlert dari Livewire
    public function confirmDelete($id)
    {
        $this->itemToDelete = $id; // Simpan ID di properti
        // Kirim event ke JavaScript untuk menampilkan SweetAlert
        $this->dispatch('show-delete-confirmation'); 
    }

    // FUNGSI DELETE LAMA (TAPI DIUBAH MENJADI LISTENER)
    #[On('delete-confirmed')] // Dijalankan ketika SweetAlert mengonfirmasi hapus
    public function delete()
    {
        // Pastikan ID tersedia
        if ($this->itemToDelete) {
            Category::destroy($this->itemToDelete);
            
            // Kirim notifikasi Toast
            $this->dispatch('success-alert', ['message' => 'Kategori berhasil dihapus.']);
            
            // Bersihkan properti
            $this->itemToDelete = null;
        }
    }

    // --- Fungsi Render ---

    public function render()
    {
        $categories = Category::latest()->paginate(10);
        
        return view('livewire.admin.category-management', [
            'categories' => $categories
        ]);
    }
}
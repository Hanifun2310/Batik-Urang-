<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Attributes\On;
use App\Models\Order; 
use App\Models\User;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;

#[Layout('components.layouts.admin')]
class OrderManagement extends Component
{
    use WithPagination;

    // Properti untuk filter & pencarian
    public $search = '';
    public $statusFilter = ''; // Filter berdasarkan status
    public $perPage = 10;

    // Properti untuk Modal Detail Pesanan
    public $isDetailModalOpen = false;
    public $selectedOrder = null;
    
    // Properti untuk Update Status
    #[Validate('required|string')]
    public $newStatus = '';
    
    // Status yang tersedia untuk diupdate
    public $availableStatuses = [
        'pending' => 'Menunggu Pembayaran', 
        'verifying' => 'Verifikasi Pembayaran', 
        'paid' => 'Lunas, Siap Diproses', 
        'processed' => 'Sedang Diproses', 
        'shipped' => 'Sudah Dikirim', 
        'delivered' => 'Telah Diterima', 
        'canceled' => 'Dibatalkan'
    ];

    // Fungsi Utama: Mengambil data pesanan
    public function getOrdersProperty()
    {
        return Order::query()
            ->with(['user']) // Ambil data user pelanggan
            ->when($this->search, function ($query) {
                // Cari berdasarkan ID Pesanan atau Nama Pelanggan
                $query->where('id', 'like', '%'.$this->search.'%')
                      ->orWhereHas('user', function ($q) {
                          $q->where('name', 'like', '%'.$this->search.'%');
                      });
            })
            ->when($this->statusFilter, function ($query) {
                $query->where('status', $this->statusFilter);
            })
            ->latest() // Urutkan dari yang terbaru
            ->paginate($this->perPage);
    }
    
    // Reset Filter
    public function resetFilters()
    {
        $this->reset(['search', 'statusFilter']);
    }
    
    // FUNGSI: Membuka modal detail
    public function showDetailModal($orderId)
    {
        // Ambil relasi yang diperlukan untuk detail
        $this->selectedOrder = Order::with(['user', 'Items.product'])->findOrFail($orderId);
        $this->newStatus = $this->selectedOrder->status; // Set status saat ini
        $this->isDetailModalOpen = true;
    }

    // FUNGSI: Menutup modal detail
    public function closeDetailModal()
    {
        $this->isDetailModalOpen = false;
        $this->selectedOrder = null;
        $this->newStatus = '';
    }

    // FUNGSI: Mengubah Status Pesanan
    public function updateStatus()
    {
        if (!$this->selectedOrder) {
            return;
        }
        
        // Validasi status baru
        $this->validate([
            'newStatus' => 'required|in:' . implode(',', array_keys($this->availableStatuses)),
        ]);

        // Update status di database
        $this->selectedOrder->update(['status' => $this->newStatus]);
        
        // Kirim notifikasi Toast
        $statusLabel = $this->availableStatuses[$this->newStatus];
        $this->dispatch('success-alert', ['message' => 'Status Pesanan #' . $this->selectedOrder->id . ' berhasil diubah menjadi ' . $statusLabel . '.']);
        
        // Tutup modal, bersihkan properti, dan refresh tabel
        $this->closeDetailModal();
        $this->gotoPage(1); // Kembali ke halaman 1 setelah update
    }


    public function render()
    {
        // Menggunakan property getOrdersProperty()
        return view('livewire.admin.order-management', [
            'orders' => $this->orders,
            'availableStatuses' => $this->availableStatuses, // Kirim status ke view
        ]);
    }
}
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


    public $search = '';
    public $statusFilter = ''; 
    public $perPage = 10;

    // Properti  Detail Pesanan
    public $isDetailModalOpen = false;
    public $selectedOrder = null;
    
    // untuk Update Status
    #[Validate('required|string')]
    public $newStatus = '';
    
    public $availableStatuses = [
        'pending' => 'Menunggu Pembayaran', 
        'verifying' => 'Verifikasi Pembayaran', 
        'paid' => 'Lunas, Siap Diproses', 
        'processed' => 'Sedang Diproses', 
        'shipped' => 'Sudah Dikirim', 
        'delivered' => 'Telah Diterima', 
        'canceled' => 'Dibatalkan'
    ];

    public function getOrdersProperty()
    {
        return Order::query()
            ->with(['user']) 
            ->when($this->search, function ($query) {
                $query->where('id', 'like', '%'.$this->search.'%')
                      ->orWhereHas('user', function ($q) {
                          $q->where('name', 'like', '%'.$this->search.'%');
                      });
            })
            ->when($this->statusFilter, function ($query) {
                $query->where('status', $this->statusFilter);
            })
            ->latest() 
            ->paginate($this->perPage);
    }
    

    public function resetFilters()
    {
        $this->reset(['search', 'statusFilter']);
    }
    
    public function showDetailModal($orderId)
    {

        $this->selectedOrder = Order::with(['user', 'items.product'])->findOrFail($orderId);
        $this->newStatus = $this->selectedOrder->status; 
        $this->isDetailModalOpen = true;
    }

    public function closeDetailModal()
    {
        $this->isDetailModalOpen = false;
        $this->selectedOrder = null;
        $this->newStatus = '';
    }

    public function updateStatus()
    {
        if (!$this->selectedOrder) {
            return;
        }
        
        $this->validate([
            'newStatus' => 'required|in:' . implode(',', array_keys($this->availableStatuses)),
        ]);
        $this->selectedOrder->update(['status' => $this->newStatus]);
        

        $statusLabel = $this->availableStatuses[$this->newStatus];
        $this->dispatch('success-alert', ['message' => 'Status Pesanan #' . $this->selectedOrder->id . ' berhasil diubah menjadi ' . $statusLabel . '.']);
        

        $this->closeDetailModal();
        $this->gotoPage(1); 
    }


    public function render()
    {

        return view('livewire.admin.order-management', [
            'orders' => $this->orders,
            'availableStatuses' => $this->availableStatuses, 
        ]);
    }
}
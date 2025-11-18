<?php

namespace App\Livewire\User;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use Livewire\WithPagination;
use Livewire\WithFileUploads; 
use Illuminate\Support\Facades\Storage; 

#[Layout('components.layouts.app')]
class OrderList extends Component
{
    use WithPagination;
    use WithFileUploads; 

    // [TAMBAH] Properti untuk file (menampung file sementara)
    public $paymentProofFile;

    // [TAMBAH] Properti untuk melacak pesanan mana yg sedang di-upload
    public $uploadingOrderId = null;

    // [TAMBAH] Properti untuk pesan sukses upload
    public $successMessage = '';

    /**
     * [TAMBAH] Method untuk memicu form upload untuk pesanan tertentu
     */
    public function showUploadForm($orderId)
    {
        $this->uploadingOrderId = $orderId;
        $this->paymentProofFile = null; 
        $this->successMessage = ''; 
    }

    /**
     * [TAMBAH] Method untuk menyimpan file bukti bayar
     */
    public function savePaymentProof()
    {
        // 1. Validasi file
        $this->validate([
            'paymentProofFile' => 'required|image|max:2048', 
        ]);

        // 2. Cari pesanan
        $order = Order::findOrFail($this->uploadingOrderId);

        // 3. Cek keamanan (pastikan ini pesanan milik user)
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        // 4. Hapus file lama jika 
        if ($order->payment_proof_path && Storage::disk('public')->exists($order->payment_proof_path)) {
            Storage::disk('public')->delete($order->payment_proof_path);
        }

        // 5. Simpan file baru ke 'storage/app/public/payment-proofs'
        $path = $this->paymentProofFile->store('payment-proofs', 'public');

        // 6. Update database
        $order->update([
            'payment_proof_path' => $path,
            'status' => 'verifying' 
        ]);

        // 7. Reset state & kirim pesan sukses
        $this->successMessage = 'Bukti bayar berhasil diupload! Admin akan segera memverifikasi.';
        $this->uploadingOrderId = null; 
        $this->paymentProofFile = null;
    }

    /**
     * Method render (logika ambil data pesanan)
     */
    public function render()
    {
        $userId = Auth::id();
        $orders = Order::where('user_id', $userId)
                       ->with('items')
                       ->orderBy('created_at', 'desc')
                       ->paginate(10); 

        return view('livewire.user.order-list', [
            'orders' => $orders
        ]);
    }
}
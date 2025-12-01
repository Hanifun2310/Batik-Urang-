<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

#[Layout('components.layouts.app')]
class CheckoutSuccess extends Component
{
    use WithFileUploads;

    public Order $order;
    public string $whatsappLink = '';
    public array $paymentInstructions = [];

    // Untuk upload bukti bayar
    public $paymentProofFile;
    public $uploading = false;
    public $successMessage = '';

    public function mount(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(404);
        }

        $order->load('items.product'); // Load relasi item & produk
        $this->order = $order;

        // WhatsApp
        $message = $this->generateWhatsAppMessage();
        $this->whatsappLink = 'https://wa.me/6282151636638?text=' . rawurlencode($message);

        // Instruksi bank
        $this->paymentInstructions = [
            'Bank' => 'BCA',
            'No. Rekening' => '123-456-7890',
            'Atas Nama' => 'Batik Urang Store',
            'Total' => 'Rp ' . number_format($this->order->total_amount, 0, ',', '.')
        ];
    }

    private function generateWhatsAppMessage(): string
    {
        $itemText = "";
        foreach ($this->order->items as $item) {
            $itemText .= "- {$item->product_name} (Qty: {$item->quantity})\n";
        }

        return "Halo Admin Batik Urang,\n\n"
            . "Saya ingin melakukan pembayaran untuk pesanan via Midtrans.\n\n"
            . "Detail pesanan saya:\n"
            . "ID Pesanan: {$this->order->id}\n"
            . "Nama: {$this->order->recipient_name}\n"
            . "No HP: {$this->order->phone_number}\n"
            . "Alamat: {$this->order->shipping_address}\n"
            . "Total: Rp " . number_format($this->order->total_amount, 0, ',', '.') . "\n"
            . "Item Pesanan:\n{$itemText}\n"
            . "Mohon kirimkan link pembayaran Midtrans.\nTerima kasih 🙏";
    }

    public function showUploadForm()
    {
        $this->uploading = true;
        $this->paymentProofFile = null;
        $this->successMessage = '';
    }

    public function savePaymentProof()
    {
        $this->validate([
            'paymentProofFile' => 'required|image|max:2048'
        ]);

        // Hapus file lama
        if ($this->order->payment_proof_path && Storage::disk('public')->exists($this->order->payment_proof_path)) {
            Storage::disk('public')->delete($this->order->payment_proof_path);
        }

        $path = $this->paymentProofFile->store('payment-proofs', 'public');

        $this->order->update([
            'payment_proof_path' => $path,
            'status' => 'verifying'
        ]);

        $this->successMessage = 'Bukti bayar berhasil diupload! Admin akan memverifikasi.';
        $this->uploading = false;
        $this->paymentProofFile = null;
    }

    public function render()
    {
        return view('livewire.checkout-success');
    }
}

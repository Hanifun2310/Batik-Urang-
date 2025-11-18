<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\CartItem; 
use Illuminate\Support\Facades\Auth; 


#[Layout('components.layouts.app')]
class Cart extends Component
{
    // Properti untuk pesan
    public ?string $message = null; 

    // saat event 'cart-updated' dipanggil dari komponen lain
    protected $listeners = ['cart-updated' => '$refresh'];

    /**
     * Method untuk menghapus item dari DATABASE
     */
    public function remove($cartItemId) // Terima ID CartItem, bukan ProductId
    {
        // Cari item di database milik user yang login
        $item = CartItem::where('id', $cartItemId)
                        ->where('user_id', Auth::id())
                        ->first();

        if ($item) {
            $item->delete(); 
            $this->message = 'Produk berhasil dihapus dari keranjang.';
            $this->dispatch('cart-updated'); 
        } else {
            $this->message = 'Produk tidak ditemukan di keranjang.';
        }
    }

    /**
     * Method untuk mengupdate kuantitas di DATABASE
     */
    public function updateQuantity($cartItemId, $newQuantity)
    {
        $newQuantity = (int) $newQuantity;

        if ($newQuantity < 1) {
            $this->remove($cartItemId);
            return;
        }

        // Cari item di database
        $item = CartItem::where('id', $cartItemId)
                        ->where('user_id', Auth::id())
                        ->first();

        if ($item) {
            $item->quantity = $newQuantity;
            $item->save(); //
            $this->message = 'Kuantitas produk berhasil diperbarui.';
            // Tidak perlu emit 'cart-updated' karena jumlah item unik tidak berubah
        } else {
             $this->message = 'Produk tidak ditemukan di keranjang.';
        }
    }

    /**
     * 
     * Mengambil data dari DATABASE, bukan SESSION
     */
    public function render()
    {
        $cartItems = [];
        $total = 0;

        // Pastikan user sudah login
        if (Auth::check()) {
            // Ambil item keranjang milik user yang login
            $cartItems = CartItem::where('user_id', Auth::id())
                                 ->with('product') 
                                 ->get();
            
            // Hitung total harga
            foreach ($cartItems as $item) {
                // Pastikan produk masih ada (tidak terhapus)
                if ($item->product) { 
                    $total += $item->product->price * $item->quantity;
                }
            }
        }

        // Kirim data ke view
        return view('livewire.cart', [
            'cartItems' => $cartItems,
            'total' => $total
        ]);
    }
}
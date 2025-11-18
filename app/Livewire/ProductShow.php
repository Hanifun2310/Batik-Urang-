<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Product;
use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;


#[Layout('components.layouts.app')]
class ProductShow extends Component
{
    public Product $product;
    public $message = null;
    public $quantity = 1;

    public function mount(Product $product)
    {
        $this->product = $product;
    }

    public function addToCart()
    {
        // 1. Pastikan user sudah login
        if (!Auth::check()) {
            return $this->redirectRoute('login', navigate: true);
        }

        // --- CEK STOK ---
        if ($this->product->stock_quantity <= 0) {
            session()->flash('error', 'Maaf, stok produk ini telah habis.');
            return;
        }

        // 2. Validasi kuantitas
        $validated = $this->validate([
            'quantity' => 'required|integer|min:1'
        ]);
        
        // Cek apakah kuantitas yang diminta melebihi stok
        if ($this->product->stock_quantity < $validated['quantity']) {
            session()->flash('error', "Stok tidak mencukupi (tersisa: {$this->product->stock_quantity}).");
            return;
        }
        
        // --- 3. LOGIKA TAMBAH/UPDATE STOK (DENGAN DB TRANSACTION) ---
        try {

            // Cek item di keranjang
            $existingCartItem = CartItem::where('user_id', Auth::id())
                                        ->where('product_id', $this->product->id)
                                        ->first();

            if ($existingCartItem) {
                $existingCartItem->quantity += $validated['quantity'];
                $existingCartItem->save();
            } else {
                CartItem::create([
                    'user_id' => Auth::id(),
                    'product_id' => $this->product->id,
                    'quantity' => $validated['quantity'],
                ]);
            }


            // --- 5. KIRIM PESAN SUKSES ---
            $this->dispatch('cart-updated');
            session()->flash('message', 'Produk berhasil ditambahkan ke keranjang!');
            $this->quantity = 1;
            
            // Refresh data produk (stok) di halaman
            $this->product->refresh(); 

        } catch (\Exception $e) {
            session()->flash('error', 'Terjadi kesalahan saat menambahkan ke keranjang. Silakan coba lagi.');
        }
    }

    public function render()
    {
        return view('livewire.product-show');
    }
}
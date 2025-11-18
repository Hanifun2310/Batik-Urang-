<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;
use App\Models\CartItem; 
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

#[Layout('components.layouts.app')]
class Checkout extends Component
{
    // Properti untuk Form (HARUS SAMA DENGAN PROFILE.PHP)
    public $cartItems;
    public float $total = 0;
    public string $name = '';
    public string $email = '';
    public string $phone_number = '';
    public string $address = '';

    /**
     * Mount: Dipanggil saat komponen dimuat.
     */
    public function mount()
    {
        $this->cartItems = CartItem::where('user_id', Auth::id())
                                ->with('product')
                                ->get();

        if ($this->cartItems->isEmpty()) {
            session()->flash('error', 'Keranjang Anda kosong. Silakan belanja dulu.');
            return $this->redirectRoute('cart.index', navigate: true);
        }

        $this->calculateTotal();

        // [PERBAIKAN] Mengisi form dari data Auth::user()
        $user = Auth::user();
        $this->name = $user->name ?? '';
        $this->email = $user->email ?? '';
        $this->phone_number = $user->phone_number ?? '';
        $this->address = $user->address ?? ''; 
    }

    public function calculateTotal()
    {
        $this->total = 0;
        foreach ($this->cartItems as $item) {
            if ($item->product) {
                $this->total += $item->product->price * $item->quantity;
            }
        }
    }

    /**
     * [DIKEMBALIKAN] Logika 'placeOrder' manual
     */
    public function placeOrder()
    {
        // 1. Validasi data (Menggunakan properti yang sudah disamakan)
        $validated = $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
        'phone_number' => 'required|string|max:20', // Diubah dari max:15
        'address' => 'required|string|max:1000',
        ]);

        $cartItems = CartItem::where('user_id', Auth::id())->with('product')->get();
        if ($cartItems->isEmpty()) {
            $this->dispatch('show-error-alert', 'Keranjang Anda kosong.');
            return;
        }

        $totalAmount = 0;
        foreach ($cartItems as $item) {
            if (!$item->product) {
                $this->dispatch('show-error-alert', "Produk (ID: {$item->product_id}) tidak ditemukan.");
                return;
            }
            if ($item->product->stock_quantity < $item->quantity) {
                $this->dispatch('show-error-alert', "Stok '{$item->product->name}' tersisa {$item->product->stock_quantity}.");
                return;
            }
            $totalAmount += $item->product->price * $item->quantity;
        }
        
        try {
            DB::beginTransaction();

            // 4. Simpan Order (Menggunakan properti yang sudah disamakan)
            $order = Order::create([
                'user_id'            => Auth::id(),
                'recipient_name'     => $this->name, // Menggunakan $name
                'phone_number'       => $this->phone_number,
                'shipping_address'   => $this->address, // Menggunakan $address
                'total_amount'       => $totalAmount,
                'payment_method'     => 'Transfer Bank Manual', 
                'status'             => 'pending',
                'payment_proof_path' => null,
            ]);

            // 5. Simpan Order Items & Kurangi Stok
            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id'          => $order->id,
                    'product_id'        => $item->product_id,
                    'product_name'      => $item->product->name,
                    'quantity'          => $item->quantity,
                    'price_at_purchase' => $item->product->price,
                ]);
                $item->product->decrement('stock_quantity', $item->quantity);
            }

            // 6. Hapus Keranjang
            CartItem::where('user_id', Auth::id())->delete();
            $this->dispatch('cart-updated'); 

            DB::commit();
            
            return redirect()->route('success.checkout', ['order' => $order->id]);

        } catch (\Exception $e) {
            DB::rollBack();
            $this->dispatch('show-error-alert', 'Transaksi Gagal: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.checkout');
    }
}
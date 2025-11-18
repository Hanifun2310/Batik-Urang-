<div> {{-- Elemen root wajib --}}
    @section('title', 'Keranjang Belanja')

    <main class="max-w-4xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-amber-900 mb-8">Keranjang Belanja Anda</h1>

        {{-- Menampilkan pesan sukses/error Livewire --}}
        @if ($message)
            <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative"
                role="alert">
                <span class="block sm:inline">{{ $message }}</span>
            </div>
        @endif

        {{-- Menampilkan error session (jika ada, misal dari redirect) --}}
        @if (session('error'))
            <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif

        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            {{--  Gunakan ->isEmpty() untuk collection --}}
            @if (!$cartItems->isEmpty())
                <table class="w-full text-sm text-left text-gray-500">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3">Produk</th>
                            <th scope="col" class="px-6 py-3">Harga</th>
                            <th scope="col" class="px-6 py-3">Jumlah</th>
                            <th scope="col" class="px-6 py-3">Subtotal</th>
                            <th scope="col" class="px-6 py-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- Looping data dari database --}}
                        @foreach ($cartItems as $item)
                            {{-- Pastikan produk terkait masih ada --}}
                            @if ($item->product)
                                <tr class="bg-white border-b hover:bg-gray-50">
                                    <th scope="row"
                                        class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap flex items-center">
                                        <img src="{{ $item->product->main_image_url ?? 'https://via.placeholder.com/50x50.png?text=N/A' }}"
                                            alt="{{ $item->product->name }}"
                                            class="w-12 h-12 object-cover mr-4 rounded">
                                        {{ $item->product->name }}
                                    </th>
                                    <td class="px-6 py-4">
                                        Rp {{ number_format($item->product->price, 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{-- Input Kuantitas Livewire  id CartItem --}}
                                        <input type="number"
                                            wire:model.live.debounce.500ms="cartItems.{{ $loop->index }}.quantity"
                                            {{-- Update properti langsung --}}
                                            wire:change="updateQuantity({{ $item->id }}, $event.target.value)"
                                            {{-- Panggil method update --}} value="{{ $item->quantity }}" min="1"
                                            class="w-16 border border-gray-300 rounded px-2 py-1 text-center">
                                    </td>
                                    <td class="px-6 py-4">
                                        {{-- Hitung subtotal --}}
                                        Rp {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{-- Tombol Hapus  memakai id CartItem --}}
                                        <button wire:click="remove({{ $item->id }})"
                                            class="font-medium text-red-600 hover:underline">Hapus</button>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="font-semibold text-gray-900">
                            <th scope="row" colspan="3" class="px-6 py-3 text-base text-right">Total Belanja</th>
                            {{--  Ambil total dari properti Controller --}}
                            <td class="px-6 py-3 text-base">Rp {{ number_format($total, 0, ',', '.') }}</td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>

                <div class="p-6 text-right border-t">
                    <a href="{{ route('products.index') }}" wire:navigate
                        class="text-amber-700 hover:text-amber-800 font-medium mr-4">Lanjut Belanja</a>
                    <a href="{{ route('checkout') }}" wire:navigate
                        class="bg-amber-600 hover:bg-amber-700 text-white font-bold py-2 px-6 rounded transition">
                        Lanjut ke Checkout
                    </a>
                </div>
            @else
                {{-- Jika keranjang kosong --}}
                <div class="p-12 text-center">
                    <p class="text-gray-500 text-lg">Keranjang belanja Anda masih kosong.</p>
                    <a href="{{ route('products.index') }}" wire:navigate
                        class="mt-4 inline-block bg-amber-600 hover:bg-amber-700 text-white font-bold py-2 px-6 rounded transition">
                        Mulai Belanja
                    </a>
                </div>
            @endif
        </div>

    </main>
</div>

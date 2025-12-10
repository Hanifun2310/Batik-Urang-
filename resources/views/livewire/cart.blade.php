<div>
    @section('title', 'Keranjang Belanja')

    <main class="max-w-6xl mx-auto py-8 sm:py-12 px-4 sm:px-6 lg:px-8">
        <h1 class="text-2xl sm:text-3xl font-bold text-amber-900 mb-6 sm:mb-8">Keranjang Belanja Anda</h1>


        @if ($message)
            <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative"
                role="alert">
                <span class="block sm:inline">{{ $message }}</span>
            </div>
        @endif


        @if (session('error'))
            <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif

        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            @if (!$cartItems->isEmpty())
                {{-- Desktop Table View --}}
                <div class="hidden md:block overflow-x-auto">
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
                            @foreach ($cartItems as $item)
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

                                            <input type="number"
                                                wire:model.live.debounce.500ms="cartItems.{{ $loop->index }}.quantity"

                                                wire:change="updateQuantity({{ $item->id }}, $event.target.value)"
                                                value="{{ $item->quantity }}" min="1"
                                                class="w-16 border border-gray-300 rounded px-2 py-1 text-center">
                                        </td>
                                        <td class="px-6 py-4">
                                            Rp {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}
                                        </td>
                                        <td class="px-6 py-4">
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

                                <td class="px-6 py-3 text-base">Rp {{ number_format($total, 0, ',', '.') }}</td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                {{-- Mobile Card View --}}
                <div class="md:hidden divide-y divide-gray-200">
                    @foreach ($cartItems as $item)
                        @if ($item->product)
                            <div class="p-4 space-y-3">
                                <div class="flex items-start space-x-4">
                                    <img src="{{ $item->product->main_image_url ?? 'https://via.placeholder.com/80x80.png?text=N/A' }}"
                                        alt="{{ $item->product->name }}"
                                        class="w-20 h-20 object-cover rounded">
                                    <div class="flex-grow">
                                        <h3 class="font-semibold text-gray-900 mb-1">{{ $item->product->name }}</h3>
                                        <p class="text-sm text-gray-600 mb-2">
                                            Rp {{ number_format($item->product->price, 0, ',', '.') }}
                                        </p>
                                        <div class="flex items-center space-x-2">
                                            <label class="text-sm text-gray-600">Jumlah:</label>
                                            <input type="number"
                                                wire:model.live.debounce.500ms="cartItems.{{ $loop->index }}.quantity"
                                                wire:change="updateQuantity({{ $item->id }}, $event.target.value)"
                                                value="{{ $item->quantity }}" min="1"
                                                class="w-16 border border-gray-300 rounded px-2 py-1 text-center text-sm">
                                        </div>
                                    </div>
                                </div>
                                <div class="flex items-center justify-between pt-2 border-t border-gray-100">
                                    <span class="font-semibold text-gray-900">
                                        Rp {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}
                                    </span>
                                    <button wire:click="remove({{ $item->id }})"
                                        class="text-sm font-medium text-red-600 hover:text-red-800">
                                        Hapus
                                    </button>
                                </div>
                            </div>
                        @endif
                    @endforeach
                    
                    {{-- Mobile Total --}}
                    <div class="p-4 bg-gray-50">
                        <div class="flex items-center justify-between">
                            <span class="font-semibold text-gray-900 text-lg">Total Belanja</span>
                            <span class="font-bold text-amber-900 text-lg">Rp {{ number_format($total, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>

                <div class="p-4 sm:p-6 text-center sm:text-right border-t bg-gray-50">
                    <a href="{{ route('products.index') }}" wire:navigate
                        class="inline-block text-amber-700 hover:text-amber-800 font-medium mb-3 sm:mb-0 sm:mr-4">
                        Lanjut Belanja
                    </a>
                    <a href="{{ route('checkout') }}" wire:navigate
                        class="inline-block bg-amber-600 hover:bg-amber-700 text-white font-bold py-2 px-6 rounded transition shadow-md">
                        Lanjut ke Checkout
                    </a>
                </div>
            @else
                {{-- Jika keranjang kosong --}}
                <div class="p-8 sm:p-12 text-center">
                    <svg class="mx-auto h-16 w-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                    <p class="text-gray-500 text-lg mb-6">Keranjang belanja Anda masih kosong.</p>
                    <a href="{{ route('products.index') }}" wire:navigate
                        class="inline-block bg-amber-600 hover:bg-amber-700 text-white font-bold py-3 px-8 rounded-lg transition shadow-md">
                        Mulai Belanja
                    </a>
                </div>
            @endif
        </div>

    </main>
</div>

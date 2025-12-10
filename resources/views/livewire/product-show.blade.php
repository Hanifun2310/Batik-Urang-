<div> {{-- Elemen root wajib --}}

    {{-- Set Judul Halaman Dinamis --}}
    @section('title', $product->name . ' - Batik Urang')

    <main class="max-w-5xl mx-auto py-8 sm:py-12 px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-lg shadow-xl overflow-hidden">
            <div class="lg:flex">
                <div class="lg:flex-shrink-0">

                    <img class="h-72 w-full object-cover lg:h-full lg:w-96"
                        src="{{ $product->main_image_url ? asset('storage/' . $product->main_image_url) : 'https://via.placeholder.com/400x300.png?text=No+Image' }}"
                        alt="{{ $product->name }}">
                </div>

                <div class="p-6 sm:p-8 grow">
                    <h1 class="text-2xl sm:text-3xl font-bold text-amber-900 mb-3 sm:mb-4">{{ $product->name }}</h1>
                    <p class="text-xl sm:text-2xl font-semibold text-gray-800 mb-4 sm:mb-6">
                        Rp {{ number_format($product->price, 0, ',', '.') }}
                    </p>

                    @if (session('message'))
                        <div
                            class="mb-4 text-green-700 font-semibold border border-green-300 bg-green-50 px-4 py-3 rounded">
                            {{ session('message') }}
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="mb-4 text-red-700 font-semibold border border-red-300 bg-red-50 px-4 py-3 rounded">
                            {{ session('error') }}
                        </div>
                    @endif


                    <!-- Stock Info -->
                    <div class="text-sm text-gray-600 mb-6 pb-4 border-b">
                        <span class="font-medium">Stok Tersedia:</span>
                        <span
                            class="font-semibold ml-2 @if ($product->stock_quantity <= 0) text-red-600 @else text-green-600 @endif">
                            {{ $product->stock_quantity }}
                        </span>
                    </div>

                    <div class="space-y-6">
                        <form wire:submit="addToCart" class="space-y-4">

                            @if ($product->stock_quantity > 0)
                                <div class="flex items-center space-x-3">
                                    <label for="quantity" class="font-semibold text-gray-700">Jumlah:</label>
                                    <input type="number" id="quantity" wire:model.live="quantity" min="1"
                                        max="{{ $product->stock_quantity }}"
                                        class="w-20 border border-gray-300 rounded-md shadow-sm text-center py-2 px-3 focus:ring-amber-500 focus:border-amber-500">
                                </div>

                                @error('quantity')
                                    <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                                @enderror

                                <button type="submit"
                                    class="w-full bg-amber-600 hover:bg-amber-700 text-white font-bold py-3 px-6 rounded-lg transition text-base sm:text-lg shadow-md"
                                    wire:loading.attr="disabled" wire:loading.class="opacity-75 cursor-not-allowed">
                                    <span wire:loading.remove wire:target="addToCart">Tambah ke Keranjang</span>
                                    <span wire:loading wire:target="addToCart">Memproses...</span>
                                </button>
                            @else

                                <button type="button"
                                    class="w-full bg-gray-400 text-gray-800 font-bold py-3 px-6 rounded-lg opacity-75 cursor-not-allowed"
                                    disabled>
                                    Stok Habis
                                </button>
                            @endif


                        </form>

                        <div class="text-gray-700 leading-relaxed border-t pt-6">
                            <h2 class="text-base sm:text-lg font-semibold mb-3 text-gray-800">Deskripsi Produk</h2>
                            <p class="whitespace-pre-wrap text-sm sm:text-base">{{ $product->description ?? 'Deskripsi produk belum tersedia.' }}
                            </p>
                        </div>

                        @if ($product->size_chart_note)
                            <div class="text-gray-700 leading-relaxed border-t pt-6">
                                <h2 class="text-base sm:text-lg font-semibold mb-3 text-gray-800">Informasi Ukuran</h2>
                                <p class="text-sm whitespace-pre-wrap">{{ $product->size_chart_note }}</p>
                            </div>
                        @endif
                    </div>

                </div>
            </div>
        </div>

        <div class="mt-8 text-center">
            <a href="{{ route('products.index') }}" wire:navigate
                class="text-amber-700 hover:text-amber-800 font-semibold inline-flex items-center gap-2 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali ke Katalog
            </a>
        </div>

    </main>
</div>

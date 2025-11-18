<div> {{-- Elemen root wajib --}}

    {{-- Set Judul Halaman Dinamis --}}
    @section('title', $product->name . ' - Batik Urang')

    <main class="max-w-4xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-lg shadow-xl overflow-hidden">
            <div class="md:flex">
                <div class="md:flex-shrink-0">
                    <!-- [PERBAIKAN FOTO] Menggunakan asset('storage/...') -->
                    <img class="h-64 w-full object-cover md:h-full md:w-80"
                        src="{{ $product->main_image_url ? asset('storage/' . $product->main_image_url) : 'https://via.placeholder.com/400x300.png?text=No+Image' }}"
                        alt="{{ $product->name }}">
                </div>

                <div class="p-8 flex-grow">
                    <h1 class="text-3xl font-bold text-amber-900 mb-4">{{ $product->name }}</h1>
                    <p class="text-2xl font-semibold text-gray-800 mb-6">
                        Rp {{ number_format($product->price, 0, ',', '.') }}
                    </p>

                    <!-- [PERBAIKAN NOTIFIKASI] Tampilkan Notifikasi (Sukses & Error) -->
                    @if (session('message'))
                        <div
                            class="mb-4 text-green-700 font-semibold border border-green-300 bg-green-50 px-4 py-2 rounded">
                            {{ session('message') }}
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="mb-4 text-red-700 font-semibold border border-red-300 bg-red-50 px-4 py-2 rounded">
                            {{ session('error') }}
                        </div>
                    @endif
                    <!-- [AKHIR PERBAIKAN NOTIFIKASI] -->


                    <div class="mt-8">
                        <form wire:submit="addToCart">

                            <!-- [PERBAIKAN TOMBOL] Logika Tampilan Tombol Berdasarkan Stok -->
                            @if ($product->stock_quantity > 0)
                                <!-- JIKA STOK ADA: Tampilkan Input Kuantitas & Tombol Beli -->
                                <div class="mb-4 flex items-center space-x-3">
                                    <label for="quantity" class="font-semibold text-gray-700">Jumlah:</label>
                                    <!-- [PERBAIKAN KODE RUSAK] Komentar dipindahkan ke LUAR tag input -->
                                    <input type="number" id="quantity" wire:model.live="quantity" min="1"
                                        max="{{ $product->stock_quantity }}"
                                        class="w-20 border border-gray-300 rounded-md shadow-sm text-center py-2 px-3">
                                    <!-- Komentar yang benar ada di sini -->
                                </div>

                                @error('quantity')
                                    <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                                @enderror

                                <button type="submit"
                                    class="w-full bg-amber-600 hover:bg-amber-700 text-white font-bold py-3 px-6 rounded-lg transition text-lg"
                                    wire:loading.attr="disabled" wire:loading.class="opacity-75 cursor-not-allowed">
                                    <span wire:loading.remove wire:target="addToCart">Tambah ke Keranjang</span>
                                    <span wire:loading wire:target="addToCart">Memproses...</span>
                                </button>
                            @else
                                <!-- JIKA STOK HABIS: Tampilkan Tombol Disabled -->
                                <button type="button"
                                    class="w-full bg-gray-400 text-gray-800 font-bold py-3 px-6 rounded-lg opacity-75 cursor-not-allowed"
                                    disabled>
                                    Stok Habis
                                </button>
                            @endif
                            <!-- [AKHIR PERBAIKAN TOMBOL] -->

                        </form>
                    </div>

                    <div class="text-sm text-gray-600 mb-6 border-t pt-4 mt-8">
                        <!-- [PERBAIKAN STOK] Beri warna pada stok -->
                        Stok Tersedia:
                        <span
                            class="font-semibold @if ($product->stock_quantity <= 0) text-red-600 @else text-green-600 @endif">
                            {{ $product->stock_quantity }}
                        </span>
                    </div>

                    <div class="text-gray-700 leading-relaxed mb-6">
                        <h2 class="text-lg font-semibold mb-2 text-gray-800">Deskripsi Produk</h2>
                        <p class="whitespace-pre-wrap">{{ $product->description ?? 'Deskripsi produk belum tersedia.' }}
                        </p>
                    </div>

                    @if ($product->size_chart_note)
                        <div class="text-gray-700 leading-relaxed mb-6 border-t pt-4 mt-4">
                            <h2 class="text-lg font-semibold mb-2 text-gray-800">Informasi Ukuran</h2>
                            <p class="text-sm whitespace-pre-wrap">{{ $product->size_chart_note }}</p>
                        </div>
                    @endif

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

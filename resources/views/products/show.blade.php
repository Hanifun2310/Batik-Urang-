<x-layouts.app> {{-- Gunakan Layout Utama --}}
    @section('title', $product->name . ' - Batik Urang') {{-- Set Judul Halaman Dinamis --}}

    <main class="max-w-4xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-lg shadow-xl overflow-hidden">
            <div class="md:flex">
                <div class="md:flex-shrink-0">
                    <img class="h-64 w-full object-cover md:h-full md:w-80"
                         src="{{ $product->main_image_url ?? 'https://via.placeholder.com/400x300.png?text=No+Image' }}"
                         alt="{{ $product->name }}">
                </div>

                <div class="p-8 flex-grow">
                    <h1 class="text-3xl font-bold text-amber-900 mb-4">{{ $product->name }}</h1>
                    <p class="text-2xl font-semibold text-gray-800 mb-6">
                        Rp {{ number_format($product->price, 0, ',', '.') }}
                    </p>
                    <div class="text-gray-700 leading-relaxed mb-6">
                        <h2 class="text-lg font-semibold mb-2 text-gray-800">Deskripsi Produk</h2>
                        <p class="whitespace-pre-wrap">{{ $product->description ?? 'Deskripsi produk belum tersedia.' }}</p>
                    </div>
                    @if($product->size_chart_note)
                        <div class="text-gray-700 leading-relaxed mb-6 border-t pt-4 mt-4">
                             <h2 class="text-lg font-semibold mb-2 text-gray-800">Informasi Ukuran</h2>
                            <p class="text-sm whitespace-pre-wrap">{{ $product->size_chart_note }}</p>
                        </div>
                    @endif
                     <div class="text-sm text-gray-600 mb-6 border-t pt-4 mt-4">
                        Stok Tersedia: <span class="font-semibold">{{ $product->stock_quantity }}</span>
                    </div>

                    <div class="mt-8">
                        {{-- Pastikan route 'cart.add' sudah ada di web.php --}}
                         <form action="{{ route('cart.add', $product->id) }}" method="POST">
                            @csrf
                            <button type="submit"
                                class="w-full bg-amber-600 hover:bg-amber-700 text-white font-bold py-3 px-6 rounded-lg transition text-lg">
                                Tambah ke Keranjang
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

         <div class="mt-8 text-center">
            <a href="{{ route('products.index') }}" wire:navigate class="text-amber-700 hover:text-amber-800 font-semibold inline-flex items-center gap-2 transition-colors">
                 <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Kembali ke Katalog
            </a>
        </div>
    </main>
</x-layouts.app> {{-- Penutup Layout Utama --}}
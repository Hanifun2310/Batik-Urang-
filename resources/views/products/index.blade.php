<x-layouts.app> {{-- Gunakan Layout Utama --}}
    @section('title', 'Katalog Produk - Batik Urang') {{-- Set Judul Halaman --}}

    <main class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        {{-- Judul Halaman Dinamis --}}
        @isset($searchTerm)
            <h1 class="text-3xl font-bold text-amber-900 mb-6"> Hasil Pencarian untuk: "<span class="italic">{{ $searchTerm }}</span>" </h1>
        @else
            <h1 class="text-3xl font-bold text-amber-900 mb-2">Katalog Produk</h1>
        @endisset

        {{-- Tombol Kembali --}}
        @auth
            <div class="mb-6">
                <a href="#" onclick="window.history.back(); return false;" class="text-sm text-amber-700 hover:text-amber-800 font-semibold inline-flex items-center gap-1 group">
                    <svg class="w-4 h-4 transition-transform duration-200 group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Kembali ke Halaman Sebelumnya
                </a>
            </div>
        @endauth

        {{-- Filter Kategori --}}
        <div class="mb-8 p-4 bg-white rounded-lg shadow">
            <h3 class="font-semibold text-gray-700 mb-3">Filter Berdasarkan Kategori:</h3>
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('products.index') }}"
                   class="px-3 py-1 rounded-full text-sm transition {{ !request('kategori') ? 'bg-amber-600 text-white shadow' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                   Semua
                </a>
                @foreach ($categories as $category)
                    <a href="{{ route('products.index', ['kategori' => $category->slug]) }}"
                       class="px-3 py-1 rounded-full text-sm transition {{ request('kategori') == $category->slug ? 'bg-amber-600 text-white shadow' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                       {{ $category->name }}
                    </a>
                @endforeach
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @forelse ($products as $product)
                <div class="bg-white rounded-lg overflow-hidden shadow-lg hover:shadow-xl transition flex flex-col">
                    {{-- ... (Konten Kartu Produk Sama Seperti Sebelumnya) ... --}}
                     <a href="{{ route('products.show', $product->id) }}" wire:navigate class="block">
                         <img src="{{ $product->main_image_url ?? 'https://via.placeholder.com/400x300.png?text=No+Image' }}" alt="{{ $product->name }}" class="w-full h-48 object-cover">
                    </a>
                    <div class="p-4 flex flex-col flex-grow">
                        <h3 class="font-bold text-amber-900 text-lg mb-2 flex-grow"> {{ $product->name }} </h3>
                        <p class="text-gray-700 text-md font-semibold mb-2"> Rp {{ number_format($product->price, 0, ',', '.') }} </p>
                        <p class="text-gray-600 text-sm mb-4 line-clamp-2"> {{ $product->description ?? 'Deskripsi belum tersedia.' }} </p>
                        @if($product->size_chart_note)
                            <div class="mt-2 pt-2 border-t border-gray-100">
                                <p class="text-xs text-gray-500 font-medium mb-1">Info Ukuran:</p>
                                <p class="text-xs text-gray-600 whitespace-pre-wrap">{{ $product->size_chart_note }}</p>
                            </div>
                        @endif
                        <div class="mt-auto pt-4 border-t border-gray-100">
                            <a href="{{ route('products.show', ['product' => $product->id]) }}" wire:navigate
                               class="block w-full text-center bg-amber-600 hover:bg-amber-700 text-white font-bold py-2 px-4 rounded transition">
                                Lihat Detail
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <p class="col-span-full text-center text-gray-500"> Belum ada produk yang cocok ditemukan. </p> {{-- Pesan disesuaikan --}}
            @endforelse
        </div>

        {{-- Link Pagination --}}
        <div class="mt-8">
            {{ $products->appends(request()->query())->links() }}
        </div>
    </main>
</x-layouts.app> {{-- Penutup Layout Utama --}}
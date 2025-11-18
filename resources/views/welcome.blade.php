<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<x-layouts.app> 
    {{-- Set judul spesifik untuk halaman ini --}}
    @section('title', 'Batik Urang - Beranda') 

    {{-- homepage --}}

    <section class="bg-gradient-to-r from-amber-900 to-amber-700 text-white py-12 sm:py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="text-3xl sm:text-5xl font-bold mb-4">Batik</h1>
                <p class="text-lg sm:text-xl text-amber-100 mb-8">Warisan Budaya Dunia yang Membanggakan</p>
                <p class="text-sm sm:text-base text-amber-50 max-w-2xl mx-auto">Dapatkan keindahan dan makna mendalam di balik setiap motif batik di Website kami</p>
            </div>
        </div>
    </section>

    <section class="py-12 sm:py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-2xl sm:text-4xl font-bold text-amber-900 mb-4 text-center">Koleksi Terbaru</h2>
            <p class="text-center text-gray-600 mb-12">Produk batik pilihan terbaru kami</p>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

                {{-- Looping data $products dari route --}}
                @forelse ($products as $product)
                    <div class="bg-white rounded-lg overflow-hidden shadow-lg hover:shadow-xl transition flex flex-col">
                        <a href="{{ route('products.show', $product->id) }}" wire:navigate class="block">

                            <!-- [FIX GAMBAR] Menggunakan asset('storage/...') -->
                            <img src="{{ $product->main_image_url ? asset('storage/' . $product->main_image_url) : 'https://via.placeholder.com/400x300.png?text=No+Image' }}" 
                                alt="{{ $product->name }}" 
                                class="w-full h-64 object-cover">
                        </a>
                        <div class="p-4 flex flex-col flex-grow">
                            <h3 class="font-bold text-amber-900 text-lg mb-2 flex-grow">
                                <a href="{{ route('products.show', $product->id) }}" wire:navigate class="hover:underline">
                                    {{ $product->name }}
                                </a>
                            </h3>
                            <p class="text-gray-700 text-md font-semibold mb-4">
                                Rp {{ number_format($product->price, 0, ',', '.') }} 
                            </p>
                            <div class="mt-auto pt-4 border-t border-gray-100"> 
                                <a href="{{ route('products.show', $product->id) }}" wire:navigate
                                    class="block w-full text-center bg-amber-600 hover:bg-amber-700 text-white font-bold py-2 px-4 rounded transition">
                                    Lihat Detail
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="col-span-full text-center text-gray-500">
                        Belum ada produk unggulan saat ini.
                    </p>
                @endforelse

            </div> 
            
            {{-- Lihat Semua Produk --}}
            <div class="mt-12 text-center">
                <a href="{{ route('products.index') }}" wire:navigate class="inline-block bg-amber-800 hover:bg-amber-900 text-white font-semibold py-3 px-8 rounded-lg transition shadow-md">
                    Lihat Semua Koleksi
                </a>
            </div>
        </div>
    </section>

    <!-- [BARU] BAGIAN KONTAK (DITERJEMAHKAN KE TAILWIND) -->
    <section id="contact" class="py-12 sm:py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Judul Section -->
            <div class="text-center mb-12">
                <span class="text-amber-600 font-semibold uppercase">Kontak</span>
                <h2 class="text-2xl sm:text-4xl font-bold text-amber-900 mt-2">Hubungi Kami</h2>
                <p class="text-gray-600 max-w-2xl mx-auto mt-4">Kami siap membantu Anda. Silakan hubungi kami melalui detail di bawah ini atau kunjungi lokasi kami.</p>
            </div>

            <div class="max-w-4xl mx-auto bg-gray-50 rounded-lg shadow-xl overflow-hidden">
                <div class="p-6 sm:p-8">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                        <!-- Info Item Alamat -->
                        <div class="flex items-start space-x-4">
                            <div class="flex-shrink-0">
                                <span class="flex items-center justify-center h-12 w-12 rounded-full bg-amber-100 text-amber-700">
                                    <!-- Ikon SVG untuk Peta -->
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                </span>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-amber-900">Alamat</h3>
                                <p class="text-gray-600">F2FQ+R66, Sukanegara, Kec. Jonggol, Kabupaten Bogor, Jawa Barat 16830</p>
                            </div>
                        </div>

                        <!-- Info Item Telepon -->
                        <div class="flex items-start space-x-4">
                            <div class="flex-shrink-0">
                                <span class="flex items-center justify-center h-12 w-12 rounded-full bg-amber-100 text-amber-700">
                                    <!-- Ikon SVG untuk Telepon -->
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                </span>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-amber-900">Telepon</h3>
                                <p class="text-gray-600">+620000000</p>
                            </div>
                        </div>

                        <!-- Info Item Email -->
                        <div class="flex items-start space-x-4">
                            <div class="flex-shrink-0">
                                <span class="flex items-center justify-center h-12 w-12 rounded-full bg-amber-100 text-amber-700">
                                    <!-- Ikon SVG untuk Email -->
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                </span>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-amber-900">Email</h3>
                                <p class="text-gray-600">BatikUrang@gmail.com</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Peta (di luar padding) -->
                <div class="w-full h-64 md:h-80">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m16!1m11!1m3!1d3!2d107.03802113535001!3d-6.5254537675309505!2m2!1f0!2f90!3m2!1i1024!2i768!4f75!3m3!1m2!1s0x2e69bd27c6b9b645%3A0x600dcb86d7b2feb3!2sPoliteknik%20IDN!3m2!1sid!2sid!4v1762991058105!5m2!1sid!2sid" 
                            class="w-full h-full border-0" 
                            allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>
        </div>
    </section>
    <!-- [AKHIR BAGIAN KONTAK] -->

</x-layouts.app>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Batik Urang' }}</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @livewireStyles
</head>

<body class="bg-gray-100">

    <nav class="bg-amber-900 text-white sticky top-0 z-50 shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">

                <div class="flex items-center space-x-4">
                    <a href="/" class="flex items-center space-x-2 flex-shrink-0">
                        <img class="h-10 w-auto" src="{{ asset('images/logo.png') }}" alt="Logo Batik Urang">
                        <span class="font-bold text-lg hidden sm:inline">Batik Urang</span>
                    </a>
                    <div class="hidden md:flex space-x-2">
                        <a href="{{ route('products.index') }}" wire:navigate
                            class="text-amber-100 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Toko</a>
                        <a href="{{ route('articles.index') }}" wire:navigate
                            class="text-amber-100 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Artikel</a>
                    </div>
                </div>

                <div class="flex items-center space-x-3 md:space-x-4">

                    <form action="{{ route('products.index') }}" method="GET" class="hidden md:block">
                        <div class="relative">
                            <input type="text" name="q" placeholder="Cari product..."
                                value="{{ request('q') }}"
                                class="bg-amber-800 text-white placeholder-amber-300 px-3 py-1 rounded-md text-sm focus:outline-none focus:bg-amber-700 w-40 md:w-64">
                            <button type="submit"
                                class="absolute right-2 top-1/2 -translate-y-1/2 text-amber-300 hover:text-white"><svg
                                    class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg></button>
                        </div>
                    </form>


                    @guest
                        {{-- Tampilkan Login & Daftar jika tamu --}}
                        <a href="{{ route('login') }}" wire:navigate
                            class="bg-amber-700 hover:bg-amber-600 px-3 py-1.5 rounded transition text-sm font-medium">Login</a>
                        <a href="{{ route('register') }}" wire:navigate
                            class="bg-amber-500 hover:bg-amber-400 px-3 py-1.5 rounded transition text-sm font-medium">Daftar</a>
                    @else
                        <a href="{{ route('cart.index') }}" wire:navigate
                            class="relative text-amber-100 hover:text-white transition p-1">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z">
                                </path>
                            </svg>
                            @if (session('cart') && count(session('cart')) > 0)
                                <span
                                    class="absolute -top-1 -right-1 inline-flex items-center justify-center px-1.5 py-0.5 text-xs font-bold leading-none text-red-100 bg-red-600 rounded-full">{{ count(session('cart')) }}</span>
                            @endif
                        </a>
                        <a href="{{ route('orders.index') }}" wire:navigate
                            class="relative text-amber-100 hover:text-white transition p-1" title="Pesanan Saya">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002-2h2a2 2 0 002 2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4">
                                </path>
                            </svg>
                        </a>
                        <a href="{{ route('profile') }}" wire:navigate
                            class="text-amber-100 hover:text-white px-2 py-1 rounded-md text-sm font-medium hidden sm:inline">
                            Halo, {{ Auth::user()->name }}
                        </a>

                        <!-- Tautan Khusus Admin -->
                        @if (Auth::user()->role === 'admin')
                            <a href="{{ route('admin.dashboard') }}" wire:navigate
                                class="relative text-amber-100 hover:text-white transition p-1" title="Dashboard Admin">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a2 2 0 002 2h10a2 2 0 002-2V10M9 21h6"></path>
                                </svg>
                            </a>
                        @endif

                        <livewire:navigation.logout-button />
                    @endguest
                </div>
            </div>
        </div>
    </nav>


    {{-- Konten Utama Halaman  --}}
    <main>
        {{ $slot }}
    </main>

    {{-- Footer --}}
    <footer class="bg-amber-900 text-white py-8 mt-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-amber-100 text-sm">
            <p>&copy; {{ date('Y') }} Batik Urang. Semua hak dilindungi.</p>
        </div>
    </footer>

    {{-- Livewire Scripts --}}
    @livewireScripts

    <script>

        // [TETAP ADA] Listener 'show-error-alert' (Untuk error stok/validasi)
        Livewire.on('show-error-alert', (message) => {
            Swal.fire({
                icon: 'error',
                title: 'Oops... Terjadi Kesalahan',
                text: message, // Menampilkan pesan error (string) dari backend
            });
        });
    </script>
</body>

</html>

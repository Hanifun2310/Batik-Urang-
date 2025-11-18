<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Belanja - Batik Urang</title> {{-- Sesuaikan nama jika perlu --}}
    
    {{-- Script Tailwind CDN --}}
    <script src="https://cdn.tailwindcss.com"></script> 

    {{-- Livewire Styles --}}
    @livewireStyles 
</head>
<body class="bg-gray-100">

    {{-- Navbar Lengkap --}}
    <nav class="bg-amber-900 text-white sticky top-0 z-50 shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center space-x-4">
                    <a href="/" class="flex items-center space-x-2 flex-shrink-0">
                        <img class="h-10 w-auto" src="{{ asset('images/logo.png') }}" alt="Logo Batik Urang"> 
                        <span class="font-bold text-lg hidden sm:inline">Batik Urang</span>
                    </a>
                    <div class="hidden md:flex space-x-2">
                        <a href="{{ route('products.index') }}" wire:navigate class="text-amber-100 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Toko</a>
                        <a href="/#bagian-artikel" class="text-amber-100 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Artikel</a>
                    </div>
                </div>
                <div class="flex items-center space-x-3 md:space-x-4"> 
                    <form action="{{ route('products.search') }}" method="GET" class="hidden md:block">
                        <div class="relative">
                            <input type="text" name="q" placeholder="Cari product..." value="{{ request('q') }}" class="bg-amber-800 text-white placeholder-amber-300 px-3 py-1 rounded-md text-sm focus:outline-none focus:bg-amber-700 w-40 md:w-64">
                            <button type="submit" class="absolute right-2 top-1/2 -translate-y-1/2 text-amber-300 hover:text-white"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg></button>
                        </div>
                    </form>
                    <a href="{{ route('cart.index') }}" wire:navigate class="relative text-amber-100 hover:text-white transition p-1"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>@if(session('cart') && count(session('cart')) > 0)<span class="absolute -top-1 -right-1 inline-flex items-center justify-center px-1.5 py-0.5 text-xs font-bold leading-none text-red-100 bg-red-600 rounded-full">{{ count(session('cart')) }}</span>@endif</a>
                    @guest <a href="{{ route('login') }}" wire:navigate class="bg-amber-700 hover:bg-amber-600 px-3 py-1.5 rounded transition text-sm font-medium">Login</a> <a href="{{ route('register') }}" wire:navigate class="bg-amber-500 hover:bg-amber-400 px-3 py-1.5 rounded transition text-sm font-medium">Daftar</a>
                    @else <a href="{{--profile.show --}}#" wire:navigate class="text-amber-100 hover:text-white px-2 py-1 rounded-md text-sm font-medium hidden sm:inline"> Halo, {{ Auth::user()->name }} </a> <livewire:navigation.logout-button />
                    @endguest
                </div>
            </div>
        </div>
    </nav>

    <main class="max-w-4xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-amber-900 mb-8">Keranjang Belanja Anda</h1>

        {{-- menampilkan pesan --}}
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif
        @if (session('error'))
             <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif

        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            @if(!empty($cartItems)) 
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
                        @php $total = 0; @endphp
                        @foreach($cartItems as $id => $item)
                            @php $subtotal = $item['price'] * $item['quantity']; $total += $subtotal; @endphp
                            <tr class="bg-white border-b hover:bg-gray-50">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap flex items-center">
                                    <img src="{{ $item['image'] ?? 'https://via.placeholder.com/50x50.png?text=N/A' }}" alt="{{ $item['name'] }}" class="w-12 h-12 object-cover mr-4 rounded">
                                    {{ $item['name'] }}
                                </th>
                                <td class="px-6 py-4">
                                    Rp {{ number_format($item['price'], 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4">
                                    {{-- update kuantitas --}}
                                    <form action="{{ route('cart.update', $id) }}" method="POST" class="flex items-center">
                                        @csrf
                                        @method('PATCH')
                                        <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" 
                                               class="w-16 border border-gray-300 rounded px-2 py-1 text-center">
                                        <button type="submit" class="ml-2 text-xs bg-blue-500 hover:bg-blue-600 text-white px-2 py-1 rounded">Update</button>
                                    </form>
                                </td>
                                <td class="px-6 py-4">
                                    Rp {{ number_format($subtotal, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4">
                                    {{-- Hapus Item --}}
                                    <form action="{{ route('cart.remove', $id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="font-medium text-red-600 hover:underline">Hapus</button>
                                    </form>
                                </td>
                            </tr>
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

                <div class="p-6 text-right border-t">
                     <a href="{{ route('products.index') }}" wire:navigate class="text-amber-700 hover:text-amber-800 font-medium mr-4">Lanjut Belanja</a>
                     <a href="#" class="bg-amber-600 hover:bg-amber-700 text-white font-bold py-2 px-6 rounded transition">
                         Lanjut ke Checkout
                     </a>
     
                </div>

            @else
                <div class="p-12 text-center">
                    <p class="text-gray-500 text-lg">Keranjang belanja Anda masih kosong.</p>
                    <a href="{{ route('products.index') }}" wire:navigate class="mt-4 inline-block bg-amber-600 hover:bg-amber-700 text-white font-bold py-2 px-6 rounded transition">
                        Mulai Belanja
                    </a>
                </div>
            @endif
        </div>

    </main>

    <footer class="bg-amber-900 text-white py-8 mt-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-amber-100 text-sm">
            <p>&copy; {{ date('Y') }} Batik Urang. Semua hak dilindungi.</p>
        </div>
    </footer>

    {{-- Livewire Scripts --}}
    @livewireScripts 
</body>
</html>
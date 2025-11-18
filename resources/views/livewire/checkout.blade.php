<div> {{-- Elemen root wajib --}}
    @section('title', 'Checkout')

    <main class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-amber-900 mb-8">Checkout Pesanan</h1>

        {{-- Menampilkan error (Seperti Stok Habis dari SweetAlert) --}}
        {{-- Kita sudah menggunakan SweetAlert, tapi ini bisa jadi fallback --}}
        @if (session()->has('error'))
            <div class="bg-red-50 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6" role="alert">
                <strong class="font-bold">Terjadi Kesalahan!</strong>
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif

        {{-- Form utama membungkus kedua kolom --}}
        <!-- 1. Form terhubung ke 'placeOrder' (yang sekarang akan meminta token) -->
        <form wire:submit="placeOrder">
            <div class="lg:grid lg:grid-cols-2 lg:gap-8 xl:gap-12">

                <!-- KOLOM 1: Alamat Pengiriman (Tidak Berubah) -->
                <div class="bg-white rounded-lg shadow-lg p-6 space-y-4">
                    <h2 class="text-2xl font-semibold text-gray-800 border-b pb-3 mb-4">1. Alamat Pengiriman</h2>

                    {{-- Nama Lengkap --}}
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Nama Lengkap
                            Penerima</label>
                        <input type="text" id="name" wire:model.defer="name"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-amber-500 focus:border-amber-500 sm:text-sm">
                        @error('name')
                            <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Email --}}
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Email (untuk
                            notifikasi)</label>
                        <input type="email" id="email" wire:model.defer="email"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-amber-500 focus:border-amber-500 sm:text-sm">
                        @error('email')
                            <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Nomor Handphone --}}
                    <div>
                        <label for="phone_number" class="block text-sm font-medium text-gray-700">No. Handphone</label>
                        <input type="tel" id="phone_number" wire:model.defer="phone_number"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-amber-500 focus:border-amber-500 sm:text-sm"
                            placeholder="Contoh: 08123456789">
                        @error('phone_number')
                            <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Alamat Lengkap --}}
                    <div>
                        <label for="address" class="block text-sm font-medium text-gray-700">Alamat Lengkap
                            Pengiriman</label>
                        <textarea id="address" wire:model.defer="address" rows="4"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-amber-500 focus:border-amber-500 sm:text-sm"
                            placeholder="Masukkan nama jalan, nomor rumah, RT/RW, kelurahan, kecamatan, kota/kabupaten, dan kodepos..."></textarea>
                        @error('address')
                            <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- KOLOM 2: Ringkasan Pesanan (Perbaikan di sini) -->
                <div class="mt-8 lg:mt-0">
                    <div class="bg-white rounded-lg shadow-lg p-6">
                        <h2 class="text-2xl font-semibold text-gray-800 border-b pb-3 mb-4">2. Ringkasan Pesanan</h2>

                        {{-- Daftar Item Keranjang --}}
                        <div class="space-y-4 max-h-64 overflow-y-auto pr-2">
                            <!-- [PERBAIKAN] Menggunakan '$cartItems as $item' (bukan '$id => $item') -->
                            @forelse ($cartItems as $item)
                                {{-- Pastikan produk terkait masih ada --}}
                                @if ($item->product)
                                    <div class="flex items-center space-x-4">

                                        <!-- [PERBAIKAN FOTO] Menggunakan sintaks Objek dan asset('storage/...') -->
                                        <img src="{{ $item->product->main_image_url ? asset('storage/' . $item->product->main_image_url) : 'https://via.placeholder.com/100x100.png?text=N/A' }}"
                                            alt="{{ $item->product->name }}"
                                            class="w-16 h-16 object-cover rounded-md flex-shrink-0">

                                        <div class="flex-grow">
                                            <!-- [PERBAIKAN] Menggunakan sintaks Objek -->
                                            <p class="font-semibold text-gray-900">{{ $item->product->name }}</p>
                                            <p class="text-sm text-gray-500">Jumlah: {{ $item->quantity }}</p>
                                        </div>

                                        <!-- [PERBAIKAN SUBTOTAL] Menggunakan sintaks Objek -->
                                        <p class="text-sm font-medium text-gray-700">
                                            Rp {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}
                                        </p>
                                    </div>
                                @endif
                            @empty
                                <p class="text-gray-500">Keranjang Anda kosong.</p>
                            @endforelse
                        </div>

                        {{-- Detail Total Harga --}}
                        <div class="border-t pt-4 mt-4 space-y-2">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Subtotal</span>
                                <span class="font-medium text-gray-900">Rp
                                    {{ number_format($this->total, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Biaya Pengiriman</span>
                                <span class="font-medium text-gray-900">Gratis</span>
                            </div>
                            <div class="flex justify-between text-lg font-bold text-gray-900 border-t pt-2 mt-2">
                                <span>Total Pembayaran</span>
                                <span>Rp {{ number_format($this->total, 0, ',', '.') }}</span>
                            </div>
                        </div>

                        {{-- Tombol Buat Pesanan --}}
                        <div class="mt-6">
                            <!-- 2. Tombol ini memicu 'placeOrder' -->
                            <button type="submit"
                                class="w-full bg-amber-600 hover:bg-amber-700 text-white font-bold py-3 px-6 rounded-lg transition text-lg shadow-md"
                                wire:loading.attr="disabled" wire:target="placeOrder">
                                <!-- Target loading ke 'placeOrder' -->

                                <span wire:loading.remove wire:target="placeOrder">Bayar Sekarang</span>
                                <span wire:loading wire:target="placeOrder">Memproses...</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>

    </main>
</div>

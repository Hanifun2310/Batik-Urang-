<div>
    @section('title', 'Pesanan Berhasil Dibuat')

    <main class="max-w-4xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-lg shadow-xl overflow-hidden">

            <!-- Header sukses -->
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-6" role="alert">
                <div class="flex">
                    <div class="py-1">
                        <svg class="h-8 w-8 text-green-500 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xl font-bold">Pesanan Anda Telah Diterima!</p>
                        <p class="text-sm">Terima kasih telah berbelanja. Pesanan Anda (ID: **{{ $order->id }}**)
                            sedang menunggu pembayaran.</p>
                    </div>
                </div>
            </div>

            <div class="p-6 sm:p-8">
                <h2 class="text-2xl font-semibold text-amber-900 mb-6">Ringkasan Pesanan</h2>

                <!-- Ringkasan Item -->
                <div class="space-y-4 max-h-64 overflow-y-auto pr-2 border rounded-md p-4 mb-6">
                    @foreach ($order->items as $item)
                        <div class="flex items-center space-x-4">
                            <img src="{{ $item->product->main_image_url ? asset('storage/' . $item->product->main_image_url) : 'https://via.placeholder.com/100x100.png?text=N/A' }}"
                                alt="{{ $item->product_name }}" class="w-16 h-16 object-cover rounded-md flex-shrink-0">

                            <div class="flex-grow">
                                <p class="font-semibold text-gray-900">{{ $item->product_name }}</p>
                                <p class="text-sm text-gray-500">Jumlah: {{ $item->quantity }}</p>
                            </div>

                            <p class="text-sm font-medium text-gray-700">
                                Rp {{ number_format($item->price_at_purchase * $item->quantity, 0, ',', '.') }}
                            </p>
                        </div>
                    @endforeach
                </div>

                <!-- Total -->
                <div class="border-t pt-4 space-y-2 mb-8">
                    <div class="flex justify-between text-lg font-bold text-gray-900 border-b pb-2">
                        <span>Total Pembayaran</span>
                        <span>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                    </div>
                </div>

                <!-- OPSI PEMBAYARAN -->
                <h2 class="text-2xl font-semibold text-amber-900 mb-6">Pilih Metode Pembayaran</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    <!-- Transfer Bank Manual -->
                    <div class="border border-gray-200 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">1. Transfer Bank Manual</h3>
                        <p class="text-sm text-gray-600 mb-4">Silakan transfer ke rekening berikut dan upload bukti
                            bayar di halaman ini.</p>
                        <ul class="space-y-2 text-sm">
                            @foreach ($paymentInstructions as $label => $value)
                                <li>
                                    <span class="text-gray-500">{{ $label }}:</span>
                                    <strong class="text-gray-900 ml-2">{{ $value }}</strong>
                                </li>
                            @endforeach
                        </ul>

                        <!-- Tombol Upload / Lihat Bukti -->
                        @if ($order->payment_proof_path)
                            <a href="{{ Storage::url($order->payment_proof_path) }}" target="_blank"
                                class="mt-6 inline-block w-full text-center bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded transition">
                                Lihat Bukti Bayar
                            </a>
                            <button wire:click="showUploadForm"
                                class="mt-2 inline-block w-full text-center bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded transition">
                                Edit Bukti Bayar
                            </button>
                        @else
                            <button wire:click="showUploadForm"
                                class="mt-6 inline-block w-full text-center bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded transition">
                                Upload Bukti Bayar
                            </button>
                        @endif

                        <!-- Form Upload -->
                        @if ($uploading)
                            <div class="mt-4 p-4 bg-gray-50 rounded-lg border">
                                <form wire:submit.prevent="savePaymentProof">
                                    <label class="block text-sm font-medium text-gray-700">Pilih file bukti
                                        bayar:</label>
                                    <input type="file" wire:model="paymentProofFile"
                                        class="mt-1 block w-full text-sm text-gray-500">

                                    @if ($paymentProofFile)
                                        <div class="mt-2">
                                            <p class="text-sm font-medium text-gray-700">Preview:</p>
                                            <img src="{{ $paymentProofFile->temporaryUrl() }}"
                                                class="mt-1 h-32 w-auto rounded border">
                                        </div>
                                    @endif

                                    @error('paymentProofFile')
                                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                                    @enderror

                                    <div class="mt-3 text-right">
                                        <button type="button" wire:click="$set('uploading', false)"
                                            class="text-sm text-gray-600 mr-3">Batal</button>
                                        <button type="submit"
                                            class="inline-flex items-center px-3 py-1.5 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-amber-600 hover:bg-amber-700">
                                            <span wire:loading.remove wire:target="savePaymentProof">Simpan</span>
                                            <span wire:loading wire:target="savePaymentProof">Menyimpan...</span>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        @endif

                        @if ($successMessage)
                            <p class="mt-3 text-sm text-green-600">{{ $successMessage }}</p>
                            
                            <div class="mt-8">
                                <h3>Kembali ke Homepage Setalah Bayar</h3>
                                <a href="{{ route('welcome') }}" wire:navigate
                                    class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-amber-600 hover:bg-amber-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500 transition">
                                    Kembali ke Halaman Utama
                                </a>
                            </div>
                        @endif

                    </div>

                    <!-- Bayar via WhatsApp / Midtrans -->
                    <div class="border border-green-300 bg-green-50 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">2. Bayar via Midtrans (Rekomendasi)</h3>
                        <p class="text-sm text-gray-600 mb-4">Klik tombol di bawah untuk mengirim detail pesanan Anda ke
                            Admin via WhatsApp. <br>  **Salin pesan secara manual jika tidak tertulis secara otomatis**</p>
                        <a href="{{ $whatsappLink }}" target="_blank"
                            class="mt-6 inline-block w-full text-center bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded transition shadow-lg">
                            Bayar via Midtrans (Chat Admin)
                        </a>
                    </div>


                </div>
            </div>
        </div>
    </main>
</div>

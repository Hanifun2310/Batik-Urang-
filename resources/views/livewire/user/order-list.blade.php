<div> {{-- Elemen root wajib --}}
    @section('title', 'Pesanan Saya')

    <main class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-amber-900 mb-8">Riwayat Pesanan Saya</h1>

        {{--Tampilkan pesan sukses upload di atas --}}
        @if ($successMessage)
            <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ $successMessage }}</span>
            </div>
        @endif

        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="divide-y divide-gray-200">
                
                @forelse ($orders as $order)
                    <div class="p-4 md:p-6">
                        <div class="flex flex-col md:flex-row justify-between md:items-center">
                            
                            {{--ID, Tanggal, Status --}}
                            <div>
                                <p class="text-lg font-semibold text-amber-900">
                                    Pesanan #{{ $order->id }}
                                </p>
                                <p class="text-sm text-gray-500">
                                    Tanggal: {{ $order->created_at->translatedFormat('d F Y, H:i') }}
                                </p>
                                <p class="text-sm text-gray-600 mt-2 md:mt-1">
                                    Status: 
                                    @if($order->status == 'pending')
                                        <span class="font-medium px-2 py-1 bg-yellow-200 text-yellow-800 rounded-full text-xs">
                                            Menunggu Pembayaran
                                        </span>
                                    @elseif($order->status == 'verifying') {{-- Status Verifikasi --}}
                                        <span class="font-medium px-2 py-1 bg-blue-200 text-blue-800 rounded-full text-xs">
                                            Menunggu Verifikasi
                                        </span>
                                    @elseif($order->status == 'processing')
                                        <span class="font-medium px-2 py-1 bg-indigo-200 text-indigo-800 rounded-full text-xs">
                                            Diproses
                                        </span>
                                    @elseif($order->status == 'shipped')
                                        <span class="font-medium px-2 py-1 bg-cyan-200 text-cyan-800 rounded-full text-xs">
                                            Dikirim
                                        </span>
                                    @elseif($order->status == 'completed')
                                        <span class="font-medium px-2 py-1 bg-green-200 text-green-800 rounded-full text-xs">
                                            Selesai
                                        </span>
                                    @else {{-- Status 'cancelled' atau lainnya --}}
                                        <span class="font-medium px-2 py-1 bg-red-200 text-red-800 rounded-full text-xs">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    @endif
                                </p>
                            </div>
                            
                            {{-- Info Kanan: Total & Tombol Upload --}}
                            <div class="mt-4 md:mt-0 text-left md:text-right">
                                <p class="text-lg font-semibold text-gray-800">
                                    Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                                </p>
                                
                                {{--Logika Tombol Upload Bukti Bayar --}}
                                @if($order->status == 'Menunggu Pembayaran')
                                    {{-- Tombol untuk MEMBUKA form upload --}}
                                    <button wire:click="showUploadForm({{ $order->id }})" class="text-sm text-blue-600 hover:underline mt-1 inline-block">
                                        Upload Bukti Bayar
                                    </button>
                                    @elseif($order->status == 'verifying')
                                    {{-- Tampilkan link ke bukti yang sudah diupload --}}
                                    <a href="{{ Storage::url($order->payment_proof_path) }}" target="_blank" class="text-sm text-gray-500 hover:underline mt-1 inline-block">
                                        Lihat Bukti Bayar
                                    </a>
                                @endif
                            </div>
                        </div>

                        {{-- Form Upload (Muncul jika tombol diklik) --}}
                        @if ($uploadingOrderId === $order->id)
                            <div class="mt-4 p-4 bg-gray-50 rounded-lg border">
                                <form wire:submit="savePaymentProof">
                                    <label for="paymentProofFile-{{ $order->id }}" class="block text-sm font-medium text-gray-700">Pilih file bukti bayar (gambar, maks 2MB):</label>
                                    <input type="file" id="paymentProofFile-{{ $order->id }}" wire:model="paymentProofFile" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-amber-50 file:text-amber-700 hover:file:bg-amber-100">
                                    
                                    {{-- Indikator Loading Upload --}}
                                    <div wire:loading wire:target="paymentProofFile" class="text-sm text-gray-500 mt-1">Mengupload...</div>

                                    {{-- Preview Gambar (jika file dipilih) --}}
                                    @if ($paymentProofFile)
                                        <div class="mt-2">
                                            <p class="text-sm font-medium text-gray-700">Preview:</p>
                                            <img src="{{ $paymentProofFile->temporaryUrl() }}" class="mt-1 h-32 w-auto rounded border">
                                        </div>
                                    @endif
                                    
                                    @error('paymentProofFile') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror

                                    <div class="mt-3 text-right">
                                        <button type="button" wire:click="$set('uploadingOrderId', null)" class="text-sm text-gray-600 mr-3">Batal</button>
                                        <button type="submit" class="inline-flex items-center px-3 py-1.5 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-amber-600 hover:bg-amber-700">
                                            <span wire:loading.remove wire:target="savePaymentProof">Simpan</span>
                                            <span wire:loading wire:target="savePaymentProof">Menyimpan...</span>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        @endif
                        
                    </div>
                @empty
                    {{-- Tampilan jika tidak ada pesanan --}}
                    <div class="p-12 text-center"> ... </div>
                @endforelse
            </div>
        </div>

        <div class="mt-8">
            {{ $orders->links() }}
        </div>

    </main>
</div>
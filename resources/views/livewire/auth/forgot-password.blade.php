<div>
    <div class="bg-gradient-to-br from-amber-50 to-orange-100 min-h-screen flex items-center justify-center p-4">
        <div class="w-full max-w-md">
            <div class="bg-white rounded-lg shadow-2xl overflow-hidden">
                <div class="bg-gradient-to-r from-amber-700 to-amber-800 px-6 py-8 text-center">
                    <h1 class="text-3xl font-bold text-white mb-2">Batik Urang</h1>
                    <p class="text-amber-100 text-sm">Reset Password Anda</p>
                </div>

                <div class="px-6 py-8">
                    
                    {{-- Pesan Sukses --}}
                    @if ($status)
                        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg text-sm">
                            {{ $status }}
                        </div>
                    @endif

                    <div class="mb-4 text-sm text-gray-600">
                        Lupa password Anda? Tidak masalah. Beritahu kami alamat email Anda dan kami akan mengirimkan tautan reset password.
                    </div>

                    <form wire:submit="sendResetLink" class="space-y-5">
                        <div>
                            <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                                Email
                            </label>
                            <input
                                type="email"
                                id="email"
                                wire:model="email"
                                placeholder="nama@email.com"
                                required
                                autofocus
                                class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-amber-600 transition-colors"
                            >
                            @error('email') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                        </div>

                        <button
                            type="submit"
                            class="w-full bg-gradient-to-r from-amber-600 to-amber-700 text-white font-bold py-3 rounded-lg hover:from-amber-700 hover:to-amber-800 transition-all duration-200 transform hover:scale-105 active:scale-95"
                        >
                            <span wire:loading.remove wire:target="sendResetLink">Kirim Link Reset</span>
                            <span wire:loading wire:target="sendResetLink">Memproses...</span>
                        </button>
                    </form>
                </div>

                <div class="bg-gray-50 px-6 py-4 text-center border-t border-gray-200">
                    <p class="text-gray-700 text-sm">
                        Ingat password Anda?
                        <a href="{{ route('login') }}" wire:navigate class="text-amber-600 hover:text-amber-700 font-bold transition-colors">
                            Masuk di sini
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
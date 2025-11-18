{{-- Sisakan HANYA KONTEN UTAMA ini --}}
<div class="bg-gradient-to-br from-amber-50 to-orange-100 min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md">
        <div class="bg-white rounded-2xl shadow-2xl overflow-hidden">
            <div class="bg-gradient-to-r from-amber-600 to-orange-600 px-6 py-8 text-center">
                <h1 class="text-3xl font-bold text-white mb-2">Batik Urang</h1>
                <p class="text-amber-100">Bergabunglah dengan komunitas pecinta batik</p>
            </div>

            <div class="p-6 md:p-8">
                <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Buat Akun Baru</h2>

                <form wire:submit="register" class="space-y-4">
                    <div>
                        <label for="fullname" class="block text-sm font-semibold text-gray-700 mb-2">Nama Lengkap</label>
                        <input type="text" id="fullname" wire:model="name" placeholder="Masukkan nama lengkap Anda" class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-amber-500 transition duration-200" required>
                        @error('name') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                    </div>
                    {{-- ... Input Email, Password, Konfirmasi ... --}}
                     <div>
                        <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Email</label>
                        <input type="email" id="email" wire:model="email" placeholder="Masukkan email Anda" class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-amber-500 transition duration-200" required>
                         @error('email') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                    </div>
                        <div class="mt-4" x-data="{ show: false }">
                            <label for="password" class="block font-medium text-sm text-gray-700">{{ __('Password') }}</label>
                            
                            <div class="relative">
                                <input id="password" 
                                    class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-amber-600 transition-colors"
                                    :type="show ? 'text' : 'password'" 
                                    name="password" 
                                    required 
                                    autocomplete="new-password" />

                                {{-- Tombol Ikon Mata --}}
                                <div @click="show = !show" class="absolute inset-y-0 right-0 pr-3 flex items-center cursor-pointer">
                                    <svg x-show="!show" class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 10.166 6.36 7 12 7s8.577 3.166 9.964 4.683c.213.21.32.48.32.748s-.107.538-.32.748C20.577 13.834 17.64 17 12 17s-8.577-3.166-9.964-4.683a1.012 1.012 0 010-.639zM12 9a3 3 0 100 6 3 3 0 000-6z" />
                                    </svg>
                                    <svg x-show="show" class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="display: none;">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.575M2 2l20 20" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    <div class="mt-4" x-data="{ show: false }">
                        <label for="password_confirmation" class="block font-medium text-sm text-gray-700">{{ __('Confirm Password') }}</label>
                        
                        <div class="relative">
                            <input id="password_confirmation" 
                                class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-amber-600 transition-colors"
                                name="password_confirmation" 
                                required 
                                autocomplete="new-password" />

                            {{-- Tombol Ikon Mata --}}
                            <div @click="show = !show" class="absolute inset-y-0 right-0 pr-3 flex items-center cursor-pointer">
                                <svg x-show="!show" class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 10.166 6.36 7 12 7s8.577 3.166 9.964 4.683c.213.21.32.48.32.748s-.107.538-.32.748C20.577 13.834 17.64 17 12 17s-8.577-3.166-9.964-4.683a1.012 1.012 0 010-.639zM12 9a3 3 0 100 6 3 3 0 000-6z" />
                                </svg>
                                <svg x-show="show" class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="display: none;">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.575M2 2l20 20" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="w-full bg-gradient-to-r from-amber-600 to-orange-600 text-white font-bold py-3 rounded-lg hover:from-amber-700 hover:to-orange-700 transition duration-200 transform hover:scale-105 active:scale-95 mt-6">
                        <span wire:loading.remove wire:target="register">Daftar Sekarang</span>
                        <span wire:loading wire:target="register">Mendaftar...</span>
                    </button>
                </form>

                {{-- ... Divider ... --}}
                 <div class="flex items-center my-6"> <div class="flex-1 border-t-2 border-gray-300"></div> <span class="px-3 text-gray-500 text-sm">atau</span> <div class="flex-1 border-t-2 border-gray-300"></div> </div>

                <p class="text-center text-gray-600 mt-6">
                    Sudah punya akun?
                    <a href="{{ route('login') }}" wire:navigate class="text-amber-600 font-bold hover:underline">Masuk di sini</a>
                </p>

                <p class="text-center text-gray-500 text-sm mt-4">
                    <a href="{{ route('welcome') }}" wire:navigate class="text-amber-600 hover:underline">Kembali ke Beranda</a>
                </p>
            </div>
        </div>

        <p class="text-center text-gray-600 text-sm mt-6">
            Batik Urang © 2025 | Lestarikan Warisan Budaya Indonesia
        </p>
    </div>
</div>
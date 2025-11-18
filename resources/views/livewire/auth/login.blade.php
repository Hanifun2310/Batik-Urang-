<div> {{-- Komponen Livewire harus punya satu elemen root --}}
<div class="bg-gradient-to-br from-amber-50 to-orange-100 min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md">
        <div class="bg-white rounded-lg shadow-2xl overflow-hidden">
            <div class="bg-gradient-to-r from-amber-700 to-amber-800 px-6 py-8 text-center">
                <h1 class="text-3xl font-bold text-white mb-2">Batik Urang</h1>
                <p class="text-amber-100 text-sm">Masuk ke Akun Anda</p>
            </div>

            <div class="px-6 py-8">

                <form wire:submit="login" class="space-y-5">

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
                            class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-amber-600 transition-colors"
                        >
                        @error('email') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div x-data="{ showPassword: false }">
                        <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                            Password
                        </label>
                        <div class="relative">
                            <input
                                :type="showPassword ? 'text' : 'password'" {{-- Tipe dinamis --}}
                                id="password"
                                wire:model="password"
                                placeholder="Masukkan password Anda"
                                required
                                class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-amber-600 transition-colors pr-10" {{-- Tambah padding kanan --}}
                            >
                            
                            <button 
                                type="button" 
                                @click="showPassword = !showPassword" 
                                class="absolute inset-y-0 right-0 pr-3 flex items-center text-sm leading-5 text-gray-600 hover:text-amber-700"
                                title="Toggle password visibility"
                            >
                                <svg x-show="!showPassword" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"></path>
                                </svg>
                                <svg x-show="showPassword" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" style="display: none;">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                            </button>
                        </div>
                        @error('password') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                    </div>
                    <div class="flex items-center justify-between text-sm">
                        <label class="flex items-center cursor-pointer">
                            <input
                                type="checkbox"
                                id="remember"
                                wire:model="remember"
                                class="w-4 h-4 text-amber-600 rounded focus:ring-2 focus:ring-amber-500"
                            >
                            <span class="ml-2 text-gray-700">Ingat saya</span>
                        </label>
                        
                        {{-- LINK LUPA PASSWORD DITAMBAHKAN DI SINI --}}
                        <a href="{{ route('password.request') }}" wire:navigate class="text-amber-600 hover:text-amber-700 font-semibold transition-colors">
                            Lupa Password?
                        </a>
                    </div>

                    <button
                        type="submit"
                        class="w-full bg-gradient-to-r from-amber-600 to-amber-700 text-white font-bold py-3 rounded-lg hover:from-amber-700 hover:to-amber-800 transition-all duration-200 transform hover:scale-105 active:scale-95"
                    >
                        <span wire:loading.remove wire:target="login">Masuk</span>
                        <span wire:loading wire:target="login">Memproses...</span>
                    </button>
                </form>

                <div class="relative my-6"> <div class="absolute inset-0 flex items-center"><div class="w-full border-t-2 border-gray-300"></div></div> <div class="relative flex justify-center text-sm"><span class="px-2 bg-white text-gray-500">atau</span></div></div>

                </div>

            <div class="bg-gray-50 px-6 py-4 text-center border-t border-gray-200">
                <p class="text-gray-700 text-sm">
                    Belum punya akun?
                     <a href="{{ route('register') }}" wire:navigate class="text-amber-600 hover:text-amber-700 font-bold transition-colors">
                        Daftar di sini
                    </a>
                </p>
            </div>
        </div>

        <div class="text-center mt-6">
            <a href="{{ route('welcome') }}" wire:navigate class="text-amber-700 hover:text-amber-800 font-semibold flex items-center justify-center gap-2 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Kembali ke Beranda
            </a>
        </div>
    </div>
</div>
</div>
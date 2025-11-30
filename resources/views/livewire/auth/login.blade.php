<div>
    <div class="bg-gradient-to-br from-amber-50 to-orange-100 min-h-screen flex items-center justify-center p-4">
        <div class="w-full max-w-md">
            <!-- Card Utama -->
            <div class="bg-white rounded-2xl shadow-2xl overflow-hidden">
                
                <!-- Header -->
                <div class="bg-gradient-to-r from-amber-700 to-amber-800 px-6 py-8 text-center">
                    <h1 class="text-3xl font-bold text-white mb-2">Batik Urang</h1>
                    <p class="text-amber-100 text-sm">Masuk ke Akun Anda</p>
                </div>

                <!-- Form Section -->
                <div class="px-8 py-8">
                    <form wire:submit="login" class="space-y-6">
                        
                        <!-- Email Field -->
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
                                class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-amber-600 focus:ring-2 focus:ring-amber-200 transition-all"
                            >
                            @error('email')
                                <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Password Field -->
                        <div x-data="{ showPassword: false }">
                            <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                                Password
                            </label>
                            <div class="relative">
                                <input 
                                    :type="showPassword ? 'text' : 'password'" 
                                    id="password"
                                    wire:model="password" 
                                    placeholder="Masukkan password Anda" 
                                    required
                                    class="w-full px-4 py-3 pr-12 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-amber-600 focus:ring-2 focus:ring-amber-200 transition-all"
                                >
                                
                                <!-- Toggle Password Button -->
                                <button 
                                    type="button" 
                                    @click="showPassword = !showPassword"
                                    class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-500 hover:text-amber-700 transition-colors"
                                    title="Toggle password visibility"
                                >
                                    <!-- Icon Hide -->
                                    <svg x-show="!showPassword" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"></path>
                                    </svg>
                                    
                                    <!-- Icon Show -->
                                    <svg x-show="showPassword" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </button>
                            </div>
                            @error('password')
                                <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Remember Me & Forgot Password -->
                        <div class="flex items-center justify-between">
                            <label class="flex items-center cursor-pointer group">
                                <input 
                                    type="checkbox" 
                                    id="remember" 
                                    wire:model="remember"
                                    class="w-4 h-4 text-amber-600 border-gray-300 rounded focus:ring-2 focus:ring-amber-500 cursor-pointer"
                                >
                                <span class="ml-2 text-sm text-gray-700 group-hover:text-gray-900 transition-colors">
                                    Ingat saya
                                </span>
                            </label>

                            <!-- Uncomment jika ingin menambahkan link lupa password -->
                            {{-- 
                            <a 
                                href="{{ route('password.request') }}" 
                                wire:navigate
                                class="text-sm text-amber-600 hover:text-amber-700 font-semibold transition-colors"
                            >
                                Lupa Password?
                            </a>
                            --}}
                        </div>

                        <!-- Submit Button -->
                        <button 
                            type="submit"
                            class="w-full bg-gradient-to-r from-amber-600 to-amber-700 text-white font-bold py-3.5 rounded-lg hover:from-amber-700 hover:to-amber-800 focus:outline-none focus:ring-4 focus:ring-amber-300 transition-all duration-200 transform hover:scale-[1.02] active:scale-[0.98] shadow-lg hover:shadow-xl"
                        >
                            <span wire:loading.remove wire:target="login">Masuk</span>
                            <div wire:loading.flex wire:target="login" class="flex items-center justify-center gap-2">
                                <svg class="animate-spin h-5 w-5" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Memproses...
                            </div>
                        </button>
                    </form>

                    <!-- Divider -->
                    <div class="relative my-8">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-gray-300"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="px-3 bg-white text-gray-500 font-medium">atau</span>
                        </div>
                    </div>
                </div>

                <!-- Register Link Footer -->
                <div class="bg-gray-50 px-8 py-5 text-center border-t border-gray-200">
                    <p class="text-sm text-gray-700">
                        Belum punya akun?
                        <a 
                            href="{{ route('register') }}" 
                            wire:navigate
                            class="text-amber-600 hover:text-amber-700 font-bold transition-colors hover:underline"
                        >
                            Daftar di sini
                        </a>
                    </p>
                </div>
            </div>

            <!-- Back to Home Link -->
            <div class="text-center mt-8">
                <a 
                    href="{{ route('welcome') }}" 
                    wire:navigate
                    class="inline-flex items-center gap-2 text-amber-700 hover:text-amber-800 font-semibold transition-colors group"
                >
                    <svg class="w-5 h-5 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>
</div>
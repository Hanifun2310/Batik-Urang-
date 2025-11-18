<div>
    @section('title', 'Profil Saya')

    <main class="max-w-2xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-amber-900 mb-8">Profil Saya</h1>

        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            
            <form wire:submit="updateProfile">
                <div class="p-6 space-y-4">

                    {{-- Menampilkan pesan sukses --}}
                    @if (session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                        {{-- Bagian Foto Profil (Desain Baru) --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Foto Profil</label>
                        <div class="mt-1 flex items-center space-x-5"> 
                            <div class="flex-shrink-0">
                                <span class="inline-block h-20 w-20 rounded-full overflow-hidden bg-gray-100 shadow">
                                    @if ($photo)
                                        <img class="h-full w-full object-cover" src="{{ $photo->temporaryUrl() }}" alt="Preview">
                                    @elseif (Auth::user()->profile_photo_path)
                                        <img class="h-full w-full object-cover" src="{{ Storage::url(Auth::user()->profile_photo_path) }}" alt="{{ Auth::user()->name }}">
                                    @else
                                        {{-- Placeholder SVG --}}
                                        <svg class="h-full w-full text-gray-300" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                                        </svg>
                                    @endif
                                </span>
                            </div>
                            {{-- Ganti Foto & Loading --}}
                            <div>
                                <label for="photo" class="cursor-pointer bg-white py-2 px-3 border border-gray-300 rounded-md shadow-sm text-sm leading-4 font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500">
                                    <span>Ganti Foto</span>
                                    <input id="photo" name="photo" type="file" class="sr-only" wire:model="photo">
                                </label>
                                <div wire:loading wire:target="photo" class="mt-1 text-xs text-gray-500">Mengupload...</div>
                            </div>
                        </div>
                        @error('photo') <span class="text-red-500 text-sm mt-2">{{ $message }}</span> @enderror {{-- Tambah margin atas --}}
                    </div>

                    {{-- Nama Lengkap --}}
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                        <input type="text" id="name" wire:model="name"
                               class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-amber-500 focus:border-amber-500 sm:text-sm">
                        @error('name') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                    </div>

                    {{-- Alamat Email --}}
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Alamat Email</label>
                        <input type="email" id="email" wire:model="email"
                               class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-amber-500 focus:border-amber-500 sm:text-sm">
                        @error('email') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                    </div>

                    {{--  Bio --}}
                    <div>
                        <label for="bio" class="block text-sm font-medium text-gray-700">Bio Singkat</label>
                        <textarea id="bio" wire:model="bio" rows="3"
                                  class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-amber-500 focus:border-amber-500 sm:text-sm"
                                  placeholder="Tulis sedikit tentang diri Anda..."></textarea>
                        @error('bio') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                    </div>

                    {{-- Jenis Kelamin --}}
                    <div>
                        <label for="gender" class="block text-sm font-medium text-gray-700">Jenis Kelamin</label>
                        <select id="gender" wire:model="gender"
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-amber-500 focus:border-amber-500 sm:text-sm">
                            <option value="">Pilih...</option>
                            <option value="Pria">Pria</option>
                            <option value="Wanita">Wanita</option>
                        </select>
                        @error('gender') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                    </div>

                    {{-- Tanggal Lahir --}}
                    <div>
                        <label for="date_of_birth" class="block text-sm font-medium text-gray-700">Tanggal Lahir</label>
                        <input type="date" id="date_of_birth" wire:model="date_of_birth"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-amber-500 focus:border-amber-500 sm:text-sm">
                        @error('date_of_birth') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                    </div>

                    {{-- Nomor Handphone --}}
                    <div>
                        <label for="phone_number" class="block text-sm font-medium text-gray-700">No. Handphone</label>
                        <input type="tel" id="phone_number" wire:model="phone_number"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-amber-500 focus:border-amber-500 sm:text-sm"
                            placeholder="Contoh: 08123456789">
                        @error('phone_number') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                    </div>
                    
                    {{-- [TAMBAH] Alamat Lengkap --}}
                    <div>
                        <label for="address" class="block text-sm font-medium text-gray-700">Alamat Lengkap</label>
                        <textarea id="address" wire:model="address" rows="4"
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-amber-500 focus:border-amber-500 sm:text-sm"
                                placeholder="Masukkan alamat lengkap Anda untuk pengiriman..."></textarea>
                        @error('address') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                    </div>

                    {{-- Bergabung Sejak --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Bergabung Sejak</label>
                        <p class="mt-1 text-sm text-gray-700">{{ Auth::user()->created_at->translatedFormat('l, d F Y') }}</p>
                    </div>

                    {{-- Ganti Password --}}
                    <div class="border-t pt-4 mt-4 space-y-4">
                        <h2 class="text-lg font-medium text-gray-900">Ganti Password (Opsional)</h2>
                        <p class="text-sm text-gray-600">Kosongkan jika Anda tidak ingin mengubah password.</p>
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700">Password Baru</label>
                            <input type="password" id="password" wire:model="password"
                                   class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-amber-500 focus:border-amber-500 sm:text-sm"
                                   placeholder="Minimal 8 karakter">
                            @error('password') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Konfirmasi Password Baru</label>
                            <input type="password" id="password_confirmation" wire:model="password_confirmation"
                                   class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-amber-500 focus:border-amber-500 sm:text-sm"
                                   placeholder="Ulangi password baru">
                        </div>
                    </div>
                </div>

                <div class="bg-gray-50 px-6 py-4 text-right">
                    <button type="submit"
                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-amber-600 hover:bg-amber-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500">
                        <span wire:loading.remove wire:target="updateProfile">Simpan Perubahan</span>
                        <span wire:loading wire:target="updateProfile">Menyimpan...</span>
                    </button>
                </div>
            </form>
        </div>
        
        <div class="mt-8 text-center">
            <a href="#" onclick="window.history.back(); return false;" class="text-amber-700 hover:text-amber-800 font-semibold inline-flex items-center gap-2 transition-colors">
                 <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Kembali
            </a>
        </div>
    </main>
</div>
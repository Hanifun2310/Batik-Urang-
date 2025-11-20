<div> {{-- Elemen root wajib --}}

    <main class="max-w-3xl mx-auto py-12 px-4 sm:px-6 lg:px-8">

        <img src="{{ asset($article->featured_image_url ?? 'https://via.placeholder.com/800x400.png?text=Artikel') }}"
            alt="{{ $article->title }}" class="w-full h-64 md:h-80 object-cover rounded-lg shadow-lg mb-8">

        <h1 class="text-4xl font-bold text-amber-900 mb-4">
            {{ $article->title }}
        </h1>

        <p class="text-gray-500 text-sm mb-6 pb-6 border-b border-gray-200">
            Dipublikasikan pada: {{ $article->created_at->translatedFormat('d F Y') }}
        </p>

        <div class="prose prose-lg max-w-none text-gray-800 leading-relaxed">
            {{-- Kita gunakan nl2br() untuk menghormati baris baru, atau bisa pakai Trix/Markdown --}}
            {!! nl2br(e($article->content)) !!}
        </div>

        <div class="mt-12 text-center">
            <a href="{{ route('articles.index') }}" wire:navigate
                class="text-amber-700 hover:text-amber-800 font-semibold inline-flex items-center gap-2 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali ke Daftar Artikel
            </a>
        </div>

    </main>
</div>

<div> {{-- Elemen root wajib --}}
    @section('title', 'Artikel Tentang Batik')

    <main class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-amber-900 mb-4">Artikel Tentang Batik</h1>
            <p class="text-lg text-gray-600">Pelajari lebih lanjut tentang sejarah, proses, dan makna batik Indonesia.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">

            @forelse ($articles as $article)
                <article class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition flex flex-col">
                    <a href="{{ route('articles.show', $article->slug) }}" wire:navigate class="block">
                        <img src="{{ asset($article->featured_image_url ?? 'https://via.placeholder.com/500x250.png?text=Artikel') }}" 
                            alt="{{ $article->title }}" 
                            class="w-full h-48 object-cover">
                    </a>
                    
                    <div class="p-6 flex flex-col flex-grow">
                        <h3 class="text-xl sm:text-2xl font-bold text-amber-900 mb-3 flex-grow">
                            <a href="{{ route('articles.show', $article->slug) }}" wire:navigate class="hover:underline">
                                {{ $article->title }}
                            </a>
                        </h3>
                        <p class="text-gray-700 leading-relaxed mb-4">
                            {{ Str::limit($article->content, 150, '...') }} 
                        </p>
                        <p class="text-gray-500 text-sm mt-auto pt-4 border-t border-gray-100">
                            Dipublikasikan pada: {{ $article->created_at->translatedFormat('d F Y') }}
                        </p>
                    </div>
                </article>
            @empty
                <p class="col-span-full text-center text-gray-500 text-lg">
                    Belum ada artikel yang dipublikasikan saat ini.
                </p>
            @endforelse

        </div> {{-- End Grid --}}

        <div class="mt-12">
            {{ $articles->links() }}
        </div>

    </main>
</div>
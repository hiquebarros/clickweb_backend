@extends('layouts.app')

@section('title', 'Filmes')

@section('content')
<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <!-- Header -->
    <div class="bg-gradient-to-r from-[#613ed9] to-[#4c2db8] px-6 py-5">
        <h2 class="text-white text-xl font-bold flex items-center space-x-2">
            <i class="bi bi-film"></i>
            <span>Filmes</span>
        </h2>
    </div>

    <!-- Content -->
    <div class="p-6">
        @if(isset($response['results']) && count($response['results']) > 0)
            <!-- Grid de Cards - 5 colunas em desktop (2 linhas = 10 cards) -->
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4 md:gap-6">
                @foreach(array_slice($response['results'], 0, 10) as $movie)
                    <div class="bg-white rounded-lg shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-200 group">
                        <!-- Capa do Filme -->
                        <div class="relative aspect-[2/3] bg-gray-200 overflow-hidden">
                            @if(isset($movie['primaryImage']) && isset($movie['primaryImage']['url']))
                                <img 
                                    src="{{ $movie['primaryImage']['url'] }}" 
                                    alt="{{ isset($movie['titleText']) && isset($movie['titleText']['text']) ? $movie['titleText']['text'] : 'Filme' }}"
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                                    onerror="this.src='data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' width=\'400\' height=\'600\'%3E%3Crect fill=\'%23e5e7eb\' width=\'400\' height=\'600\'/%3E%3Ctext x=\'50%25\' y=\'50%25\' text-anchor=\'middle\' dy=\'.3em\' fill=\'%239ca3af\' font-family=\'sans-serif\' font-size=\'18\'%3ESem imagem%3C/text%3E%3C/svg%3E'"
                                >
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-gray-200">
                                    <i class="bi bi-image text-gray-400 text-4xl"></i>
                                </div>
                            @endif
                        </div>

                        <!-- Informações do Filme -->
                        <div class="p-4">
                            <!-- Título -->
                            @if(isset($movie['titleText']) && isset($movie['titleText']['text']))
                                <h3 class="font-semibold text-gray-900 text-sm mb-2 line-clamp-2 min-h-[2.5rem]">
                                    {{ $movie['titleText']['text'] }}
                                </h3>
                            @else
                                <h3 class="font-semibold text-gray-400 text-sm mb-2 italic">
                                    Título não disponível
                                </h3>
                            @endif

                            <!-- Ano -->
                            @if(isset($movie['releaseYear']) && isset($movie['releaseYear']['year']))
                                <div class="flex items-center space-x-2">
                                    <i class="bi bi-calendar3 text-[#613ed9]"></i>
                                    <span class="text-gray-600 text-sm font-medium">
                                        {{ $movie['releaseYear']['year'] }}
                                    </span>
                                </div>
                            @else
                                <div class="flex items-center space-x-2">
                                    <i class="bi bi-calendar3 text-gray-400"></i>
                                    <span class="text-gray-400 text-sm italic">
                                        Ano não disponível
                                    </span>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <!-- Estado vazio -->
            <div class="text-center py-12">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-[#613ed9]/10 rounded-full mb-4">
                    <i class="bi bi-film text-[#613ed9] text-3xl"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Nenhum filme encontrado</h3>
                <p class="text-gray-600">Não há filmes disponíveis no momento.</p>
            </div>
        @endif
    </div>
</div>
@endsection

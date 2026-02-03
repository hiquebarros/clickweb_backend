@extends('layouts.app')

@section('title', 'Filmes')

@section('content')
<div>
    @if(isset($response['results']) && count($response['results']) > 0)
        <!-- Grid de Cards - 5 colunas em desktop (2 linhas = 10 cards) -->
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-3 md:gap-4">
            @foreach(array_slice($response['results'], 0, 10) as $movie)
                <div class="bg-white rounded-lg shadow-sm hover:shadow-md transition-all duration-200 overflow-hidden border border-gray-200 group cursor-pointer">
                    <!-- Capa do Filme -->
                    <div class="relative aspect-[2/3] bg-gray-100 overflow-hidden">
                        @if(isset($movie['primaryImage']) && isset($movie['primaryImage']['url']))
                            <img 
                                src="{{ $movie['primaryImage']['url'] }}" 
                                alt="{{ isset($movie['titleText']) && isset($movie['titleText']['text']) ? $movie['titleText']['text'] : 'Filme' }}"
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                                onerror="this.src='data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' width=\'400\' height=\'600\'%3E%3Crect fill=\'%23e5e7eb\' width=\'400\' height=\'600\'/%3E%3Ctext x=\'50%25\' y=\'50%25\' text-anchor=\'middle\' dy=\'.3em\' fill=\'%239ca3af\' font-family=\'sans-serif\' font-size=\'18\'%3ESem imagem%3C/text%3E%3C/svg%3E'"
                            >
                        @else
                            <div class="w-full h-full flex items-center justify-center bg-gray-100">
                                <i class="bi bi-image text-gray-400 text-3xl"></i>
                            </div>
                        @endif
                    </div>

                    <!-- Informações do Filme -->
                    <div class="p-2.5">
                        <!-- Título -->
                        @if(isset($movie['titleText']) && isset($movie['titleText']['text']))
                            <h3 class="font-semibold text-gray-900 text-xs leading-tight mb-1.5 line-clamp-2 h-8">
                                {{ $movie['titleText']['text'] }}
                            </h3>
                        @else
                            <h3 class="font-semibold text-gray-400 text-xs leading-tight mb-1.5 italic h-8">
                                Título não disponível
                            </h3>
                        @endif

                        <!-- Ano -->
                        @if(isset($movie['releaseYear']) && isset($movie['releaseYear']['year']))
                            <div class="flex items-center gap-1">
                                <i class="bi bi-calendar3 text-primary-600 text-xs"></i>
                                <span class="text-gray-600 text-xs font-medium">
                                    {{ $movie['releaseYear']['year'] }}
                                </span>
                            </div>
                        @else
                            <div class="flex items-center gap-1">
                                <i class="bi bi-calendar3 text-gray-400 text-xs"></i>
                                <span class="text-gray-400 text-xs italic">
                                    N/A
                                </span>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Paginação -->
        <div class="flex items-center justify-between mt-6 pt-6 border-t border-gray-200">
            <!-- Botão Anterior -->
            @if($currentPage > 1)
                <a href="{{ route('movies.index', ['page' => $currentPage - 1]) }}" 
                   class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors shadow-sm">
                    <i class="bi bi-chevron-left"></i>
                    <span class="font-medium">Anterior</span>
                </a>
            @else
                <div class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 border border-gray-200 text-gray-400 rounded-lg cursor-not-allowed">
                    <i class="bi bi-chevron-left"></i>
                    <span class="font-medium">Anterior</span>
                </div>
            @endif

            <!-- Indicador de Página -->
            <div class="flex items-center gap-2">
                <span class="text-sm font-medium text-gray-700">Página</span>
                <span class="px-3 py-1 bg-primary-600 text-white rounded-lg font-semibold">{{ $currentPage }}</span>
            </div>

            <!-- Botão Próximo -->
            @if($hasNextPage)
                <a href="{{ route('movies.index', ['page' => $currentPage + 1]) }}" 
                   class="inline-flex items-center gap-2 px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-colors shadow-sm">
                    <span class="font-medium">Próximo</span>
                    <i class="bi bi-chevron-right"></i>
                </a>
            @else
                <div class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 border border-gray-200 text-gray-400 rounded-lg cursor-not-allowed">
                    <span class="font-medium">Próximo</span>
                    <i class="bi bi-chevron-right"></i>
                </div>
            @endif
        </div>
    @else
            <!-- Estado vazio -->
            <div class="text-center py-12">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-primary-600/10 rounded-full mb-4">
                    <i class="bi bi-film text-primary-600 text-3xl"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Nenhum filme encontrado</h3>
                <p class="text-gray-600">Não há filmes disponíveis no momento.</p>
            </div>
        @endif
    </div>
</div>
@endsection

@extends('layouts.app')

@section('title', 'Detalhes da Notícia')

@section('content')
<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <!-- Header -->
    <div class="bg-gradient-to-r from-[#613ed9] to-[#4c2db8] px-6 py-5 flex justify-between items-center">
        <h2 class="text-white text-xl font-bold flex items-center space-x-2">
            <i class="bi bi-file-text"></i>
            <span>Detalhes da Notícia</span>
        </h2>
        <a href="{{ route('news.index') }}" class="bg-white/20 hover:bg-white/30 text-white px-4 py-2 rounded-lg text-sm font-semibold transition-colors flex items-center space-x-2">
            <i class="bi bi-arrow-left"></i>
            <span>Voltar</span>
        </a>
    </div>

    <!-- Content -->
    <div class="p-6">
        <!-- Title -->
        <h1 class="text-3xl font-bold text-gray-900 mb-6 pb-4 border-b border-gray-200">
            {{ $news->title }}
        </h1>

        <!-- Metadata Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
            <!-- Autor -->
            <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                <div class="flex items-center space-x-3">
                    <div class="flex-shrink-0 w-10 h-10 bg-[#613ed9]/10 rounded-lg flex items-center justify-center">
                        <i class="bi bi-person text-[#613ed9] text-lg"></i>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Autor</p>
                        <p class="text-sm font-medium text-gray-900 mt-1">{{ $news->author }}</p>
                    </div>
                </div>
            </div>

            <!-- Data de Publicação -->
            <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                <div class="flex items-center space-x-3">
                    <div class="flex-shrink-0 w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                        <i class="bi bi-calendar-check text-green-600 text-lg"></i>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Data de Publicação</p>
                        <p class="text-sm font-medium text-gray-900 mt-1">
                            @if($news->published_at)
                                {{ $news->published_at->format('d/m/Y H:i') }}
                            @else
                                <span class="text-gray-400 italic">Não publicado</span>
                            @endif
                        </p>
                    </div>
                </div>
            </div>

            <!-- Criado em -->
            <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                <div class="flex items-center space-x-3">
                    <div class="flex-shrink-0 w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                        <i class="bi bi-calendar-plus text-blue-600 text-lg"></i>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Criado em</p>
                        <p class="text-sm font-medium text-gray-900 mt-1">{{ $news->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>
            </div>

            <!-- Atualizado em -->
            <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                <div class="flex items-center space-x-3">
                    <div class="flex-shrink-0 w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                        <i class="bi bi-pencil text-purple-600 text-lg"></i>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Atualizado em</p>
                        <p class="text-sm font-medium text-gray-900 mt-1">{{ $news->updated_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content Section -->
        <div class="mb-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center space-x-2">
                <i class="bi bi-file-text text-[#613ed9]"></i>
                <span>Conteúdo</span>
            </h3>
            <div class="bg-gray-50 rounded-lg p-6 border border-gray-200">
                <p class="text-gray-700 leading-relaxed whitespace-pre-wrap">{{ $news->content }}</p>
            </div>
        </div>

        <!-- Actions -->
        <div class="pt-6 border-t border-gray-200 flex flex-col sm:flex-row items-center justify-between space-y-3 sm:space-y-0">
            <a href="{{ route('news.index') }}" class="w-full sm:w-auto inline-flex items-center justify-center space-x-2 bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-3 rounded-lg font-semibold transition-colors">
                <i class="bi bi-arrow-left"></i>
                <span>Voltar para Listagem</span>
            </a>
            <div class="flex items-center space-x-3 w-full sm:w-auto">
                <a href="{{ route('news.edit', $news->id) }}" class="flex-1 sm:flex-none inline-flex items-center justify-center space-x-2 bg-yellow-100 hover:bg-yellow-200 text-yellow-800 px-6 py-3 rounded-lg font-semibold transition-colors shadow-md hover:shadow-lg border border-yellow-300">
                    <i class="bi bi-pencil text-base font-semibold text-yellow-700"></i>
                    <span>Editar</span>
                </a>
                <button type="button" 
                        onclick="openDeleteModal({{ $news->id }}, '{{ addslashes($news->title) }}')" 
                        class="flex-1 w-full inline-flex items-center justify-center space-x-2 bg-white hover:bg-red-50 text-red-600 px-6 py-3 rounded-lg font-semibold transition-colors shadow-md hover:shadow-lg border border-red-300">
                    <i class="bi bi-trash text-base font-semibold text-red-600"></i>
                    <span>Excluir</span>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Confirmação de Exclusão -->
<div id="deleteModal" class="hidden fixed inset-0 z-50 overflow-y-auto">
    <!-- Overlay -->
    <div class="fixed inset-0 bg-black bg-opacity-50 transition-opacity" onclick="closeDeleteModal()"></div>
    
    <!-- Modal Content -->
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="relative bg-white rounded-xl shadow-2xl max-w-md w-full transform transition-all">
            <!-- Header -->
            <div class="p-6 border-b border-gray-200">
                <div class="flex items-center space-x-3">
                    <div class="flex-shrink-0 w-12 h-12 bg-red-100 rounded-full flex items-center justify-center">
                        <i class="bi bi-exclamation-triangle text-red-600 text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">Confirmar Exclusão</h3>
                        <p class="text-sm text-gray-500">Esta ação não pode ser desfeita</p>
                    </div>
                </div>
            </div>
            
            <!-- Body -->
            <div class="p-6">
                <p class="text-gray-700">
                    Tem certeza que deseja excluir a notícia 
                    <strong class="text-gray-900" id="deleteNewsTitle"></strong>?
                </p>
                <p class="text-sm text-gray-500 mt-2">
                    Todos os dados relacionados a esta notícia serão permanentemente removidos do sistema.
                </p>
            </div>
            
            <!-- Footer -->
            <div class="p-6 border-t border-gray-200 flex items-center justify-end space-x-3">
                <button type="button" 
                        onclick="closeDeleteModal()" 
                        class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg font-medium transition-colors">
                    Cancelar
                </button>
                <form id="deleteForm" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg font-medium transition-colors shadow-md hover:shadow-lg">
                        Excluir Notícia
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function openDeleteModal(newsId, newsTitle) {
        const modal = document.getElementById('deleteModal');
        const form = document.getElementById('deleteForm');
        const titleElement = document.getElementById('deleteNewsTitle');
        
        // Atualiza o formulário com a URL correta
        form.action = `/news/${newsId}`;
        
        // Atualiza o título da notícia no modal
        titleElement.textContent = newsTitle;
        
        // Mostra o modal
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }
    
    function closeDeleteModal() {
        const modal = document.getElementById('deleteModal');
        modal.classList.add('hidden');
        document.body.style.overflow = 'auto';
    }
    
    // Fecha o modal ao pressionar ESC
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            closeDeleteModal();
        }
    });
</script>
@endsection

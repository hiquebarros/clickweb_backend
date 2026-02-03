@extends('layouts.app')

@section('title', 'Listagem de Notícias')

@section('content')
<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <!-- Header -->
    <div class="bg-gradient-to-r from-[#613ed9] to-[#4c2db8] px-6 py-5 flex justify-between items-center">
        <h2 class="text-white text-xl font-bold flex items-center space-x-2">
            <i class="bi bi-list-ul"></i>
            <span>Listagem de Notícias</span>
        </h2>
        <a href="{{ route('news.create') }}" class="bg-white text-[#613ed9] hover:bg-gray-100 px-4 py-2 rounded-lg text-sm font-semibold transition-all shadow-md hover:shadow-lg flex items-center space-x-2">
            <i class="bi bi-plus-circle"></i>
            <span>Nova Notícia</span>
        </a>
    </div>

    <!-- Content -->
    <div class="p-6">
        @if($news->count() > 0)
            <!-- Desktop Table -->
            <div class="hidden md:block overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">ID</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Título</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Autor</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Data de Publicação</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Criado em</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($news as $item)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">#{{ $item->id }}</td>
                                <td class="px-6 py-4 text-sm font-medium text-gray-900">
                                    {{ Str::limit($item->title, 50) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                    <div class="flex items-center space-x-2">
                                        <i class="bi bi-person text-[#613ed9]"></i>
                                        <span>{{ $item->author }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                    @if($item->published_at)
                                        <div class="flex items-center space-x-2">
                                            <i class="bi bi-calendar-check text-green-500"></i>
                                            <span>{{ $item->published_at->format('d/m/Y H:i') }}</span>
                                        </div>
                                    @else
                                        <span class="text-gray-400 italic">Não publicado</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $item->created_at->format('d/m/Y H:i') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <div class="flex items-center space-x-2">
                                        <a href="{{ route('news.show', $item->id) }}" class="inline-flex items-center justify-center w-9 h-9 bg-[#613ed9] text-white rounded-lg hover:bg-[#4c2db8] transition-colors shadow-sm hover:shadow-md" title="Ver detalhes">
                                            <i class="bi bi-eye text-base font-semibold text-white"></i>
                                        </a>
                                        <a href="{{ route('news.edit', $item->id) }}" class="inline-flex items-center justify-center w-9 h-9 bg-yellow-100 hover:bg-yellow-200 rounded-lg transition-colors shadow-sm hover:shadow-md border border-yellow-300" title="Editar">
                                            <i class="bi bi-pencil text-base font-semibold text-yellow-700"></i>
                                        </a>
                                        <button type="button" 
                                                onclick="openDeleteModal({{ $item->id }}, '{{ addslashes($item->title) }}')" 
                                                class="inline-flex items-center justify-center w-9 h-9 bg-white hover:bg-red-50 rounded-lg transition-colors shadow-sm hover:shadow-md border border-red-300" 
                                                title="Excluir">
                                            <i class="bi bi-trash text-base font-semibold text-red-600"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Mobile Cards -->
            <div class="md:hidden space-y-4">
                @foreach($news as $item)
                    <div class="bg-gray-50 rounded-lg p-4 border border-gray-200 hover:shadow-md transition-shadow">
                        <div class="flex justify-between items-start mb-3">
                            <div class="flex-1">
                                <h3 class="font-semibold text-gray-900 mb-1">{{ Str::limit($item->title, 40) }}</h3>
                                <p class="text-xs text-gray-500">ID: #{{ $item->id }}</p>
                            </div>
                            <div class="ml-2 flex items-center space-x-1">
                                <a href="{{ route('news.show', $item->id) }}" class="inline-flex items-center justify-center w-8 h-8 bg-[#613ed9] text-white rounded-lg hover:bg-[#4c2db8] transition-colors shadow-sm" title="Ver detalhes">
                                    <i class="bi bi-eye text-sm font-semibold text-white"></i>
                                </a>
                                <a href="{{ route('news.edit', $item->id) }}" class="inline-flex items-center justify-center w-8 h-8 bg-yellow-100 hover:bg-yellow-200 rounded-lg transition-colors shadow-sm border border-yellow-300" title="Editar">
                                    <i class="bi bi-pencil text-sm font-semibold text-yellow-700"></i>
                                </a>
                                <button type="button" 
                                        onclick="openDeleteModal({{ $item->id }}, '{{ addslashes($item->title) }}')" 
                                        class="inline-flex items-center justify-center w-8 h-8 bg-white hover:bg-red-50 rounded-lg transition-colors shadow-sm border border-red-300" 
                                        title="Excluir">
                                    <i class="bi bi-trash text-sm font-semibold text-red-600"></i>
                                </button>
                            </div>
                        </div>
                        <div class="space-y-2 text-sm">
                            <div class="flex items-center space-x-2 text-gray-600">
                                <i class="bi bi-person text-[#613ed9]"></i>
                                <span>{{ $item->author }}</span>
                            </div>
                            <div class="flex items-center space-x-2 text-gray-600">
                                <i class="bi bi-calendar-event"></i>
                                <span>
                                    @if($item->published_at)
                                        Publicado: {{ $item->published_at->format('d/m/Y H:i') }}
                                    @else
                                        <span class="text-gray-400 italic">Não publicado</span>
                                    @endif
                                </span>
                            </div>
                            <div class="flex items-center space-x-2 text-gray-500 text-xs">
                                <i class="bi bi-clock"></i>
                                <span>Criado: {{ $item->created_at->format('d/m/Y H:i') }}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-6 flex justify-center">
                {{ $news->links() }}
            </div>
        @else
            <div class="text-center py-12">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-[#613ed9]/10 rounded-full mb-4">
                    <i class="bi bi-info-circle text-[#613ed9] text-3xl"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Nenhuma notícia cadastrada ainda</h3>
                <p class="text-gray-600 mb-6">Comece criando sua primeira notícia!</p>
                <a href="{{ route('news.create') }}" class="inline-flex items-center space-x-2 bg-[#613ed9] text-white px-6 py-3 rounded-lg font-semibold hover:bg-[#4c2db8] transition-colors shadow-md hover:shadow-lg">
                    <i class="bi bi-plus-circle"></i>
                    <span>Cadastrar primeira notícia</span>
                </a>
            </div>
        @endif
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

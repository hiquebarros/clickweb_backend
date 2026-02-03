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
                                        <form action="{{ route('news.destroy', $item->id) }}" method="POST" class="inline" onsubmit="return confirm('Tem certeza que deseja excluir esta notícia? Esta ação não pode ser desfeita.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex items-center justify-center w-9 h-9 bg-white hover:bg-red-50 rounded-lg transition-colors shadow-sm hover:shadow-md border border-red-300" title="Excluir">
                                                <i class="bi bi-trash text-base font-semibold text-red-600"></i>
                                            </button>
                                        </form>
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
                                <form action="{{ route('news.destroy', $item->id) }}" method="POST" class="inline" onsubmit="return confirm('Tem certeza que deseja excluir esta notícia? Esta ação não pode ser desfeita.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center justify-center w-8 h-8 bg-white hover:bg-red-50 rounded-lg transition-colors shadow-sm border border-red-300" title="Excluir">
                                        <i class="bi bi-trash text-sm font-semibold text-red-600"></i>
                                    </button>
                                </form>
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
@endsection

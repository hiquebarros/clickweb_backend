@extends('layouts.app')

@section('title', 'Editar Notícia')

@section('content')
<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <!-- Header -->
    <div class="bg-gradient-to-r from-[#613ed9] to-[#4c2db8] px-6 py-5">
        <h2 class="text-white text-xl font-bold flex items-center space-x-2">
            <i class="bi bi-pencil-square"></i>
            <span>Editar Notícia</span>
        </h2>
    </div>

    <!-- Form -->
    <form action="{{ route('news.update', $news->id) }}" method="POST" class="p-6">
        @csrf
        @method('PUT')
        
        <!-- Título -->
        <div class="mb-6">
            <label for="title" class="block text-sm font-semibold text-gray-700 mb-2">
                Título <span class="text-red-500">*</span>
            </label>
            <input type="text" 
                   id="title" 
                   name="title" 
                   value="{{ old('title', $news->title) }}" 
                   placeholder="Digite o título da notícia"
                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#613ed9] focus:border-transparent transition-all @error('title') border-red-500 @enderror"
                   required>
            @error('title')
                <p class="mt-2 text-sm text-red-600 flex items-center space-x-1">
                    <i class="bi bi-exclamation-circle"></i>
                    <span>{{ $message }}</span>
                </p>
            @enderror
        </div>

        <!-- Conteúdo -->
        <div class="mb-6">
            <label for="content" class="block text-sm font-semibold text-gray-700 mb-2">
                Conteúdo <span class="text-red-500">*</span>
            </label>
            <textarea id="content" 
                      name="content" 
                      rows="10" 
                      placeholder="Digite o conteúdo da notícia"
                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#613ed9] focus:border-transparent transition-all resize-y @error('content') border-red-500 @enderror"
                      required>{{ old('content', $news->content) }}</textarea>
            @error('content')
                <p class="mt-2 text-sm text-red-600 flex items-center space-x-1">
                    <i class="bi bi-exclamation-circle"></i>
                    <span>{{ $message }}</span>
                </p>
            @enderror
        </div>

        <!-- Autor e Data de Publicação -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <!-- Autor -->
            <div>
                <label for="author" class="block text-sm font-semibold text-gray-700 mb-2">
                    Autor <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="bi bi-person text-gray-400"></i>
                    </div>
                    <input type="text" 
                           id="author" 
                           name="author" 
                           value="{{ old('author', $news->author) }}" 
                           placeholder="Nome do autor"
                           class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#613ed9] focus:border-transparent transition-all @error('author') border-red-500 @enderror"
                           required>
                </div>
                @error('author')
                    <p class="mt-2 text-sm text-red-600 flex items-center space-x-1">
                        <i class="bi bi-exclamation-circle"></i>
                        <span>{{ $message }}</span>
                    </p>
                @enderror
            </div>

            <!-- Data de Publicação -->
            <div>
                <label for="published_at" class="block text-sm font-semibold text-gray-700 mb-2">
                    Data de Publicação
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="bi bi-calendar-event text-gray-400"></i>
                    </div>
                    <input type="datetime-local" 
                           id="published_at" 
                           name="published_at" 
                           value="{{ old('published_at', $news->published_at ? $news->published_at->format('Y-m-d\TH:i') : '') }}"
                           class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#613ed9] focus:border-transparent transition-all @error('published_at') border-red-500 @enderror">
                </div>
                <p class="mt-2 text-xs text-gray-500 flex items-center space-x-1">
                    <i class="bi bi-info-circle"></i>
                    <span>Deixe em branco para não publicar ainda</span>
                </p>
                @error('published_at')
                    <p class="mt-2 text-sm text-red-600 flex items-center space-x-1">
                        <i class="bi bi-exclamation-circle"></i>
                        <span>{{ $message }}</span>
                    </p>
                @enderror
            </div>
        </div>

        <!-- Actions -->
        <div class="flex flex-col sm:flex-row justify-between items-center space-y-3 sm:space-y-0 pt-6 border-t border-gray-200">
            <a href="{{ route('news.show', $news->id) }}" class="w-full sm:w-auto inline-flex items-center justify-center space-x-2 px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors font-semibold">
                <i class="bi bi-arrow-left"></i>
                <span>Cancelar</span>
            </a>
            <button type="submit" class="w-full sm:w-auto inline-flex items-center justify-center space-x-2 bg-[#613ed9] text-white px-6 py-3 rounded-lg hover:bg-[#4c2db8] transition-colors font-semibold shadow-md hover:shadow-lg">
                <i class="bi bi-check-circle"></i>
                <span>Atualizar Notícia</span>
            </button>
        </div>
    </form>
</div>
@endsection

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', request()->routeIs('movies.*') ? 'Painel de Filmes' : 'Painel de Notícias')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
</head>
<body class="bg-gray-50 min-h-screen">
    <!-- Navigation -->
    <nav class="bg-[#613ed9] shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center">
                    @if(request()->routeIs('movies.*'))
                        <a href="{{ route('movies.index') }}" class="flex items-center space-x-2 text-white font-semibold text-lg hover:text-gray-200 transition-colors">
                            <i class="bi bi-film text-xl"></i>
                            <span>Painel de Filmes</span>
                        </a>
                    @else
                        <a href="{{ route('news.index') }}" class="flex items-center space-x-2 text-white font-semibold text-lg hover:text-gray-200 transition-colors">
                            <i class="bi bi-newspaper text-xl"></i>
                            <span>Painel de Notícias</span>
                        </a>
                    @endif
                </div>
                <div class="hidden md:flex items-center space-x-4">
                    @if(request()->routeIs('movies.*'))
                        {{-- Navegação para Filmes (sem features por enquanto) --}}
                    @else
                        {{-- Navegação para Notícias --}}
                        @if(!request()->routeIs('news.index'))
                            <a href="{{ route('news.index') }}" class="text-white hover:text-gray-200 px-3 py-2 rounded-md text-sm font-medium transition-colors flex items-center space-x-1">
                                <i class="bi bi-list-ul"></i>
                                <span>Listagem</span>
                            </a>
                        @endif
                        @if(!request()->routeIs('news.create') && !request()->routeIs('news.edit'))
                            <a href="{{ route('news.create') }}" class="bg-white text-[#613ed9] hover:bg-gray-100 px-4 py-2 rounded-lg text-sm font-medium transition-colors flex items-center space-x-1 shadow-sm">
                                <i class="bi bi-plus-circle"></i>
                                <span>Nova Notícia</span>
                            </a>
                        @endif
                    @endif
                </div>
                <!-- Mobile menu button -->
                <div class="md:hidden">
                    <button type="button" id="mobile-menu-button" class="text-white hover:text-gray-200 focus:outline-none focus:text-gray-200">
                        <i class="bi bi-list text-2xl"></i>
                    </button>
                </div>
            </div>
        </div>
        <!-- Mobile menu -->
        <div id="mobile-menu" class="hidden md:hidden bg-[#613ed9] border-t border-[#4c2db8]">
            <div class="px-2 pt-2 pb-3 space-y-1">
                @if(request()->routeIs('movies.*'))
                    {{-- Menu mobile para Filmes (sem features por enquanto) --}}
                @else
                    {{-- Menu mobile para Notícias --}}
                    @if(!request()->routeIs('news.index'))
                        <a href="{{ route('news.index') }}" class="text-white hover:bg-[#4c2db8] block px-3 py-2 rounded-md text-base font-medium flex items-center space-x-2">
                            <i class="bi bi-list-ul"></i>
                            <span>Listagem</span>
                        </a>
                    @endif
                    @if(!request()->routeIs('news.create') && !request()->routeIs('news.edit'))
                        <a href="{{ route('news.create') }}" class="bg-white text-[#613ed9] hover:bg-gray-100 block px-3 py-2 rounded-md text-base font-medium flex items-center space-x-2">
                            <i class="bi bi-plus-circle"></i>
                            <span>Nova Notícia</span>
                        </a>
                    @endif
                @endif
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @if(session('success'))
            <div class="mb-6 bg-green-50 border-l-4 border-green-500 text-green-700 p-4 rounded-r-lg shadow-sm" role="alert">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-2">
                        <i class="bi bi-check-circle text-xl"></i>
                        <p class="font-medium">{{ session('success') }}</p>
                    </div>
                    <button type="button" onclick="this.parentElement.parentElement.remove()" class="text-green-700 hover:text-green-900">
                        <i class="bi bi-x-lg"></i>
                    </button>
                </div>
            </div>
        @endif

        @if($errors->any())
            <div class="mb-6 bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded-r-lg shadow-sm" role="alert">
                <div class="flex items-start justify-between">
                    <div class="flex-1">
                        <div class="flex items-center space-x-2 mb-2">
                            <i class="bi bi-exclamation-triangle text-xl"></i>
                            <p class="font-semibold">Erro!</p>
                        </div>
                        <p class="mb-2">Por favor, corrija os erros abaixo:</p>
                        <ul class="list-disc list-inside space-y-1">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <button type="button" onclick="this.parentElement.parentElement.remove()" class="text-red-700 hover:text-red-900 ml-4">
                        <i class="bi bi-x-lg"></i>
                    </button>
                </div>
            </div>
        @endif

        @yield('content')
    </div>

    <script>
        // Mobile menu toggle
        document.getElementById('mobile-menu-button')?.addEventListener('click', function() {
            document.getElementById('mobile-menu')?.classList.toggle('hidden');
        });
    </script>
    @yield('scripts')
</body>
</html>

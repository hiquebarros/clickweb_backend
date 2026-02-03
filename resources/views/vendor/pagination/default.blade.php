@if ($paginator->hasPages())
    <nav class="flex items-center justify-center space-x-2" role="navigation" aria-label="Pagination Navigation">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <span class="px-3 py-2 text-gray-400 bg-gray-100 rounded-lg cursor-not-allowed" aria-disabled="true" aria-label="@lang('pagination.previous')">
                <i class="bi bi-chevron-left"></i>
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="px-3 py-2 text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 hover:border-[#613ed9] transition-colors" aria-label="@lang('pagination.previous')">
                <i class="bi bi-chevron-left"></i>
            </a>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <span class="px-3 py-2 text-gray-500">{{ $element }}</span>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="px-4 py-2 bg-[#613ed9] text-white rounded-lg font-semibold shadow-md" aria-current="page">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" class="px-4 py-2 text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-[#613ed9] hover:text-white hover:border-[#613ed9] transition-colors">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="px-3 py-2 text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 hover:border-[#613ed9] transition-colors" aria-label="@lang('pagination.next')">
                <i class="bi bi-chevron-right"></i>
            </a>
        @else
            <span class="px-3 py-2 text-gray-400 bg-gray-100 rounded-lg cursor-not-allowed" aria-disabled="true" aria-label="@lang('pagination.next')">
                <i class="bi bi-chevron-right"></i>
            </span>
        @endif
    </nav>
@endif

<!-- PAGINATION UNTUK MEMBERIKAN DATA SECARA TERATUR -->
<!-- DIGUNAKAN UNTUK TABLE YANG MENAMPILKAN DATA SECARA BERKALA -->

<div class="flex items-center justify-center">
    <!-- Previous Page Link -->
    @if ($paginator->onFirstPage())
        <span class="relative inline-flex items-center px-4 py-2 mr-2 text-sm font-medium text-gray-500 bg-gray-200 border border-gray-300 cursor-default leading-5 rounded-md">
            Previous
        </span>
    @else
        <a href="{{ $paginator->previousPageUrl() }}" class="relative inline-flex items-center px-4 py-2 mr-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 rounded-md hover:text-gray-500">
            Previous
        </a>
    @endif

    <!-- Pagination Elements -->
    @foreach ($elements as $element)
        <!-- "Three Dots" Separator -->
        @if (is_string($element))
            <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default leading-5 rounded-md">{{ $element }}</span>
        @endif

        <!-- Array Of Links -->
        @if (is_array($element))
            @foreach ($element as $page => $url)
                @if ($page == $paginator->currentPage())
                    <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-gray-200 border border-gray-300 cursor-default leading-5 rounded-md">{{ $page }}</span>
                @else
                    <a href="{{ $url }}" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 leading-5 rounded-md hover:text-gray-700">{{ $page }}</a>
                @endif
            @endforeach
        @endif
    @endforeach

    <!-- Next Page Link -->
    @if ($paginator->hasMorePages())
        <a href="{{ $paginator->nextPageUrl() }}" class="relative inline-flex items-center px-4 py-2 ml-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 rounded-md hover:text-gray-500">
            Next
        </a>
    @else
        <span class="relative inline-flex items-center px-4 py-2 ml-2 text-sm font-medium text-gray-500 bg-gray-200 border border-gray-300 cursor-default leading-5 rounded-md">
            Next
        </span>
    @endif
</div>
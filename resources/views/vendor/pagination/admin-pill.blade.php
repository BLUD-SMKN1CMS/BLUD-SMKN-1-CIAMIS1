@if ($paginator->hasPages())
    <nav class="admin-pagination-wrap" aria-label="Pagination Navigation">
        <ul class="admin-pagination">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="admin-page-item disabled" aria-disabled="true" aria-label="Previous">
                    <span class="admin-page-link" aria-hidden="true">‹</span>
                </li>
            @else
                <li class="admin-page-item">
                    <a class="admin-page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="Previous">‹</a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                @if (is_string($element))
                    <li class="admin-page-item disabled" aria-disabled="true"><span class="admin-page-link">{{ $element }}</span></li>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="admin-page-item active" aria-current="page"><span class="admin-page-link">{{ $page }}</span></li>
                        @else
                            <li class="admin-page-item"><a class="admin-page-link" href="{{ $url }}">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="admin-page-item">
                    <a class="admin-page-link" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="Next">›</a>
                </li>
            @else
                <li class="admin-page-item disabled" aria-disabled="true" aria-label="Next">
                    <span class="admin-page-link" aria-hidden="true">›</span>
                </li>
            @endif
        </ul>
    </nav>
@endif

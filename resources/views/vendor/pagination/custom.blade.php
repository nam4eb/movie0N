@if ($paginator->hasPages())
    <nav class="custom-pagination">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <span class="page-arrow disabled" aria-disabled="true">
                <i class="fas fa-arrow-left"></i>
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="page-arrow" rel="prev">
                <i class="fas fa-arrow-left"></i>
            </a>
        @endif

        <div class="page-input-wrapper">
            <form method="GET" action="{{ $paginator->url($paginator->currentPage()) }}" class="d-inline">
                @foreach (request()->query() as $key => $value)
                    @if ($key !== 'page')
                        <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                    @endif
                @endforeach
                <label for="page-input">Trang</label>
                <input id="page-input" type="number" name="page" value="{{ $paginator->currentPage() }}" min="1" max="{{ $paginator->lastPage() }}" class="page-input" aria-label="Go to page">
                <span>/ {{ $paginator->lastPage() }}</span>
            </form>
        </div>

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="page-arrow" rel="next">
                <i class="fas fa-arrow-right"></i>
            </a>
        @else
            <span class="page-arrow disabled" aria-disabled="true">
                <i class="fas fa-arrow-right"></i>
            </span>
        @endif
    </nav>
@endif


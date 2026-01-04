@if ($paginator->hasPages())
  @php
    $current = $paginator->currentPage();
    $last = $paginator->lastPage();

    // 数字は最大5個
    $start = max(1, $current - 2);
    $end = min($last, $start + 4);
    $start = max(1, $end - 4);
  @endphp

  <nav class="pagination" role="navigation" aria-label="Pagination Navigation">
    <ul class="pagination__list">

      {{-- Prev --}}
      @if ($paginator->onFirstPage())
        <li class="pagination__item is-disabled"><span aria-hidden="true">‹</span></li>
      @else
        <li class="pagination__item">
          <a href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="Previous">‹</a>
        </li>
      @endif

      {{-- Numbers --}}
      @for ($page = $start; $page <= $end; $page++)
        @if ($page === $current)
          <li class="pagination__item is-active"><span>{{ $page }}</span></li>
        @else
          <li class="pagination__item"><a href="{{ $paginator->url($page) }}">{{ $page }}</a></li>
        @endif
      @endfor

      {{-- Next --}}
      @if ($paginator->hasMorePages())
        <li class="pagination__item">
          <a href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="Next">›</a>
        </li>
      @else
        <li class="pagination__item is-disabled"><span aria-hidden="true">›</span></li>
      @endif

    </ul>
  </nav>
@endif
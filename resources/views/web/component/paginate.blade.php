@if ($paginator->hasPages())
    <!-- Pagination -->
    <div class="page-list">
        <ul class="page-list-wrap first">
            {{-- Previous Page Link --}}
            @if (!$paginator->onFirstPage())
                <li class="first-page">
                    <a href="{{ $paginator->toArray()['first_page_url'] }}">
                        {{trans('pagination.first')}}
                    </a>
                </li>
                <li class="prev-page">
                    <a href="{{ $paginator->previousPageUrl() }}">
                        {{trans('pagination.previous')}}
                    </a>
                </li>
            @endif
        </ul>
        <ul class="page-list-wrap number">
            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if($page == $paginator->currentPage() - 1 || $page == $paginator->currentPage() - 2)
                            <li><a href="{{ $url }}">{{ $page }}</a></li>
                        @elseif ($page == $paginator->currentPage())
                            <li><span class="active">{{ $page }}</span></li>
                        @elseif (($page == $paginator->currentPage() + 1) || ($page == $paginator->currentPage() + 2))
                            <li><a href="{{ $url }}">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach
        </ul>
        {{-- Next Page Link --}}
        <ul class="page-list-wrap last">
            @if ($paginator->hasMorePages())
                <li class="next-page">
                    <a href="{{ $paginator->nextPageUrl() }}">
                        {{trans('pagination.next')}}
                    </a>
                </li>
                <li class="last-page">
                    <a href="{{ $paginator->toArray()['last_page_url'] }}"> {{trans('pagination.last')}}</a>
                </li>
            @endif
        </ul>
    </div>
    <!-- Pagination -->
@endif

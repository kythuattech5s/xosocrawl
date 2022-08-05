@if ($paginator->hasPages())
    <div class="pagination">
        @if ($paginator->onFirstPage())
            <strong style="transform:scaleX(-1)"><i class="fa-solid fa-arrow-right" aria-hidden="true"></i></strong>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" title="" 
                style="transform:scaleX(-1)"><i class="fa-solid fa-arrow-right" aria-hidden="true"></i></a>
            @if (!in_array($paginator->currentPage(), [1, 2]))
                <a href="{{ $paginator->url(1) }}" >1</a></li>
                @if ($paginator->currentPage() !== 3)
                    <a style="pointer-events: none"> ... </a>
                @endif
            @endif
        @endif
        @foreach ($elements as $key => $element)
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <strong>{{ $page }}</strong>
                    @elseif($page == $paginator->currentPage() + 1 || $page == $paginator->currentPage() - 1)
                        <a href="{{ $url }}" >{{ $page }}</a></li>
                    @endif
                @endforeach
            @endif
        @endforeach
        @if ($paginator->hasMorePages())
            @if(!in_array($paginator->currentPage(),[$paginator->lastPage(),$paginator->lastPage()-1]))
                @if($paginator->currentPage() !== $paginator->lastPage()-2)
                <a style="pointer-events: none"> ... </a>
                @endif
                <a href="{{ $paginator->url($paginator->lastPage()) }}" >{{ $page }}</a></li>
            @endif
            <a class="next-page" href="{{ $paginator->nextPageUrl() }}"><i class="fa-solid fa-arrow-right" aria-hidden="true"></i></a>
        @else
            <strong><i class="fa-solid fa-arrow-right" aria-hidden="true"></i></strong>
        @endif
    </div>
@endif
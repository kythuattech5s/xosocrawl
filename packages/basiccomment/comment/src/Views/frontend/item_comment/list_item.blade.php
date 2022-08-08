@php
    use basiccomment\comment\ItemComment;
    $levelShow = $levelShow ?? 0;
    $showAllChilds = $showAllChilds ?? false;
@endphp
@if (isset($isPaginate) && $isPaginate)
    @if (isset($target) && $target != 0)
        @if ($listComment->total() > 5)
            <div class="pagination-comment-box view-old-comment">
                <div class="pagination-hidden-box">
                    {{$listComment->withQueryString()->links('basiccmt::vendor.pagination.pagination')}}
                </div>
                <p>{{$listComment->count()*$listComment->currentPage()}}/{{$listComment->total()}}</p>
            </div>
        @endif
    @endif
@endif
@if (isset($target) && $target != 0)
    @foreach ($listComment->reverse() as $item)
        @php
            $itemComment = new ItemComment;
            $itemComment->setCommentModel($item);
        @endphp
        @php
            echo $itemComment->toHtml($showAllChilds,$levelShow);
        @endphp
    @endforeach
@else
    @foreach ($listComment as $item)
        @php
            $itemComment = new ItemComment;
            $itemComment->setCommentModel($item);
        @endphp
        @php
            echo $itemComment->toHtml($showAllChilds,$levelShow);
        @endphp
    @endforeach
@endif

@if (isset($isPaginate) && $isPaginate)
    @if (isset($target) && $target == 0)
        @if ($listComment->total() > 5)
            <div class="pagination-comment-box">
                <div class="pagination-hidden-box">
                    {{$listComment->withQueryString()->links('basiccmt::vendor.pagination.pagination')}}
                </div>
                <p>{{$listComment->count()*$listComment->currentPage()}}/{{$listComment->total()}}</p>
            </div>
        @endif
    @endif
@endif

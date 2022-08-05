@php
    use basiccomment\comment\ItemComment;
    $levelShow = $levelShow ?? 0;
    $showAllChilds = $showAllChilds ?? false;
@endphp
@foreach ($listComment as $item)
    @php
        $itemComment = new ItemComment;
        $itemComment->setCommentModel($item);
    @endphp
    @php
        echo $itemComment->toHtml($showAllChilds,$levelShow);
    @endphp
@endforeach
@if (isset($isPaginate) && $isPaginate)
    @if ($listComment->total() > 5)
        <div class="pagination-comment-box">
            <div class="pagination-hidden-box">
                {{$listComment->withQueryString()->links('basiccmt::vendor.pagination.pagination')}}
            </div>
            <p>{{$listComment->count()*$listComment->currentPage()}}/{{$listComment->total()}}</p>
        </div>
    @endif
@endif
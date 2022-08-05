@if ($itemComment->count_like > 0)
    <div class="comment-count-like-wrapper">
        @php $countLoop = 0;@endphp
        <div class="represent">
            @foreach ($itemComment->getCountLikeStatical() as $key => $item)
                @if ($item > 0 && $countLoop < 3)
                    <div class="item-count-like item-count-like-{{$key}}"></div>
                @endif
                @php $countLoop++;@endphp
            @endforeach
        </div>
        @if ($itemComment->count_like > 1)
            <div class="count-like">{{$itemComment->count_like}}</div>
        @endif
    </div>
@endif
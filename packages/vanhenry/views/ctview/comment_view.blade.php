<td>
    @php
        $itemComment = basiccomment\comment\Models\Comment::find($itemMain->comment_id);
    @endphp
    @if (isset($itemComment))
        @php
            switch ($itemComment->map_table) {
                case 'forums':
                    $itemTarget = \App\Models\Forum::find($itemComment->map_id);
                    break;
                default:
                    break;
            }
        @endphp
        @if (isset($itemTarget))
            <a href="{{'esystem/edit/comments/'.$itemComment->id}}" class="btn btn-warning" style="margin-right: 2px;padding: 2px 12px;" target="_blank">Tắt kích hoạt <i class="fa fa-times" aria-hidden="true"></i></a>
            <a href="{{$itemTarget->slug.'?cmt='.$itemComment->id}}" class="btn btn-info" style="padding: 2px 12px" target="_blank">Đến <i class="fa fa-long-arrow-right" aria-hidden="true"></i></a>
            <div class="text-left" style="margin-top: 6px;border-radius: 5px;padding: 5px 10px;color: #fff;background-color: #343a40;">{!!$itemComment->content!!}</div>
        @else
            Bài đích không còn tồn tại.
        @endif
    @else
        Comment không còn tồn tại
    @endif
</td>
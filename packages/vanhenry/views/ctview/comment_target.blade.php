<td>
    @php
        switch ($itemMain->map_table) {
            case 'forums':
                $itemTarget = \App\Models\Forum::find($itemMain->map_id);
                break;
            default:
                break;
        }
    @endphp
    @if (isset($itemTarget))
        <a href="{{$itemTarget->slug.'?cmt='.$itemMain->id}}" class="btn btn-info" target="_blank">Đến <i class="fa fa-long-arrow-right" aria-hidden="true"></i></a>
    @else
        Bài đích không còn tồn tại.
    @endif
</td>
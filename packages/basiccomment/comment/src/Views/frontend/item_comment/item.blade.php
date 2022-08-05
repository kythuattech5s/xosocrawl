@php
    $authorUser = $itemComment->user;
    $isLogin = \Auth::check();
    $countChild = $itemComment->childs->count();
    $showChildAble = $itemComment->showBaseChildAble($showAllChilds,$levelShow,$countChild);
@endphp
<div class="item-comment-box off-reply{{$countChild > 0 ? ' have-child':''}} {{$showChildAble ? 'open':''}}">
    <div class="avartar">
        <a href="{{isset($authorUser) ? 'thong-tin-thanh-vien-c'.$authorUser->id:'javascript:void(0)'}}" class="c-img" title="{{isset($authorUser) ? $authorUser->fullname:$itemComment->name}}">
            @if (isset($authorUser) && $authorUser->img != '')
                <img src="{{$authorUser->getAvatarImageSrc()}}" alt="Default User Avartar">
            @else
                <img src="theme/frontend/images/default_avatar.gif" alt="Default User Avartar">
            @endif
        </a>
    </div>
    <div class="item-comment-content" item-cmt="{{$itemComment->id}}">
        <div class="inner-content {{\Auth::check() ? 'in-check':''}}">
            @if (\Auth::check())
                <div class="item-comment-support-action">
                    <div class="base-action-box-wrapper">
                        <div class="base-action-box">
                            <div class="item report-comment-btn" data-cmt="{{$itemComment->id}}">
                                <span>⚑</span>
                                <span>Báo cáo bình luận</span>
                            </div>
                        </div>
                    </div>
                    <div class="icon"><span style="font-size: 26px;">...</span></div>
                </div>
            @endif
            <div class="content-wraper">
                @if (count($itemComment->commentTag) > 0)
                    <div class="user-name-with-tag">
                        <p class="user-name"><a href="{{isset($authorUser) ? 'thong-tin-thanh-vien-c'.$authorUser->id:'javascript:void(0)'}}" class="smooth" title="{{isset($authorUser) && $authorUser->fullname != '' ? $authorUser->fullname:$itemComment->name}}">{{isset($authorUser) && $authorUser->fullname != '' ? $authorUser->fullname:$itemComment->name}}</a></p>
                        <span>Với</span>
                        @foreach ($itemComment->commentTag as $itemCommentTag)
                            <a href="thong-tin-thanh-vien-c{{$itemCommentTag->user->id}}" class="item-user-cmnt-tag" title="{{$itemCommentTag->user->fullname}}">{{$itemCommentTag->user->fullname}}</a>
                        @endforeach
                    </div>
                @else
                    <p class="user-name"><a href="{{isset($authorUser) ? 'thong-tin-thanh-vien-c'.$authorUser->id:'javascript:void(0)'}}" class="smooth" title="{{isset($authorUser) && $authorUser->fullname != '' ? $authorUser->fullname:$itemComment->name}}">{{isset($authorUser) && $authorUser->fullname != '' ? $authorUser->fullname:$itemComment->name}}</a></p>
                @endif
                <div class="user-comment">{!!$itemComment->content!!}</div>
            </div>
            <div class="item-comment-action-wrapper">
                <div class="item-comment-action-box">
                    <div class="like-action-box {{$isLogin ? '':'no-login'}}" cmt-like-box-idx="{{$itemComment->id}}">
                        <button class="like-comment-btn" data-type="1" show="{{$itemComment->showTypeLike()}}">Thích</button>
                    </div>
                    <button class="btn-reply-comment {{$isLogin ? '':'no-login'}}" type="button" target="{{$itemComment->id}}">Trả lời</button>
                    <span class="item-time">{{\basiccomment\comment\Helpers\CommentHelper::showTime($itemComment->created_at)}}</span>
                </div>
                <div class="comment-count-like" target="{{$itemComment->id}}">
                    @include('basiccmt::frontend.item_comment.count_like',['itemComment'=>$itemComment])
                </div>
            </div>
        </div>
        @if (!$showChildAble && $countChild >= 3)
            <button class="show-child-comment" target="{{$itemComment->id}}"><i class="fa-solid fa-share"></i> {{$countChild}} phản hồi</button>
        @endif
        <div class="list-child-comment" cmt-target="{{$itemComment->id}}">
            @if ($showChildAble)
                @php
                    $listChildComment = $itemComment->childs()->where('act',1)
                    ->with('user')
                    ->with(['commentTag'=>function($q){
                        $q->whereHas('user')->with('user');
                    }])
                    ->orderBy('created_at','asc')->get();
                @endphp
                @include('basiccmt::frontend.item_comment.list_item',['listComment'=>$listChildComment,'showAllChilds'=>$showAllChilds,'levelShow'=>$levelShow])
            @endif
        </div>
    </div>
</div>

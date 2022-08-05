@extends('index')
@section('cssl')
    <link rel="stylesheet" href="{{Support::asset('theme/frontend/css/fancybox.css')}}">
@endsection
@section('breadcrumb')
    {{Breadcrumbs::render('user',$user)}}
@endsection
@section('main')
<div class="mag10-5">
    <div class="fb-share-button fr mag-r5" data-href="{{url()->current()}}" data-layout="button" data-size="small">
        <a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u={{urldecode(url()->current())}}" class="fb-xfbml-parse-ignore">Chia sẻ</a>
    </div>
    <div class="clearfix"></div>
</div>
@include('forums.list_forum')
<div class="box box-customer ">
    <h2 class="tit-mien">Thông tin tài khoản</h2>
    <div class="customer-info clearfix">
        <div class="left-col">
            <div class="avatar">
                <a title="{{$user->fullname}}" href="{{$user->getAvatarImageSrc()}}" data-fancybox="gallery">
                    <img alt="{{$user->fullname}}" itemprop="image" src="{{$user->getAvatarImageSrc()}}"></a>
            </div>
        </div>
        <div class="right-col">
            <div class="full-name">
                <a href="thong-tin-thanh-vien-c{{$user->id}}" title="{{$user->fullname}}">{{$user->fullname}}</a>
            </div>
            <div>Thành viên | Hoạt động</div>
        </div>
        @if (Auth::check() && Auth::id() != $user->id)
            <div>
                <i class="icon ic-report"></i>
                <a id="report-link" data-id="{{$user->id}}">
                    <span> Báo cáo vi phạm</span>
                </a>
            </div>
        @endif
        <div class="clearfix"></div>
    </div>
    @if (Auth::check() && Auth::id() == $user->id)
        <div class="account-link">
            <ul class="list-unstyle">
                <li>
                    <i class="icon icon-edit"></i>
                    <a href="cap-nhat-tai-khoan" title="Thay đổi thông tin cá nhân">Thay đổi thông tin cá nhân</a>
                </li>
                <li>
                    <i class="icon icon-delete"></i>
                    <a href="delete-comment-history" title="Xóa lịch sử thảo luận">Xóa lịch sử thảo luận</a>
                </li>
                <li>
                    <i class="icon icon-door"></i>
                    <a href="dang-xuat" title="Thoát">Thoát</a>
                </li>
            </ul>
        </div>
    @endif
</div>
<div class="box">
    <div class="comment-history chat-box" id="chat-box">
        <h2 class="tit-mien">Lịch sử thảo luận</h2>
        <div class="comments"></div>
        <div class="view-more" style="display: none;">Xem thêm</div>
    </div>
</div>
@endsection
@section('jsl')
    <script type="module">
        import { Fancybox } from "/theme/frontend/js/fancybox.esm.js";
    </script>
@endsection
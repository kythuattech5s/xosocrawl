@extends('index')
@section('cssl')
    <link rel="stylesheet" href="{{Support::asset('theme/frontend/css/bootstrap.min.css')}}">
    @include('basiccmt::frontend.css')
@endsection
@section('breadcrumb')
    {{Breadcrumbs::render('forum', $currentItem)}}
@endsection
@section('main')
<div class="mag10-5">
    <div class="fb-share-button fr mag-r5" data-href="{{url()->current()}}" data-layout="button" data-size="small">
        <a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u={{urldecode(url()->current())}}" class="fb-xfbml-parse-ignore">Chia sẻ</a>
    </div>
    <div class="clearfix"></div>
</div>
@include('forums.list_forum',['activeForumId'=>$currentItem->id])
<div class="box">
    <h2 class="tit-mien bold">Box thảo luận</h2>
    @include('basiccmt::frontend.comment_box',['commentBoxId'=>$currentItem->id,'identifier'=>'forums','referrer'=>Support::show($currentItem,'slug')])
</div>
<div class="box box-html">
    {!!$currentItem->content!!}
</div>
@endsection
@section('jsl')
    <script src="theme/frontend/js/bootstrap.min.js" defer></script>
    <script type="text/javascript" src="{{ Support::asset('theme/frontend/js/jquery.3.4.1.min.js') }}"></script>
@endsection
@section('js')
    @include('basiccmt::frontend.js')
@endsection
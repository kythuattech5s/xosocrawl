@extends('index')
@section('breadcrumb')
    {{Breadcrumbs::render('predict_lottery_results', $currentItem,$currentItem->category)}}
@endsection
@section('main')
<div class="box box-detail pad10">
    <h1 class="s20"><strong>{{Support::show($currentItem,'name')}}</strong></h1>
    <div class="txt-center magb10"></div>
    <div class="cont-detail paragraph s-content" id="article-content">
        {!!Support::show($currentItem,'content')!!}
    </div>
    {{-- <div class="box list-chot-so">
        <h3 class="bold">Dự đoán mới nhất của các cao thủ hôm nay:</h3>
        <div class="box-body chat-box" id="chat-box">
            <div class="comments"></div>
            <div class="view-more ">Xem thêm</div>
        </div>
        <div class="clearfix"></div>
    </div> --}}
</div>
{{-- <div class="box box-news">
    <h3 class="tit-mien"><strong>Diễn đàn xổ số</strong></h3>
    <ul>
        <li><span class="ic"></span><a href="/dien-dan-xo-so.html" title="Diễn đàn xổ số">Box thảo luận</a></li>
    </ul>
</div> --}}
<div class="box box-news">
    <h3 class="tit-mien"><strong>Thảo luận kết quả xổ số</strong></h3>
    <div id="comment" class="fb-comments" data-href="{{url()->to($currentItem->slug)}}" data-width="100%" data-numposts="5"></div>
</div>
<div class="box box-news">
    <h3 class="tit-mien"><strong>Tiện ích</strong></h3>
    <ul>
        <li><span class="ic"></span><a href="so-mo-lo-de-mien-bac-so-mo-giai-mong" title="Sổ mơ">Sổ mơ</a></li>
        <li><span class="ic"></span><a href="thong-ke-lo-gan-xo-so-mien-bac-xsmb" title="Thống kê lô gan">Thống kê lô gan</a></li>
        <li><span class="ic"></span><a href="thong-ke-giai-dac-biet-xo-so-mien-bac-xsmb" title="Thống kê giải đặc biệt">Thống kê giải đặc biệt</a></li>
    </ul>
</div>
@endsection
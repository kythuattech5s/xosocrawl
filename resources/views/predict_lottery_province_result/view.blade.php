@extends('index')
@section('breadcrumb')
    {{Breadcrumbs::render('predict_lottery_province_results', $currentItem,$currentItem->category)}}
@endsection
@section('main')
<div class="box dudoantinh">
    <h2 class="s20 mag10 pad10"><strong>{{Support::show($currentItem,'show_name')}}</strong></h2>
    <div class="box-html cont-detail paragraph">
        {!!Support::show($currentItem,'content')!!}
    </div>
    <div class="see-more">
        <h3 class="tit-mien">
            <strong>Xem thêm dự đoán</strong>
        </h3>
        <ul class="list-html-link two-column">
            @foreach ($listDifferent as $item)
                <li>Xem thêm <span class="ic"></span>
                    <a href="{{Support::show($item,'slug')}}" title="Dự đoán {{Support::show($item,'province_name')}}">Dự đoán {{Support::show($item,'province_name')}}</a>
                </li>
            @endforeach
            @foreach ($listPredictLotteryResultCategory as $item)
                <li>Xem thêm <span class="ic"></span>
                    <a href="{{Support::show($item,'slug')}}" title="{{Support::show($item,'short_name')}}">{{Support::show($item,'short_name')}}</a>
                </li>
            @endforeach
        </ul>
    </div>
</div>
@endsection